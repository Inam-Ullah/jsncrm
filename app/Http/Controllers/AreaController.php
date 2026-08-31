<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_module')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        return view(theme('area.index'), [
            'author' => $author,
        ]);
    }

    public function insert(Request $request)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_add_new')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $request->validate([
            'type' => 'required|in:1,2,3',
            'name' => 'required|max:100',
        ]);

        $type = 'city';
        $parentId = null;

        if ($request->type == 2) {
            $type = 'area';
            $parentId = $request->city;
            $parent = Area::where('id', $parentId)->where('type', 'city')->first();

            if (!$parent) {
                return redirect()->back()->withInput()->withErrors([
                    'city' => 'Please select a valid city.',
                ]);
            }
        }

        if ($request->type == 3) {
            $type = 'sub_area';
            $parentId = $request->area;
            $city = Area::where('id', $request->city)->where('type', 'city')->first();
            $parent = Area::where('id', $parentId)
                ->where('type', 'area')
                ->where('parent_id', $request->city)
                ->first();

            if (!$city || !$parent) {
                return redirect()->back()->withInput()->withErrors([
                    'area' => 'Please select an area from the selected city.',
                ]);
            }
        }

        $duplicate = Area::where('type', $type)
            ->where('parent_id', $parentId)
            ->where('name', trim($request->name))
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()->withErrors([
                'name' => 'This location already exists.',
            ]);
        }

        $newArea = Area::create([
            'parent_id' => $parentId,
            'type' => $type,
            'name' => trim($request->name),
        ]);

        activity_log('Created location (' . ucfirst($type) . '): ' . $newArea->name, 'Area', $newArea->id);

        return redirect()->route('area')->with('success', 'Area Successfully Added');
    }

    public function edit($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_edit')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $area = Area::find($id);

        if (!$area) {
            return redirect()->route('area')->withErrors(['error' => 'Location not found.']);
        }

        return view(theme('area.edit'), [
            'author' => $author,
            'area' => $area,
        ]);
    }

    public function update(Request $request)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_edit')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $request->validate([
            'id' => 'required',
            'name' => 'required|max:100',
        ]);

        $area = Area::find($request->id);

        if (!$area) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Location not found.'], 404);
            }

            return redirect()->route('area')->withErrors(['error' => 'Location not found.']);
        }

        $duplicate = Area::where('type', $area->type)
            ->where('parent_id', $area->parent_id)
            ->where('name', trim($request->name))
            ->where('id', '!=', $area->id)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()->withErrors([
                'name' => 'This location already exists.',
            ]);
        }

        $area->update([
            'name' => trim($request->name),
        ]);

        activity_log('Updated location (' . ucfirst($area->type) . '): ' . $area->name, 'Area', $area->id);

        return redirect()->route('area')->with('success', 'Area Successfully Updated');
    }

    public function delete($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_delete')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $area = Area::find($id);

        if (!$area) {
            if (request()->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'Location not found.'], 404);
            }

            return redirect()->route('area')->withErrors(['error' => 'Location not found.']);
        }

        if ($area->children()->exists()) {
            return redirect()->back()->withErrors([
                'error' => 'Delete its child areas first.',
            ]);
        }

        $column = 'subarea_id';

        if ($area->type == 'city') {
            $column = 'city_id';
        }

        if ($area->type == 'area') {
            $column = 'area_id';
        }

        if (User::where($column, $area->id)->exists()) {
            return redirect()->back()->withErrors([
                'error' => 'This location is assigned to users and cannot be deleted.',
            ]);
        }

        activity_log('Deleted location (' . ucfirst($area->type) . '): ' . $area->name, 'Area', $area->id);
        $area->delete();

        return redirect()->route('area')->with('success', 'Area Deleted Successfully');
    }

    public function getCitiesByAjax(Request $request)
    {
        $cities = Area::where('type', 'city')->orderBy('name')->get();

        $html = '<option value="">' . __('select_city') . '</option>';

        foreach ($cities as $city) {
            $html .= '<option value="' . $city->id . '">' . e($city->name) . '</option>';
        }

        return response()->json($html);
    }

    public function getAreas(Request $request)
    {
        $author = auth()->user();

        if (!in_array($author->role_id, [1, 2]) && !permission('area_module')) {
            return [
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ];
        }

        $direction = $request->input('order.0.dir') == 'desc' ? 'desc' : 'asc';
        $locations = Area::orderBy('id', $direction)->get();
        $children = $locations->groupBy('parent_id');
        $rows = [];

        $cityCounts = User::whereNotNull('city_id')
            ->selectRaw('city_id, count(*) as total')
            ->groupBy('city_id')
            ->pluck('total', 'city_id');

        $areaCounts = User::whereNotNull('area_id')
            ->selectRaw('area_id, count(*) as total')
            ->groupBy('area_id')
            ->pluck('total', 'area_id');

        $subareaCounts = User::whereNotNull('subarea_id')
            ->selectRaw('subarea_id, count(*) as total')
            ->groupBy('subarea_id')
            ->pluck('total', 'subarea_id');

        foreach ($locations->where('type', 'city') as $city) {
            $rows[] = $this->areaRow($city, $cityCounts->get($city->id, 0), 0, $author);

            foreach ($children->get($city->id, collect())->where('type', 'area') as $area) {
                $rows[] = $this->areaRow($area, $areaCounts->get($area->id, 0), 1, $author);

                foreach ($children->get($area->id, collect())->where('type', 'sub_area') as $subarea) {
                    $rows[] = $this->areaRow($subarea, $subareaCounts->get($subarea->id, 0), 2, $author);
                }
            }
        }

        $total = count($rows);
        $start = intval($request->start);
        $length = intval($request->length);

        if ($length > 0) {
            $rows = array_slice($rows, $start, $length);
        }

        return [
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $rows,
        ];
    }

    public function getAreaByAjax(Request $request)
    {
        $cityId = $request->input('city') ?? $request->input('city_id');

        $html = '<option value="">' . __('select_area') . '</option>';

        if ($cityId) {
            $cityExists = Area::where('id', $cityId)->where('type', 'city')->exists();
            if (!$cityExists) {
                return response()->json(0);
            }

            $areas = Area::where('type', 'area')
                ->where('parent_id', $cityId)
                ->orderBy('name')
                ->get();

            foreach ($areas as $area) {
                $html .= '<option value="' . $area->id . '">' . e($area->name) . '</option>';
            }
        }

        return response()->json($html);
    }

    public function getSubAreaByAjax(Request $request)
    {
        $areaId = $request->input('area') ?? $request->input('area_id');

        $html = '<option value="">' . __('select_subarea') . '</option>';

        if ($areaId) {
            $areaExists = Area::where('id', $areaId)->where('type', 'area')->exists();
            if (!$areaExists) {
                return response()->json(0);
            }

            $subareas = Area::where('type', 'sub_area')
                ->where('parent_id', $areaId)
                ->orderBy('name')
                ->get();

            foreach ($subareas as $subarea) {
                $html .= '<option value="' . $subarea->id . '">' . e($subarea->name) . '</option>';
            }
        }

        return response()->json($html);
    }

    private function areaRow($area, $users, $level, $author)
    {
        $labels = [
            'city' => 'success',
            'area' => 'primary',
            'sub_area' => 'default',
        ];

        $type = $area->type == 'sub_area' ? 'Sub Area' : ucfirst($area->type);
        $prefix = str_repeat('&nbsp;', $level * 4);
        $label = $prefix.'<span class="label label-'.$labels[$area->type].'">'.e($type).'</span>';
        $actions = '';

        if (in_array($author->role_id, [1, 2]) || permission('area_edit')) {
            $actions .= '<a href="'.route('area.edit', $area->id).'" class="mr-5">';
            $actions .= '<span data-toggle="tooltip" title="Edit" class="label label-warning">';
            $actions .= '<i class="fas fa-edit"></i></span></a>';
        }

        if (in_array($author->role_id, [1, 2]) || permission('area_delete')) {
            $actions .= '<a class="delete area-delete" href="'.route('area.delete', $area->id).'">';
            $actions .= '<span data-toggle="tooltip" title="Delete" class="label label-danger">';
            $actions .= '<i class="fas fa-times-circle"></i></span></a>';
        }

        return [
            $area->id,
            $label,
            e($area->name),
            $users,
            $actions,
        ];
    }
}

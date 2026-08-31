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

        $cities = Area::where('type', 'city')->orderBy('name')->get();
        $areas = Area::where('type', 'area')->orderBy('name')->get();

        return view(theme('area.index'), [
            'author' => $author,
            'cities' => $cities,
            'areas' => $areas,
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
            $parent = Area::where('id', $parentId)->where('type', 'area')->first();

            if (!$parent) {
                return redirect()->back()->withInput()->withErrors([
                    'area' => 'Please select a valid area.',
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

        Area::create([
            'parent_id' => $parentId,
            'type' => $type,
            'name' => trim($request->name),
        ]);

        return redirect()->route('area')->with('success', 'Area Successfully Added');
    }

    public function edit($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_edit')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $area = Area::findOrFail($id);

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
            'id' => 'required|exists:areas,id',
            'name' => 'required|max:100',
        ]);

        $area = Area::findOrFail($request->id);

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

        return redirect()->route('area')->with('success', 'Area Successfully Updated');
    }

    public function delete($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2]) && !permission('area_delete')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $area = Area::findOrFail($id);

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

        $area->delete();

        return redirect()->route('area')->with('success', 'Area Deleted Successfully');
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

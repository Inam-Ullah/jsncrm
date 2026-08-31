<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Isp;
use App\Models\User;
use Illuminate\Http\Request;

class IspController extends Controller
{
    public function index()
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $isps = $author->role_id == 1 
            ? Isp::with(['city', 'user', 'users'])->get() 
            : Isp::where('user_id', auth()->id())->with(['city', 'user', 'users'])->get();

        $cities = Area::where('type', 'city')->orderBy('name')->get();

        return view(theme('isp.index'), [
            'author' => $author,
            'isps'   => $isps,
        ]);
    }

    public function insert(Request $request)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $request->validate([
            'company_name' => 'required|max:100',
            'poc_name'     => 'required|max:50',
            'mobile'       => 'required|max:30',
            'address'      => 'required|max:255',
            'city_id'      => 'required|exists:areas,id',
        ]);

        $isp = Isp::create([
            'company_name' => trim($request->company_name),
            'poc_name'     => trim($request->poc_name),
            'mobile'       => trim($request->mobile),
            'address'      => trim($request->address),
            'city_id'      => $request->city_id,
            'user_id'      => auth()->id(),
        ]);

        activity_log(
            'Created ISP: ' . $isp->company_name,
            'Isp',
            $isp->id
        );

        return redirect()->route('isp')->with('success', 'ISP Successfully Created');
    }

    public function edit($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $isp = Isp::find($id);

        if (!$isp) {
            return redirect()->route('isp')->withErrors(['error' => 'ISP record not found.']);
        }

        if ($author->role_id != 1 && $isp->user_id != auth()->id()) {
            return redirect()->route('isp')->withErrors(['error' => 'You are not authorized to edit this ISP.']);
        }

        return view(theme('isp.edit'), [
            'author' => $author,
            'isp'    => $isp,
        ]);
    }

    public function update(Request $request)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $request->validate([
            'id'           => 'required',
            'company_name' => 'required|max:100',
            'poc_name'     => 'required|max:50',
            'mobile'       => 'required|max:30',
            'address'      => 'required|max:255',
            'city_id'      => 'required|exists:areas,id',
        ]);

        $isp = Isp::find($request->id);

        if (!$isp) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'ISP record not found.'], 404);
            }

            return redirect()->route('isp')->withErrors(['error' => 'ISP record not found.']);
        }

        if ($author->role_id != 1 && $isp->user_id != auth()->id()) {
            return redirect()->route('isp')->withErrors(['error' => 'You are not authorized to update this ISP.']);
        }

        $isp->update([
            'company_name' => trim($request->company_name),
            'poc_name'     => trim($request->poc_name),
            'mobile'       => trim($request->mobile),
            'address'      => trim($request->address),
            'city_id'      => $request->city_id,
        ]);

        activity_log(
            'Updated ISP: ' . $isp->company_name,
            'Isp',
            $isp->id
        );

        return redirect()->route('isp')->with('success', 'ISP Successfully Updated');
    }

    public function delete($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $isp = Isp::find($id);

        if (!$isp) {
            if (request()->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'ISP record not found.'], 404);
            }

            return redirect()->route('isp')->withErrors(['error' => 'ISP record not found.']);
        }

        if ($author->role_id != 1 && $isp->user_id != auth()->id()) {
            return redirect()->route('isp')->withErrors(['error' => 'You are not authorized to delete this ISP.']);
        }

        if ($isp->users()->exists()) {
            return redirect()->back()->withErrors([
                'error' => 'Users exist on this ISP and it cannot be deleted.',
            ]);
        }

        if ($isp->invoices()->exists()) {
            return redirect()->back()->withErrors([
                'error' => 'Invoices exist on this ISP and it cannot be deleted.',
            ]);
        }

        activity_log(
            'Deleted ISP: ' . $isp->company_name,
            'Isp',
            $isp->id
        );

        $isp->delete();

        return redirect()->route('isp')->with('success', 'ISP Successfully Deleted');
    }
}

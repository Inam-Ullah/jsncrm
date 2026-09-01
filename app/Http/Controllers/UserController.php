<?php

namespace App\Http\Controllers;

use App\Models\Isp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($roleName)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        $roles = $isps = [];
        $addPermission = false;
        $resellerRole = [2, 3, 4, 5, 6];

        switch ($roleName) {
            case 'admin':
                if ($author->role_id != 1) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }

                $addPermission = true;
                $roles = Role::whereNotIn('id', [1, 2, 3, 4, 5, 6, 7])->get();
                $isps  = Isp::all();

                break;
            case 'franchise':
                if ($author->role_id != 2 && !permission('franchise_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = $author->role_id == 2 || permission('franchise_add_new');
                break;
            case 'dealer':
                if (!in_array($author->role_id, [2, 3]) && !permission('dealer_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = $author->role_id == 3 || permission('dealer_add_new');
                break;
            case 'subdealer':
                if (!in_array($author->role_id, [2, 3, 4]) && !permission('subdealer_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = $author->role_id == 4 || permission('subdealer_add_new');
                break;
            case 'reseller':
                if (!in_array($author->role_id, [2, 3, 4, 5]) && !permission('reseller_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = $author->role_id == 5 || permission('reseller_add_new');
                break;
            case 'staff':
                if (!in_array($author->role_id, $resellerRole) && !permission('staff_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = in_array($author->role_id, $resellerRole) || permission('staff_add_new');
                break;
            default:
                if (!in_array($author->role_id, $resellerRole) && !permission('user_module')) {
                    return redirect()->back()->withErrors(['error' => $msg]);
                }
                $addPermission = in_array($author->role_id, $resellerRole) || permission('user_add_new');
        }

        return view(theme('user.index'), [
            'author'        => $author,
            'roleName'      => $roleName,
            'addPermission' => $addPermission,
            'roles'         => $roles,
            'isps'          => $isps,
        ]);
    }

    public function insert(Request $request, $roleName)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $clean = trim(str_replace(['-', '_'], ' ', $roleName));
        $role = Role::where('name', 'LIKE', $clean)
            ->orWhere('name', 'LIKE', $clean . '%')
            ->first();

        if (!$role && is_numeric($clean)) {
            $role = Role::find($clean);
        }

        if (!$role) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid role requested.']);
        }

        $request->validate([
            'ispid'    => 'required|exists:isps,id',
            'name'     => 'required|max:100',
            'username' => 'required|max:50|unique:users,username',
            'password' => 'required|min:6',
            'nic'      => 'required|max:30',
            'mobile'   => 'required|max:30',
            'email'    => 'required|email|max:100|unique:users,email',
            'address'  => 'required|max:255',
            'city_id'  => 'required|exists:areas,id',
        ]);

        $user = User::create([
            'role_id'    => $role->id,
            'isp_id'     => $request->ispid,
            'city_id'    => $request->city_id,
            'name'       => $request->name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'nic'        => $request->nic,
            'phone'      => $request->phone,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'address'    => $request->address,
            'status'     => 1,
            'created_by' => auth()->id(),
            'admin_id'   => $author->role_id == 1 ? auth()->id() : ($author->admin_id ?? auth()->id()),
        ]);

        activity_log(
            'Created ' . $role->name . ': ' . $user->name,
            'User',
            $user->id
        );

        return redirect()->route('team', $roleName)->with('success', $role->name . ' Successfully Added');
    }

    public function edit($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Team user record not found.']);
        }

        if ($author->role_id != 1 && $user->created_by != auth()->id()) {
            return redirect()->route('home')->withErrors(['error' => 'You are not authorized to edit this record.']);
        }

        $isps = $author->role_id == 1
            ? Isp::orderBy('company_name')->get()
            : Isp::where('user_id', auth()->id())->orderBy('company_name')->get();

        return view(theme('user.edit'), [
            'author' => $author,
            'user'   => $user,
            'isps'   => $isps,
        ]);
    }

    public function update(Request $request)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $user = User::find($request->id);

        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Team user record not found.']);
        }

        if ($author->role_id != 1 && $user->created_by != auth()->id()) {
            return redirect()->route('home')->withErrors(['error' => 'You are not authorized to update this record.']);
        }

        $request->validate([
            'id'       => 'required|exists:users,id',
            'ispid'    => 'required|exists:isps,id',
            'name'     => 'required|max:100',
            'username' => 'required|max:50|unique:users,username,' . $user->id,
            'nic'      => 'required|max:30',
            'phone'    => 'required|max:30',
            'email'    => 'required|email|max:100|unique:users,email,' . $user->id,
            'address'  => 'required|max:255',
            'city_id'  => 'required|exists:areas,id',
        ]);

        $data = [
            'isp_id'   => $request->ispid,
            'city_id'  => $request->city_id,
            'name'     => trim($request->name),
            'username' => trim($request->username),
            'nic'      => trim($request->nic),
            'phone'    => trim($request->phone),
            'mobile'   => trim($request->mobile),
            'email'    => trim($request->email),
            'address'  => trim($request->address),
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        activity_log(
            'Updated ' . ($user->role->name ?? 'User') . ': ' . $user->name,
            'User',
            $user->id
        );

        $roleSlug = strtolower(optional($user->role)->name ?? 'admin');
        if ($roleSlug == 'sales person') {
            $roleSlug = 'sales';
        }

        return redirect()->route('team', $roleSlug)->with('success', 'User Successfully Updated');
    }

    public function delete($id)
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if (!in_array($author->role_id, [1, 2])) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Team user record not found.']);
        }

        if ($author->role_id != 1 && $user->created_by != auth()->id()) {
            return redirect()->route('home')->withErrors(['error' => 'You are not authorized to delete this record.']);
        }

        if ($user->ownedIsps()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete user because they own active ISP records.']);
        }

        $roleSlug = strtolower(optional($user->role)->name ?? 'admin');
        if ($roleSlug == 'sales person') {
            $roleSlug = 'sales';
        }

        activity_log(
            'Deleted ' . ($user->role->name ?? 'User') . ': ' . $user->name,
            'User',
            $user->id
        );

        $user->delete();

        return redirect()->route('team', $roleSlug)->with('success', 'User Successfully Deleted');
    }
}

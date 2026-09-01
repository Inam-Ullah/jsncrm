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

        $users = $author->role_id == 1
            ? User::where('role_id', $role->id)->with(['city', 'isp', 'role'])->orderBy('id', 'desc')->get()
            : User::where('role_id', $role->id)->where('created_by', auth()->id())->with(['city', 'isp', 'role'])->orderBy('id', 'desc')->get();

        $isps = $author->role_id == 1
            ? Isp::orderBy('company_name')->get()
            : Isp::where('user_id', auth()->id())->orderBy('company_name')->get();

        return view(theme('user.index'), [
            'author'   => $author,
            'roleName' => $roleName,
            'role'     => $role,
            'users'    => $users,
            'isps'     => $isps,
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
            'phone'    => 'required|max:30',
            'email'    => 'required|email|max:100|unique:users,email',
            'address'  => 'required|max:255',
            'city_id'  => 'required|exists:areas,id',
        ]);

        $user = User::create([
            'role_id'    => $role->id,
            'isp_id'     => $request->ispid,
            'city_id'    => $request->city_id,
            'name'       => trim($request->name),
            'username'   => trim($request->username),
            'password'   => Hash::make($request->password),
            'nic'        => trim($request->nic),
            'phone'      => trim($request->phone),
            'mobile'     => trim($request->phone),
            'email'      => trim($request->email),
            'address'    => trim($request->address),
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
            'mobile'   => trim($request->phone),
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

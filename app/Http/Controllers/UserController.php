<?php

namespace App\Http\Controllers;

use App\Models\Isp;
use App\Models\Ledger;
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
                $addPermission = in_array($author->role_id, $resellerRole) || permission('staff_create');
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

    public function getTeamByAjax(Request $request)
    {
        $author = auth()->user();
        $roleName = strtolower(trim($request->roleName));
        $allowed = false;
        $roleIds = [];

        switch ($roleName) {
            case 'admin':
                $allowed = $author->role_id == 1;
                $roleIds = [2];
                break;
            case 'franchise':
                $allowed = $author->role_id == 2 || permission('franchise_module');
                $roleIds = [3];
                break;
            case 'dealer':
                $allowed = in_array($author->role_id, [2, 3]) || permission('dealer_module');
                $roleIds = [4];
                break;
            case 'subdealer':
                $allowed = in_array($author->role_id, [2, 3, 4]) || permission('subdealer_module');
                $roleIds = [5];
                break;
            case 'reseller':
                $allowed = in_array($author->role_id, [2, 3, 4, 5]) || permission('reseller_module');
                $roleIds = [6];
                break;
            case 'staff':
                $allowed = in_array($author->role_id, [2, 3, 4, 5, 6]) || permission('staff_module');
                $roleIds = Role::whereNotIn('id', [1, 2, 3, 4, 5, 6, 7])->pluck('id')->toArray();
                break;
            default:
                $roleName = 'user';
                $allowed = in_array($author->role_id, [2, 3, 4, 5, 6]) || permission('user_module');
                $roleIds = [7];
                break;
        }

        if (!$allowed) {
            return [
                'draw' => intval($request->draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ];
        }

        $query = User::whereIn('role_id', $roleIds)
            ->with(['admin', 'franchise', 'dealer', 'subdealer', 'city'])
            ->addSelect([
                'current_balance' => Ledger::select('balance_after')
                    ->whereColumn('user_id', 'users.id')
                    ->latest('id')
                    ->limit(1),
            ]);

        if ($author->role_id == 2) {
            $query->where('admin_id', $author->id);
        } elseif ($author->role_id == 3) {
            $query->where('franchise_id', $author->id);
        } elseif ($author->role_id == 4) {
            $query->where('dealer_id', $author->id);
        } elseif ($author->role_id == 5) {
            $query->where('subdealer_id', $author->id);
        } elseif ($author->role_id == 6) {
            $query->where('reseller_id', $author->id);
        } elseif ($author->role_id != 1) {
            if ($author->reseller_id) {
                $query->where('reseller_id', $author->reseller_id);
            } elseif ($author->subdealer_id) {
                $query->where('subdealer_id', $author->subdealer_id);
            } elseif ($author->dealer_id) {
                $query->where('dealer_id', $author->dealer_id);
            } elseif ($author->franchise_id) {
                $query->where('franchise_id', $author->franchise_id);
            } else {
                $query->where('admin_id', $author->admin_id);
            }
        }

        $recordsTotal = (clone $query)->count();
        $search = trim($request->input('search.value'));

        if ($search) {
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%');
            });
        }

        $recordsFiltered = (clone $query)->count();
        $direction = $request->input('order.0.dir') == 'asc' ? 'asc' : 'desc';
        $start = max(0, intval($request->start));
        $length = intval($request->length);

        if ($length < 1) {
            $length = 25;
        }

        $users = $query->orderBy('id', $direction)->skip($start)->take($length)->get();
        $rows = [];

        foreach ($users as $user) {
            $row = [];
            $row[] = $user->id;
            $row[] = '<img class="profile_photo" src="' . photo($user->photo) . '" alt="' . e($user->username) . '">';
            $row[] = '<span class="label label-default">' . e($user->name) . '</span>'
                . '<span class="label label-success ml-5">' . e($user->username) . '</span>';

            if (in_array($roleName, ['franchise', 'dealer', 'subdealer', 'reseller'])) {
                $row[] = e(optional($user->admin)->name ?? __('N/A'));
            }

            if (in_array($roleName, ['dealer', 'subdealer', 'reseller'])) {
                $row[] = e(optional($user->franchise)->name ?? __('N/A'));
            }

            if (in_array($roleName, ['subdealer', 'reseller'])) {
                $row[] = e(optional($user->dealer)->name ?? __('N/A'));
            }

            if ($roleName == 'reseller') {
                $row[] = e(optional($user->subdealer)->name ?? __('N/A'));
            }

            $row[] = $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : __('N/A');
            $row[] = e(optional($user->city)->name ?? __('N/A'));

            if (in_array($roleName, ['franchise', 'dealer', 'subdealer', 'reseller'])) {
                $row[] = $user->nas_id ?? __('N/A');
                $row[] = number_format($user->current_balance ?? 0, 2);
            }

            $childColumn = 'admin_id';

            if ($user->role_id == 3) {
                $childColumn = 'franchise_id';
            } elseif ($user->role_id == 4) {
                $childColumn = 'dealer_id';
            } elseif ($user->role_id == 5) {
                $childColumn = 'subdealer_id';
            } elseif ($user->role_id == 6) {
                $childColumn = 'reseller_id';
            }

            $row[] = User::where($childColumn, $user->id)->where('role_id', 7)->count();

            $actions = '<a href="' . route('team.edit', $user->id) . '" class="mr-5">'
                . '<span data-toggle="tooltip" title="' . __('edit') . '" class="label label-warning">'
                . '<i class="fas fa-edit"></i></span></a>';
            $actions .= '<a class="delete user-delete" href="' . route('team.delete', $user->id) . '">'
                . '<span data-toggle="tooltip" title="' . __('delete') . '" class="label label-danger">'
                . '<i class="fas fa-times-circle"></i></span></a>';
            $row[] = $actions;
            $rows[] = $row;
        }

        return [
            'draw' => intval($request->draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows,
        ];
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

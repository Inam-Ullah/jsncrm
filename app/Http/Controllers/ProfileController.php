<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index()
    {
        $author = auth()->user();

        $permissions = [
            'change_photo' => true,
            'edit_profile' => true,
            'change_password' => true,
            'add_document' => true,
            'add_note' => true,
            'view_documents' => true,
            'view_activity' => true,
            'view_hierarchy_counters' => false,
            'view_financial_summary' => false,
            'view_package_summary' => false,
        ];

        $stats = [
            'users' => 0,
            'admins' => 0,
            'staff' => 0,
            'franchises' => 0,
            'dealers' => 0,
            'subdealers' => 0,
            'resellers' => 0,
        ];

        if ($author->role_id == 1) {
            $roleName = 'Super Admin';
            $permissions['view_hierarchy_counters'] = true;
            $permissions['view_financial_summary'] = true;
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 2) {
            $roleName = 'Admin';
            $permissions['view_hierarchy_counters'] = true;
            $permissions['view_financial_summary'] = true;
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 3) {
            $roleName = 'Franchise';
            $permissions['view_hierarchy_counters'] = true;
            $permissions['view_financial_summary'] = true;
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 4) {
            $roleName = 'Dealer';
            $permissions['view_hierarchy_counters'] = true;
            $permissions['view_financial_summary'] = true;
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 5) {
            $roleName = 'Subdealer';
            $permissions['view_hierarchy_counters'] = true;
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 6) {
            $roleName = 'Reseller';
            $permissions['view_package_summary'] = true;
        } elseif ($author->role_id == 7) {
            $roleName = 'Customer';
            $permissions['add_note'] = false;
            $permissions['view_activity'] = false;
        } elseif ($author->role_id == 8) {
            $roleName = 'Supervisor';
        } elseif ($author->role_id == 9) {
            $roleName = 'Sales Person';
        } elseif ($author->role_id == 10) {
            $roleName = 'Accounts';
            $permissions['view_financial_summary'] = true;
        } elseif ($author->role_id == 11) {
            $roleName = 'Support';
        } elseif ($author->role_id == 12) {
            $roleName = 'Recovery';
        } else {
            $roleName = 'User';
        }

        return view('theme1.profile.index', [
            'author' => $author,
            'roleName' => $roleName,
            'permissions' => $permissions,
            'stats' => $stats,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $author     = auth()->user();
        $permission = optional($author->role->permission);

        return view('theme1.dashboard.index', [
            'author'     => $author,
            'permission' => $permission,
        ]);
    }
}

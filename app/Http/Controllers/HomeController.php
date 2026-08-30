<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $author = auth()->user();

        return view('theme1.dashboard.index', [
            'author' => $author,
            'setting' => setting(),
        ]);
    }
}

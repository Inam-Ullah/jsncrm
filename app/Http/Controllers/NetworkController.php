<?php

namespace App\Http\Controllers;

use App\Models\Nas;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index()
    {
        $author = auth()->user();
        $msg = 'You are not eligible to access this module.';

        if ($author->role_id != 2 && !permission('network_module')) {
            return redirect()->back()->withErrors(['error' => $msg]);
        }

        $nases = Nas::all();

        return view(theme('network.index'), [
            'author' => $author,
            'nases' => $nases
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function changePassword(Request $request)
    {
        return redirect()->back();
    }

    public function changePhoto(Request $request)
    {
        return redirect()->back();
    }

    public function addNote(Request $request)
    {
        return redirect()->back();
    }

    public function addDocument(Request $request)
    {
        return redirect()->back();
    }

    public function deleteDocument($id)
    {
        return redirect()->back();
    }

    public function checkUsername(Request $request)
    {
        return response()->json(['status' => true]);
    }
}

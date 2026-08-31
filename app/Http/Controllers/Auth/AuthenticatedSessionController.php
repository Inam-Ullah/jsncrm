<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        $setting = setting();
        $view = "auth.theme{$setting->login_theme}.login";

        return view($view, [
            'setting' => $setting,
        ]);
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        auth()->user()->update([
            'last_login_at' => now(),
        ]);

        activity_log('User logged in', 'User', auth()->id());

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy()
    {
        $request = request();

        auth()->user()->update([
            'last_logout_at' => now(),
        ]);

        activity_log('User logged out', 'User', auth()->id());

        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

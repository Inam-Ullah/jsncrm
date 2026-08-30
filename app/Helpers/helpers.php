<?php

use App\Models\Setting;
if (!function_exists('setting')) {
    function setting()
    {
        $requestUrl = rtrim(request()->getSchemeAndHttpHost(), '/');
        $requestHost = strtolower(request()->getHost());

        $setting = Setting::where('domain_url', $requestUrl)->orWhere('domain_url', $requestHost)->first();

        $setting = $setting ?? Setting::first();

        if (auth()->check()) {
            $authUser = auth()->user();

            if (in_array($authUser->role_id, [1, 2])) {
                $userSetting = Setting::where('user_id', $authUser->id)->first();
                $setting = $userSetting ?? $setting;
            } else {
                $adminSetting = Setting::where('user_id', $authUser->admin_id)->first();
                $setting = $adminSetting ?? $setting;
            }
        }

        return $setting;
    }
}

if (!function_exists('logo')) {
    function logo()
    {
        $setting = setting();
        $theme = $theme ?? 'theme'.($setting->login_theme ?? 1);
        $filename = basename($setting->logo ?? '');
        $file = $theme.'/assets/images/final/'.$filename;

        if ($filename && file_exists(public_path($file))) {
            return asset($file);
        }

        return asset($theme.'/assets/system/images/logo.png');
    }
}

if (!function_exists('favicon')) {
    function favicon()
    {
        $setting = setting();
        $theme = $theme ?? 'theme'.($setting->login_theme ?? 1);
        $filename = basename($setting->favicon ?? '');
        $file = $theme.'/assets/images/final/'.$filename;

        if ($filename && file_exists(public_path($file))) {
            return asset($file);
        }

        return asset($theme.'/assets/system/images/favicon.png');
    }
}

if (!function_exists('background')) {
    function background()
    {
        $hour = date('H');

        if ($hour <= 3) {
            $background = 1;
        } elseif ($hour <= 6) {
            $background = 2;
        } elseif ($hour <= 9) {
            $background = 3;
        } elseif ($hour <= 12) {
            $background = 4;
        } elseif ($hour <= 15) {
            $background = 5;
        } elseif ($hour <= 18) {
            $background = 6;
        } elseif ($hour <= 21) {
            $background = 7;
        } else {
            $background = 8;
        }

        return $background;
    }
}

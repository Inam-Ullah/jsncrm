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

if (!function_exists('permission')) {
    function permission($module)
    {
        $permission = optional(auth()->user()->role->permission);

        return $permission->{$module};
    }
}

if (!function_exists('shortName')) {
    function shortName() {
        $name = trim(setting()->name ?? config('app.name'));

        $words = preg_split('/\s+/', $name);

        if (count($words) === 1) {
            $shortName = strtoupper(substr($words[0], 0, 1));
        } else {
            $shortName = strtoupper(
                substr($words[0], 0, 1) .
                substr($words[1], 0, 1)
            );
        }
        return $shortName;
    }
}

if (!function_exists('timezone')) {
    function timezone() {
        return setting()->timezone ?? config('app.timezone');
    }
}

if (!function_exists('photo')) {
    function photo($str)
    {
        if ($str) {
            $path = public_path('theme1/assets/images/final/' . $str);

            if (file_exists($path)) {
                return asset('theme1/assets/images/final/' . $str);
            }
        }

        return asset('theme1/assets/system/images/user.png');
    }
}

if (!function_exists('langFlag')) {
    function langFlag($str)
    {
        if ($str) {
            $file = strtolower(trim($str)) . '.png';

            $path = public_path(
                'theme1/assets/system/images/language/' . $file
            );

            if (file_exists($path)) {
                return asset(
                    'theme1/assets/system/images/language/' . $file
                );
            }
        }

        return asset(
            'theme1/assets/system/images/language/english.png'
        );
    }
}

if (!function_exists('theme')) {
    function theme($str)
    {
        if(setting()->dashboard_theme && setting()->dashboard_theme != 0) {
            $theme = 'theme' . setting()->dashboard_theme . '.' . $str;
        } else {
            $theme = 'theme1.' . $str;
        }
        return $theme;
    }
}

if (!function_exists('activity_log')) {
    function activity_log($activity, $targetType = null, $targetId = null, $againstUserId = null)
    {
        return \App\Models\ActivityLog::create([
            'action_by_id'    => auth()->id(),
            'against_user_id' => $againstUserId,
            'activity'        => substr($activity, 0, 255),
            'target_type'     => $targetType ? (is_object($targetType) ? get_class($targetType) : $targetType) : null,
            'target_id'       => $targetId ?? (is_object($targetType) ? optional($targetType)->id : null),
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
        ]);
    }
}

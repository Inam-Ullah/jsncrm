<?php

namespace App\View\Components;

use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public $branding = [];

    public function __construct()
    {
        $settings = setting();

        $this->branding = [
            'settings' => $settings,
            'name' => $settings?->name ?: config('app.name', 'JSN'),
            'slogan' => $settings?->slogan ?: 'Secure ISP management, simplified.',
            'logo_url' => $this->assetUrl($settings?->logo, 'images/branding/default-logo.png'),
            'favicon_url' => $this->assetUrl($settings?->favicon, 'images/branding/default-favicon.png'),
        ];
    }

    public function render()
    {
        return view('layouts.guest');
    }

    private function assetUrl($filename, $fallback)
    {
        $filename = basename(trim($filename ?? ''));

        if ($filename !== '') {
            foreach ([
                'storage/branding/'.$filename,
                'storage/'.$filename,
                'images/branding/'.$filename,
            ] as $relativePath) {
                if (File::exists(public_path($relativePath))) {
                    return asset($relativePath);
                }
            }
        }

        return asset($fallback);
    }
}

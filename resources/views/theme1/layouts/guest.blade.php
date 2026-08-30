<!DOCTYPE html>
<html lang="{{ setting()->user->lang }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#071a2f">

    <title>{{ $branding['name'] ?? config('app.name', 'JSN') }} · Secure Login</title>
    <link rel="icon" href="{{ $branding['favicon_url'] ?? asset('images/branding/default-favicon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-slate-950 font-sans text-slate-900 antialiased">
    <div class="auth-shell">
        <aside class="auth-hero" aria-label="Portal information">
            <div class="auth-orb auth-orb-one"></div>
            <div class="auth-orb auth-orb-two"></div>

            <div class="relative z-10 flex h-full flex-col">
                <a href="{{ url('/') }}" class="inline-flex w-fit items-center gap-3"
                    aria-label="{{ $branding['name'] ?? 'JSN' }} home">
                    <span
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-cyan-950/30 ring-1 ring-white/30">
                        <img src="{{ $branding['logo_url'] ?? asset('images/branding/default-logo.png') }}"
                            alt="{{ $branding['name'] ?? 'JSN' }} logo" class="h-full w-full object-contain">
                    </span>
                    <span>
                        <span class="block text-lg font-extrabold tracking-tight text-white">{{ $branding['name'] ??
                            'JSN' }}</span>
                        <span class="block text-xs font-medium tracking-[0.18em] text-cyan-200/80">ISP OPERATIONS</span>
                    </span>
                </a>

                <div class="my-auto max-w-xl py-16">
                    <span class="auth-kicker">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_14px_rgba(52,211,153,0.9)]"></span>
                        Unified management portal
                    </span>

                    <h1 class="mt-7 text-4xl font-extrabold leading-[1.12] tracking-[-0.035em] text-white xl:text-6xl">
                        Every connection.<br>
                        <span class="text-gradient">One secure view.</span>
                    </h1>

                    <p class="mt-6 max-w-lg text-base leading-7 text-slate-300 xl:text-lg">
                        {{ $branding['slogan'] ?? 'Manage subscribers, billing, network policies and support from one
                        role-aware workspace.' }}
                    </p>

                    <div class="mt-10 grid max-w-lg gap-4 sm:grid-cols-3">
                        <div class="auth-feature">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 3 4.5 6v5.2c0 4.7 3.1 8.9 7.5 9.8 4.4-.9 7.5-5.1 7.5-9.8V6L12 3Zm0 4.1a2.2 2.2 0 1 1 0 4.4 2.2 2.2 0 0 1 0-4.4Zm3.8 8.9H8.2v-.8c0-1.6 1.7-2.8 3.8-2.8s3.8 1.2 3.8 2.8v.8Z" />
                            </svg>
                            <span>Role-aware</span>
                        </div>
                        <div class="auth-feature">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M5 4h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-5l-2 3-2-3H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm2 4v2h10V8H7Zm0 4v2h7v-2H7Z" />
                            </svg>
                            <span>Live support</span>
                        </div>
                        <div class="auth-feature">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M4 19h16v2H4v-2Zm1-3 4.2-4.2 3 3L18 9v3h2V5h-7v2h3.6l-4.4 4.4-3-3L3.6 14 5 16Z" />
                            </svg>
                            <span>Real-time data</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-white/10 pt-6 text-xs text-slate-400">
                    <span>Protected by encrypted sessions</span>
                    <span>{{ now()->format('Y') }} · {{ $branding['name'] ?? 'JSN' }}</span>
                </div>
            </div>
        </aside>

        <main class="auth-main">
            <div class="auth-mobile-brand">
                <img src="{{ $branding['logo_url'] ?? asset('images/branding/default-logo.png') }}"
                    alt="{{ $branding['name'] ?? 'JSN' }} logo"
                    class="h-12 w-12 rounded-xl bg-white object-contain p-1.5 shadow-sm">
                <div>
                    <p class="font-bold text-slate-900">{{ $branding['name'] ?? 'JSN' }}</p>
                    <p class="text-xs text-slate-500">Unified management portal</p>
                </div>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs leading-5 text-slate-500 lg:text-sm">
                Authorized access only. Activity may be logged for account security.
            </p>
        </main>
    </div>
</body>

</html>

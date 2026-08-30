<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->name }} | {{ $setting->slogan }}</title>
    <link rel="icon" type="image/png" href="{{ favicon('theme2') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('theme2/assets/themes/theme_1/css/nucleo.css') }}">
    <link rel="stylesheet" href="{{ asset('theme2/assets/themes/theme_1/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme2/assets/themes/theme_1/css/argon.css') }}">
    <link rel="stylesheet" href="{{ asset('theme2/assets/css/login.css') }}">

    @if ($setting->captcha_enabled && $setting->captcha_site_key)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

</head>

<body class="bg-default">
    <div class="main-content">
        <div class="header py-3 py-lg-3 pt-lg-5">
            <div class="container">
                <div class="col-xl-6 col-lg-6 col-md-6 offset-xl-3 offset-lg-3 offset-md-3">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                            <span class="alert-text"><strong>Success!</strong> {{ session('status') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="ni ni-support-16"></i></span>
                            <span class="alert-text"><strong>Error!</strong> {{ $errors->first() }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                </div>

                <div class="header-body text-center">
                    <div class="row justify-content-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 px-5">
                            <h1 class="text-lead text-white mb-3">
                                <img class="mx-auto d-block img-fluid rounded theme-login-logo" src="{{ logo('theme2') }}" alt="{{ $setting->name }} logo">
                            </h1>
                            <h1 class="text-lead text-white mb-3 theme-brand-title"><strong>{{ $setting->name }} | {{ $setting->slogan }}</strong></h1>
                            <h3 class="text-lead text-white">Login</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                @csrf

                                <div class="form-group mb-3">
                                    <label class="form-control-label" for="login">Username</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ni ni-email-83"></i></span></div>
                                        <input id="login" class="form-control" name="login" type="text" value="{{ old('login') }}" placeholder="Enter username or email" autocomplete="username" autofocus required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="password">Password</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span></div>
                                        <input id="password" class="form-control" name="password" type="password" placeholder="Enter password" autocomplete="current-password" required>
                                    </div>
                                </div>

                                @if ($setting->captcha_enabled && $setting->captcha_site_key)
                                    <div class="form-group">
                                        <label class="form-control-label">Captcha</label>
                                        <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_site_key }}"></div>
                                    </div>
                                @endif

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-2" id="footer-main">
        <div class="container">
            <div class="copyright text-center text-muted">
                {{ $setting->name }} | {{ $setting->slogan }}
                @if ($setting->copyright) | {{ $setting->copyright }} @endif
                @if ($setting->jsntext)
                    | JSN ISP CRM By <a href="https://projectworlds.com/" target="_blank" rel="noopener">Projectworlds</a>
                @endif
            </div>
        </div>
    </footer>

    <script src="{{ asset('theme2/assets/themes/theme_1/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme2/assets/themes/theme_1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme2/assets/themes/theme_1/js/js.cookie.js') }}"></script>
    <script src="{{ asset('theme2/assets/themes/theme_1/js/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('theme2/assets/themes/theme_1/js/jquery-scrollLock.min.js') }}"></script>
    <script src="{{ asset('theme2/assets/themes/theme_1/js/argon.js') }}"></script>
</body>

</html>

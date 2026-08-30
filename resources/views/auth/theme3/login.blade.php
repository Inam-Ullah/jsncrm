<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->name }} | {{ $setting->slogan }}</title>
    <link rel="icon" type="image/png" href="{{ favicon('theme3') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="{{ asset('theme3/assets/themes/theme_2/css/nucleo-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme3/assets/themes/theme_2/css/blk-design-system-pro.css') }}" rel="stylesheet">
    <link href="{{ asset('theme3/assets/css/login.css') }}" rel="stylesheet">

    @if ($setting->captcha_enabled && $setting->captcha_site_key)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

</head>

<body class="login-page">
    <div class="squares square1"></div>
    <div class="squares square2"></div>
    <div class="squares square3"></div>
    <div class="squares square4"></div>
    <div class="squares square5"></div>
    <div class="squares square6"></div>

    <div class="page-header">
        <div class="page-header-image"></div>
        <div class="container">
            <div class="col-xl-6 col-lg-6 col-md-6 offset-xl-3 offset-lg-3 offset-md-3 theme-login-alerts">
                @if (session('status'))
                    <div class="alert alert-success alert-with-icon">
                        <button type="button" class="close" data-dismiss="alert"><i class="tim-icons icon-simple-remove"></i></button>
                        <span data-notify="icon" class="tim-icons icon-bell-55"></span>
                        <span><b>Success!</b> {{ session('status') }}</span>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-with-icon">
                        <button type="button" class="close" data-dismiss="alert"><i class="tim-icons icon-simple-remove"></i></button>
                        <span data-notify="icon" class="tim-icons icon-support-17"></span>
                        <span><b>Error!</b> {{ $errors->first() }}</span>
                    </div>
                @endif
            </div>

            <h1 class="text-center theme-brand-logo-row">
                <img class="mx-auto d-block img-fluid rounded theme-login-logo" src="{{ logo('theme3') }}" alt="{{ $setting->name }} logo">
            </h1>
            <h1 class="text-center theme-brand-title"><strong>{{ $setting->name }} | {{ $setting->slogan }}</strong></h1>
            <h4 class="text-center theme-login-label">Login</h4>

            <div class="col-lg-5 col-md-8 mx-auto">
                <div class="card card-login mt-3">
                    <form class="form" method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        <div class="card-header">
                            <img class="card-img" src="{{ asset('theme3/assets/themes/theme_2/img/square-purple-1.png') }}" alt="Card background">
                            <h4 class="card-title">Login</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-group input-lg">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="tim-icons icon-single-02"></i></span></div>
                                <input class="form-control" name="login" type="text" value="{{ old('login') }}" placeholder="Enter username or email" autocomplete="username" autofocus required>
                            </div>
                            <div class="input-group input-lg">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="tim-icons icon-caps-small"></i></span></div>
                                <input class="form-control" name="password" type="password" placeholder="Enter password" autocomplete="current-password" required>
                            </div>

                            @if ($setting->captcha_enabled && $setting->captcha_site_key)
                                <div class="input-group input-lg">
                                    <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_site_key }}"></div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $setting->name }} | {{ $setting->slogan }}
                    @if ($setting->copyright) | {{ $setting->copyright }} @endif
                    @if ($setting->jsntext)
                        | JSN ISP CRM By <a href="https://projectworlds.com/" target="_blank" rel="noopener">Projectworlds</a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('theme3/assets/themes/theme_2/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('theme3/assets/themes/theme_2/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('theme3/assets/themes/theme_2/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme3/assets/themes/theme_2/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('theme3/assets/themes/theme_2/js/blk-design-system-pro.min.js') }}"></script>
</body>

</html>

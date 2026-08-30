<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->name }} | {{ $setting->slogan }}</title>
    <link rel="icon" type="image/png" href="{{ favicon('theme1') }}">

    <link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/css/jqueryconfirm.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/css/rubikfont.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/themes/legacy/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('theme1/assets/css/login.css') }}" rel="stylesheet">

    <script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @if ($setting->captcha_enabled && $setting->captcha_site_key)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

</head>

<body id="access_page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ session('status') }}
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row theme-login-brand">
            <div class="col-md-12 text-center">
                <h1 class="theme-login-heading">
                    <img class="theme-login-logo" src="{{ logo('theme1') }}" alt="{{ $setting->name }} logo">
                    <strong>{{ $setting->name }} | {{ $setting->slogan }}</strong>
                </h1>
                <h4><strong>Login</strong></h4>
            </div>
        </div>

        <div class="row theme-login-panel">
            <div class="col-md-6 col-md-offset-3">
                <form class="form-horizontal form-label-left" method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">
                            Username <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input
                                id="login"
                                class="form-control col-md-7 col-xs-12"
                                name="login"
                                type="text"
                                value="{{ old('login') }}"
                                placeholder="Enter username, email or phone"
                                autocomplete="username"
                                autofocus
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">
                            Password <span class="required">*</span>
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <input
                                id="password"
                                class="form-control col-md-7 col-xs-12"
                                name="password"
                                type="password"
                                placeholder="Enter password"
                                autocomplete="current-password"
                                required>
                        </div>
                    </div>

                    @if ($setting->captcha_enabled && $setting->captcha_site_key)
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                Captcha <span class="required">*</span>
                            </label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_site_key }}"></div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-jsn">
                                <i class="fas fa-lock"></i> Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row theme-login-footer">
            <div class="col-md-12">
                <p class="text-center">
                    {{ $setting->name }} | {{ $setting->slogan }}
                    @if ($setting->copyright)
                        | {{ $setting->copyright }}
                    @endif
                    @if ($setting->jsntext)
                        | JSN ISP CRM By <a href="https://projectworlds.com/" target="_blank" rel="noopener">Projectworlds</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
</body>

</html>

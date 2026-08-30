<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->name }} | {{ $setting->slogan }}</title>
    <link rel="icon" type="image/png" href="{{ favicon('theme4') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="{{ asset('theme4/assets/themes/theme_3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme4/assets/themes/theme_3/css/now-ui-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('theme4/assets/css/login.css') }}" rel="stylesheet">

    @if ($setting->captcha_enabled && $setting->captcha_site_key)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

</head>

<body class="login-page sidebar-mini">
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page section-image" filter-color="black" data-image="{{ asset('theme4/assets/themes/theme_3/img/bg'.background().'.jpg') }}">
            <div class="content">
                <div class="container">
                    <div class="col-xl-6 col-lg-6 col-md-6 offset-xl-3 offset-lg-3 offset-md-3">
                        @if (session('status'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                <span><b>Success!</b> {{ session('status') }}</span>
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert"><i class="now-ui-icons ui-1_simple-remove"></i></button>
                                <span><b>Error!</b> {{ $errors->first() }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4 ml-auto mr-auto">
                        <form class="form" method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf
                            <div class="card card-login card-plain">
                                <div class="card-header">
                                    <div class="logo-container">
                                        <img class="mx-auto d-block img-fluid rounded theme-login-logo" src="{{ logo('theme4') }}" alt="{{ $setting->name }} logo">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-center">Login</h6>
                                    <div class="input-group no-border form-control-lg">
                                        <span class="input-group-prepend"><span class="input-group-text"><i class="now-ui-icons users_circle-08"></i></span></span>
                                        <input class="form-control" name="login" type="text" value="{{ old('login') }}" placeholder="Enter username or email" autocomplete="username" autofocus required>
                                    </div>
                                    <div class="input-group no-border form-control-lg mb-3">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="now-ui-icons text_caps-small"></i></span></div>
                                        <input class="form-control" name="password" type="password" placeholder="Enter password" autocomplete="current-password" required>
                                    </div>

                                    @if ($setting->captcha_enabled && $setting->captcha_site_key)
                                        <div class="input-group form-control-lg">
                                            <div class="g-recaptcha" data-sitekey="{{ $setting->captcha_site_key }}"></div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="text-center" id="copyright">
                        {{ $setting->name }} | {{ $setting->slogan }}
                        @if ($setting->copyright) | {{ $setting->copyright }} @endif
                        @if ($setting->jsntext)
                            | JSN ISP CRM By <a href="https://projectworlds.com/" target="_blank" rel="noopener">Projectworlds</a>
                        @endif
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('theme4/assets/themes/theme_3/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('theme4/assets/themes/theme_3/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('theme4/assets/themes/theme_3/js/core/bootstrap.min.js') }}"></script>
    <script>
        $(function () {
            var page = $('.full-page');
            var image = page.data('image');

            if (image) {
                page.append('<div class="full-page-background" style="background-image: url(' + image + ')"></div>');
            }
        });
    </script>
</body>

</html>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ setting()->name ?? config('app.name') }} | {{ setting()->slogan ?? 'ISP Management' }}</title>

<link rel="apple-touch-icon" href="{{ favicon() }}">
<link rel="icon" href="{{ favicon() }}">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/font-awesome/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/build/css/custom.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/datatable.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/custom.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/rubikfont.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/chosen.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/jqueryconfirm.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/css/bootstraptoggle.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/news-ticker-acme/assets/css/style.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme1/assets/themes/legacy/js/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
<script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('theme1/assets/themes/legacy/dashboard/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme1/assets/themes/legacy/js/jquery.countdown.min.js') }}"></script>

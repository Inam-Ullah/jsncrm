<!DOCTYPE html>
<html lang="{{ $author->lang ?? app()->getLocale() }}">
<head>
    @include('theme1.layouts.partials.head')
    @yield('styles')
</head>
<body class="nav-md">
    <div class="loading" id="loading">
        <img src="{{ asset('theme1/assets/system/images/loading.svg') }}" alt="Loading">
    </div>

    <div class="container body">
        <div class="main_container">
            @include('theme1.layouts.partials.sidebar')
            @include('theme1.layouts.partials.navbar')

            @yield('content')

            @include('theme1.layouts.partials.footer')
        </div>
    </div>

    @include('theme1.layouts.partials.scripts')
    @yield('scripts')
</body>
</html>

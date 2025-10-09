<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
<head>
            <link rel="icon" href="{{ asset('files/img/logo2.png') }}" type="image/x-icon">

    @include('layouts.back_front.head')
    @stack('styles')
</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.back_front.navigation_new')
    @include('layouts.back_front.main_menu')
    <!-- Page Heading
            @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
{{ $header }}
        </div>
    </header>
@endisset
    -->
    <!-- Page Content -->
    <main>
        <div class="app-content content">
            {{ $slot }}
        </div>

    </main>
</div>
@include('layouts.back_front.footer')
@include('layouts.back_front.scripts')
@stack('scripts')
<script>
    var isRtl = $('html').attr('data-textdirection') === 'rtl';
    var userName = "{{ auth()->user()->name }}";
</script>

</body>
</html>

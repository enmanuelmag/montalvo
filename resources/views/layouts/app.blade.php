<!DOCTYPE html>
<html class="loading" lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">
    <head>
        @include('layouts.head')
        
        <!-- Google Analytics con carga diferida y no bloqueante -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-24VZ4ZK9KL"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-24VZ4ZK9KL');
        </script>
    </head>
    <body class="vertical-layout vertical-menu-modern navbar-floating footer-static menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation_new')
            @include('layouts.main_menu')
            
            <!-- Page Content -->
            <main>
                <div class="app-content content">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        @include('layouts.footer')
        
        <!-- Scripts al final para mejor rendimiento -->
        @include('layouts.scripts')
    </body>
</html>
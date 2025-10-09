<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-24VZ4ZK9KL"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-24VZ4ZK9KL');
        </script>
        <meta charset="utf-8">
        <title>{{ config('app.name_landing', 'Sistema') }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
        <meta name="description" content="Sistema Web de la compañia Montalvo Mining Cursos Academicos y Capacitación Continua.">
        <meta name="keywords" content="Montalvo Mining Web Site">
        <meta name="author" content="TEAMSOFT ECUA">
        <meta name="csrf-token" content="{{ csrf_token() }}">
                <link rel="icon" href="{{ asset('files/img/logo2.png') }}" type="image/x-icon">
       
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('layout_2.head')
        
        <style>
            .carousel-item img {
                object-fit: contain; /* Asegura que la imagen completa se vea */
                height: 300px; /* Puedes ajustar este tamaño según necesites */
                width: 100%; /* Asegura que la imagen se ajuste al ancho del contenedor */
            }
        </style>
    </head>
    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        @include('layout_2.components.topbar')
        <div class="container-fluid position-relative p-0">
            @include('layout_2.nav')
            <!--
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            -->
            {{ $slot }}

            @include('layout_2.footer')
        </div>

        @include('layout_2.scripts')
        
         <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Configura un retraso de 5 segundos antes de que comience a moverse
                setTimeout(function() {
                    var carouselElement = document.querySelector('#testimonialCarousel');
                    var carousel = new bootstrap.Carousel(carouselElement, {
                        interval: 2500,  // Tiempo entre imágenes
                        ride: 'carousel'  // Iniciar automáticamente después del retraso
                    });
                }, 5000);  // Retraso de 5 segundos antes de iniciar el carrusel
            });
        </script>
    </body>
</html>

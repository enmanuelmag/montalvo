<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=1,minimal-ui">
    <meta name="description" content="Sistema Administrativo para manejar la Pagina Web Informativa de Montalvo Mining">
    <meta name="keywords" content="Montalvo Mining Web Site">
    <meta name="author" content="TEAMSOFT ECUA">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Montalvo') }}</title>

    <!-- Preconexiones a dominios externos para establecer conexiones temprano -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS críticos inline (estilos esenciales para la primera renderización) -->
    <style>
        /* Aquí coloca los estilos críticos extraídos de tus CSS principales */
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.45;
            color: #6e6b7b;
            background-color: #f8f8f8;
        }
        .header-navbar {
            background-color: #fff;
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
        }
        /* Otros estilos críticos para la primera renderización */
    </style>

    <!-- Precarga de CSS críticos -->
    <link rel="preload" href="{{ asset('app-assets/css/bootstrap.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('app-assets/css/components.min.css') }}" as="style">

    <!-- Google Fonts optimizado -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Figtree:wght@400;500;600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Figtree:wght@400;500;600&display=swap"></noscript>

    <!-- CSS principales con carga optimizada -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/bootstrap.min.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('app-assets/css/components.min.css') }}" media="print" onload="this.media='all'">

    <!-- CSS bundles optimizados con carga diferida -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/vendor-bundle.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('app-assets/css/theme-bundle.css') }}" media="print" onload="this.media='all'">

    <!-- CSS personalizado con carga diferida -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" media="print" onload="this.media='all'">

    <!-- Script para navegadores que no soportan la carga diferida mediante el atributo onload -->
    <script>
        // Polyfill para navegadores antiguos que no admiten el atributo onload en los enlaces
        !function(e){"use strict";if(!e.loadCSS){e.loadCSS=function(){}}var t=loadCSS.relpreload={};t.support=function(){var t;try{t=e.document.createElement("link").relList.supports("preload")}catch(e){t=false}return function(){return t}}();t.bindMediaToggle=function(e){var t=e.media||"all";function a(){e.media=t}if(e.addEventListener){e.addEventListener("load",a)}else if(e.attachEvent){e.attachEvent("onload",a)}setTimeout(function(){e.rel="stylesheet";e.media="only x"});setTimeout(a,3e3)};t.poly=function(){if(t.support()){return}var a=e.document.getElementsByTagName("link");for(var n=0;n<a.length;n++){var o=a[n];if(o.rel==="preload"&&o.getAttribute("as")==="style"&&!o.getAttribute("data-loadcss")){o.setAttribute("data-loadcss",true);t.bindMediaToggle(o)}}};if(!t.support()){t.poly();var a=e.setInterval(t.poly,500);if(e.addEventListener){e.addEventListener("load",function(){t.poly();e.clearInterval(a)})}else if(e.attachEvent){e.attachEvent("onload",function(){t.poly();e.clearInterval(a)})}}}}(typeof global!=="undefined"?global:this);
    </script>

    <!-- Fallback para navegadores que no soportan JavaScript -->
    <noscript>
        <link rel="stylesheet" href="{{ asset('app-assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/css/components.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/css/vendor-bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/css/theme-bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Figtree:wght@400;500;600&display=swap">
    </noscript>
<!-- Agregar en el <head> para precargar la primera imagen -->
@if(count($general) > 0)
    <link 
        rel="preload" 
        href="{{ asset($general[0]->imagen ?? '') }}" 
        as="image"
        fetchpriority="high">
@endif
    <!-- Scripts procesados con Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
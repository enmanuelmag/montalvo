<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/pages/top_bar/datatable.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/dragula.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-drag-drop.min.css') }}">
           <style>
            /* Para mejorar el espaciado de los elementos en la lista */
            .list-group-item {
                cursor: grab;
                padding: 15px;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                background-color: #f9f9f9;
            }

            /* Para el estado cuando se está arrastrando */
            .gu-mirror {
                position: absolute;
                pointer-events: none;
                z-index: 9999;
                opacity: 0.8;
                transform: rotate(3deg);
                background-color: #f0f0f0;
            }

            /* Mientras un elemento está en transición a su nuevo lugar */
            .gu-transit {
                opacity: 0.5;
                background-color: #e0e0e0;
            }

            /* Clase opcional para ocultar el elemento original cuando arrastras el duplicado */
            .gu-hide {
                display: none !important;
            }
        </style>

@endpush
        @include('backend.nav.modal_menus')
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-body">
                @include('backend.nav.ordenamiento')

                <!-- Basic multiple Column Form section start -->
                @include('backend.nav.table_nav')
            </div>
        </div>
            @push('scripts')
            <script>
                var datatable = "{{ route('datatableNav') }}";
                var saveNav = "{{ route('nav.save') }}";
                var updateNav = "{{ route('nav.update') }}";
                var deleteNav =  "{{ url('nav.destroy') }}";
                var ordenamientoNav =  "{{ url('nav.ordenamiento') }}";
            </script>
            @include('layouts.back_front.scripts_datatable')
            <script src="{{ asset('app-assets/vendors/js/extensions/dragula.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
            <script src="{{ asset('app-assets/pages/nav.js') }}"></script>
        @endpush
</x-admin-layout>

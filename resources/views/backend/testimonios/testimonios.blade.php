<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/pages/top_bar/datatable.css') }}">
        <style>
            .preview-image {
                width: 100%;
                height: 200px; /* Ajusta la altura según sea necesario */
                object-fit: cover; /* Ajusta la imagen para que cubra el área especificada */
                margin-bottom: 10px;
            }
        </style>
    @endpush
    @include('backend.testimonios.modal')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Basic multiple Column Form section start -->
            @include('backend.testimonios.from')
            @include('backend.testimonios.table')
        </div>
    </div>

    @push('scripts')
        <script>
            var url = "{{ route('testimonioSeccion.update') }}";
            var datatable = "{{ route('datatableTestimonios') }}";
            var saveFormulario = "{{ route('testimonios_item.save') }}";
            var updateFormularioItem = "{{ route('testimonios.update') }}";
            var deleteFormularioItem = "{{ url('testimonios.destroy') }}";

        </script>
        @include('layouts.back_front.scripts_datatable')
        <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('app-assets/pages/testimonios.js') }}"></script>
    @endpush
</x-admin-layout>

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
    @include('backend.about.modal_about')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Basic multiple Column Form section start -->
            @include('backend.about.from')
            @include('backend.about.table_about')
        </div>
    </div>

    @push('scripts')
        <script>
            var url = "{{ route('top_bar.update') }}";
            var datatable = "{{ route('datatableNosotros') }}";
            var saveFormulario = "{{ route('nosotros.save') }}";
            var saveFormularioItem = "{{ route('nosotros_item.save') }}";
            var updateFormularioItem = "{{ route('nosotros_item.update') }}";
            var deleteFormularioItem = "{{ url('nosotros.destroy') }}";

        </script>
        @include('layouts.back_front.scripts_datatable')
        <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('app-assets/pages/about.js') }}"></script>
    @endpush
</x-admin-layout>

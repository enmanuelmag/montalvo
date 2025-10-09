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
    @include('backend.galeria.modal_galeria')

    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Basic multiple Column Form section start -->
            @include('backend.galeria.from')
            @include('backend.galeria.table_galeria')
        </div>
    </div>

    @push('scripts')
        <script>
            var url = "{{ route('top_bar.update') }}";
            var datatableGaleria = "{{ route('datatableGaleria') }}";
            var updateGaleria = "{{ route('update.galeria') }}";

            var saveItemGaleria = "{{ route('save.item.galeria') }}";
            var updateItemGaleria = "{{ route('update.item.galeria') }}";
            var deleteItemGaleria = "{{ url('destroy.galeria') }}";

        </script>
        @include('layouts.back_front.scripts_datatable')
        <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('app-assets/pages/galeria.js') }}"></script>
    @endpush
</x-admin-layout>

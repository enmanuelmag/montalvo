<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app-assets/pages/top_bar/datatable.css') }}">
    @endpush
    @include('backend.top_bar.modal_redes')
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">

            <div class="content-body">
                <!-- Basic multiple Column Form section start -->

                @include('backend.top_bar.table_redes')
            </div>
        </div>

    @push('scripts')
        <script>
            var url = "{{ route('top_bar.update') }}";
            var datatableSocialMedia = "{{ route('datatableSocialMedia') }}";
            var saveSocialMedia = "{{ route('saveSocialMedia') }}";
            var updateSocialMedia = "{{ route('redes-sociales.update') }}";
            var deleteSocialMedia = "{{ url('redes-sociales.destroy') }}";

        </script>
           @include('layouts.back_front.scripts_datatable')
            <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('app-assets/pages/top_bar.js') }}"></script>
    @endpush
</x-admin-layout>

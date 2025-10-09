<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-wizard.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jquery.rateyo.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-ratings.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-file-uploader.min.css') }}">

        <style>
            .preview-image {
                width: 100%;
                height: 200px; /* Ajusta la altura según sea necesario */
                object-fit: cover; /* Ajusta la imagen para que cubra el área especificada */
                margin-bottom: 10px;
            }
            .select2-container {
                width: 100% !important;
            }
            /* Asegura que el ícono de la flecha esté bien alineado */
            .select2-container .select2-selection--single .select2-selection__arrow {
                top: 50%; /* Centrar verticalmente */
                transform: translateY(-50%); /* Mantener centrado en todos los tamaños */
                right: 5px; /* Ajusta el margen derecho si es necesario */
            }

            /* Ajustar ancho del contenedor de selección */
            .select2-container .select2-selection--single {
                height: 38px; /* Ajusta la altura para que coincida con otros campos de entrada */
                border-radius: 4px; /* Opcional: si quieres bordes más redondeados */
                border: 1px solid #ced4da; /* Estilo del borde */
            }
        </style>
    @endpush
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Basic multiple Column Form section start -->
            @include('backend.capacitaciones.from_item_edit')
        </div>
    </div>

    @push('scripts')
        <script>
            var url = "{{ route('capacitaciones_item.update') }}";

        </script>
        <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/extensions/jquery.rateyo.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/file-uploaders/dropzone.min.js') }}"></script>

        <script src="{{ asset('app-assets/pages/capactitaciones_item_edit.js') }}"></script>
    @endpush
</x-admin-layout>

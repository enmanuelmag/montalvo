<x-admin-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.min.css') }}">

        <style>
            .preview-image {
                width: 100%;
                height: 200px; /* Ajusta la altura según sea necesario */
                object-fit: cover; /* Ajusta la imagen para que cubra el área especificada */
                margin-bottom: 10px;
            }
        </style>
    @endpush


    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">

        <div class="content-body">
            <!-- Basic multiple Column Form section start -->
            @include('backend.blogs.from_item_blog')
        </div>
    </div>

    @push('scripts')
        <script>
            var url = "{{ route('blogsSeccion.update') }}";

        </script>
        <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
            <script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
        <script src="{{ asset('app-assets/pages/blogs_item.js') }}"></script>
    @endpush
</x-admin-layout>

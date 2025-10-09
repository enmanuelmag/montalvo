<!-- Scripts JS optimizados y con carga diferida -->
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" defer></script>

<!-- Cargar condicionalmente solo los scripts que realmente necesitas -->
@if(request()->routeIs('dashboard'))
    <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}" defer></script>
@endif

<!-- Scripts fundamentales -->
<script src="{{ asset('app-assets/js/core/app-menu.js') }}" defer></script>
<script src="{{ asset('app-assets/js/core/app.js') }}" defer></script>

<!-- Inicialización de Feather Icons -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    });
</script>
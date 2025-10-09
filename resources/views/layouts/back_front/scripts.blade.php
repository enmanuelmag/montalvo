<!-- BEGIN: Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/axios.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('app-assets/js/core/app.js') }}"></script>
<!-- END: Theme JS-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }

        setTimeout(function () {
            toastr['success'](
                'Bienvenido al Administrador Web de Montalvo Mining!',
                '👋 '+ userName+ '!',
                {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: isRtl
                }
            );
        }, 2000);

    });
    $(document).ready(function() {
        // Seleccionar todos los enlaces dentro de los elementos de menú
        var menuItems = $('.navigation-main .nav-item > a');

        // Agregar un evento de clic a cada enlace del menú
        menuItems.on('click', function(e) {
            // Remover la clase 'active' de todos los elementos del menú
            $('.navigation-main .nav-item').removeClass('active');

            // Agregar la clase 'active' al elemento clicado
            $(this).closest('.nav-item').addClass('active');
        });
    });
</script>

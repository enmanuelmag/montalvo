<x-app-layout>
    <div class="container py-5 pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Estado del Pago</h4>
                    </div>
                    <div class="card-body">
                        <!-- Detalles del pago -->
                        <div class="mb-4">
                            <h5>Detalles de la Transacción</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Curso:</th>
                                        <td>{{ $pago->curso_nombre }}</td>
                                    </tr>
                                    <tr>
                                        <th>Monto:</th>
                                        <td>${{ number_format($pago->valor, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Referencia:</th>
                                        <td>{{ $pago->referencia }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Mensaje de verificación -->
                        <div class="text-center">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle fa-3x mb-3 d-block"></i>
                                <h4 class="alert-heading">Verificación en Proceso</h4>
                                <p>Su pago está en proceso de verificación por sistemas.</p>
                                <p class="mb-0">En unos momentos recibirá un correo con las instrucciones a seguir.</p>
                            </div>

                            <div class="mt-4">
                                <button onclick="cerrarVentanaYRedireccionar()" class="btn btn-primary">
                                    Aceptar
                                </button>
                            </div>
                        </div>

                        <!-- Información de contacto -->
                        <div class="mt-4 text-center">
                            <p class="mb-1">¿Necesitas ayuda?</p>
                            <p class="mb-0">
                                <a href="mailto:soporte@montalvomining.com" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i> soporte@montalvomining.com
                                </a>
                            </p>
                            <p class="mb-0">
                                <a href="https://wa.me/0983391110" class="text-decoration-none">
                                    <i class="fab fa-whatsapp"></i> 0983391110
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cerrarVentanaYRedireccionar() {
            // Si está en un iframe
            if (window.self !== window.top) {
                // Enviar mensaje al padre para cerrar el modal
                window.parent.postMessage('cerrarModal', '*');
                // Redireccionar la ventana principal al home
                window.parent.location.href = '/';
            } else {
                // Si no está en un iframe, simplemente redireccionar
                window.location.href = '/';
            }
        }
    </script>
</x-app-layout>
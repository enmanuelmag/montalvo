<x-app-layout>
    <div class="container py-5 pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Pago con PayPhone</h4>
                    </div>
                    <div class="card-body">
                        <!-- Detalles del pago -->
                        <div class="mb-4">
                            <h5>Detalles de la Orden</h5>
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

                        <!-- Bot¨®n de PayPhone -->
                        <div class="text-center">
                            <div id="pp-button">
                                <button onclick="processPayment()" class="btn btn-primary">
                                    Pagar con PayPhone
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function processPayment() {
            try {
                const button = document.getElementById('pp-button');
                button.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';

                const response = await fetch('{{ route('pagos.generar-link', $pago->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.payWithPayPhone) {
                    // Redirigir directamente a la URL de pago
                    window.location.href = data.payWithPayPhone;
                } else {
                    throw new Error(data.error || 'Error al generar el link de pago');
                }

            } catch (error) {
                console.error('Error:', error);
                document.getElementById('pp-button').innerHTML = `
                    <div class="alert alert-danger">Error al procesar el pago: ${error.message}</div>
                    <button onclick="processPayment()" class="btn btn-primary mt-3">
                        Intentar nuevamente
                    </button>
                `;
            }
        }
    </script>
</x-app-layout>

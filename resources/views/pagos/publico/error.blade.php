<x-app-layout>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-danger">
                        <div class="card-header bg-danger text-white">
                            <h4 class="mb-0">Error en el Pago</h4>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <i class="fas fa-exclamation-circle text-danger" style="font-size: 4rem;"></i>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5>Detalles de la Transacción:</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Referencia:</th>
                                            <td>{{ $pago->referencia }}</td>
                                        </tr>
                                        <tr>
                                            <th>Curso:</th>
                                            <td>{{ $pago->curso_nombre }}</td>
                                        </tr>
                                        <tr>
                                            <th>Monto:</th>
                                            <td>${{ number_format($pago->valor, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Estado:</th>
                                            <td>
                                                <span class="badge bg-danger">{{ $pago->estado }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <h6 class="alert-heading">¿Qué puedo hacer?</h6>
                                <ul class="mb-0">
                                    <li>Verificar que los datos de su tarjeta o método de pago sean correctos</li>
                                    <li>Asegurarse de tener fondos suficientes</li>
                                    <li>Intentar con otro método de pago</li>
                                    <li>Contactar a nuestro soporte si el problema persiste</li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver
                                </a>
                                <div class="text-center">
                                <p class="mb-2">¿Tienes alguna pregunta?</p>
                                <p class="mb-0">
                                    Contáctanos a través de
                                    <a href="mailto:soporte@montalvomining.com">soporte@montalvomining.com</a>
                                </p>
                                <p class="mb-0">
                                    
                                    <a href="https://wa.me/0983391110">
                                    <i class="fab fa-whatsapp text-success me-1"></i> 0983391110
                                    </a>
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>
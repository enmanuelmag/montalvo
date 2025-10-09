<x-app-layout>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Instrucciones de Pago por Transferencia</h4>
                        </div>

                        <div class="card-body">
                            {{-- Mostrar mensajes de éxito o error --}}
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{-- Detalles de la orden --}}
                            <div class="mb-4">
                                <h5>Detalles de tu Orden</h5>
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
                                            <th>Valor a Pagar:</th>
                                            <td>${{ number_format($pago->valor, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- Datos bancarios --}}
                            <div class="mb-4">
                                <h5>Datos Bancarios para la Transferencia</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <dl class="row mb-0">
                                            <dt class="col-sm-4">Banco:</dt>
                                            <dd class="col-sm-8">{{ $datosBancarios['banco'] }}</dd>

                                            <dt class="col-sm-4">Tipo de Cuenta:</dt>
                                            <dd class="col-sm-8">{{ $datosBancarios['tipo_cuenta'] }}</dd>

                                            <dt class="col-sm-4">Número de Cuenta:</dt>
                                            <dd class="col-sm-8">{{ $datosBancarios['numero_cuenta'] }}</dd>

                                            <dt class="col-sm-4">Titular:</dt>
                                            <dd class="col-sm-8">{{ $datosBancarios['titular'] }}</dd>

                                            <dt class="col-sm-4">Identificación:</dt>
                                            <dd class="col-sm-8">{{ $datosBancarios['identificacion_titular'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                            {{-- Instrucciones adicionales --}}
                            <div class="mb-4">
                                <h5>Instrucciones Importantes</h5>
                                <div class="alert alert-info">
                                    <ul class="mb-0">
                                        <li>Guarda el número de referencia: <strong>{{ $pago->referencia }}</strong></li>
                                        <li>Realiza la transferencia por el monto exacto: <strong>${{ number_format($pago->valor, 2) }}</strong></li>
                                        <li>En el concepto/descripción de la transferencia incluye la referencia</li>
                                        @if(isset($datosBancarios['instrucciones']))
                                            <li>{{ $datosBancarios['instrucciones'] }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            {{-- Formulario para subir comprobante --}}
                            <div class="mb-4">
                                <h5>Subir Comprobante de Pago</h5>
                                <form action="{{ route('pagos.publico.confirmar-transferencia', $pago) }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="comprobante" class="form-label">Comprobante de Transferencia</label>
                                        <input type="file" class="form-control" id="comprobante" name="comprobante"
                                               accept=".jpg,.jpeg,.png,.pdf" required>
                                        <div class="form-text">
                                            Formatos aceptados: JPG, PNG, PDF. Tamaño máximo: 2MB
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="comentario" class="form-label">Comentarios (opcional)</label>
                                        <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Enviar Comprobante
                                        </button>
                                    </div>
                                </form>
                            </div>

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


</x-app-layout>
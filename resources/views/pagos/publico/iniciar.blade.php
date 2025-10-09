
<x-app-layout>

    <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Formulario de Pago</h4>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5>Detalles del Curso</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $curso->nombre }}</h6>
                                        <p class="card-text">Valor: ${{ number_format($curso->precio, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('pagos.publico.procesar') }}" method="POST" id="formPago">
                                @csrf
                                <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                                <input type="hidden" name="curso_nombre" value="{{ $curso->titulo }}">
                                <input type="hidden" name="valor" value="{{ $curso->precio }}">

                                <div class="mb-3">
                                    <label for="identificacion" class="form-label">Identificación (Cédula/Pasaporte)</label>
                                    <input type="text" class="form-control" id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cliente" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" id="cliente" name="cliente" value="{{ old('cliente') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo" value="{{ old('correo') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="ciudad" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Método de Pago</label>
                                    @foreach($botonesPago as $boton)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="boton_pago_id"
                                                   id="pago_{{ $boton->id }}" value="{{ $boton->id }}" required>
                                            <label class="form-check-label" for="pago_{{ $boton->id }}">
                                                @switch($boton->nombre_proveedor)
                                                    @case('PAYPAL')
                                                        <i class="fab fa-paypal"></i>
                                                        @break
                                                    @case('PAYPHONE')
                                                        <i class="fas fa-mobile-alt"></i>
                                                        @break
                                                    @case('TRANSFERENCIA')
                                                        <i class="fas fa-university"></i>
                                                        @break
                                                @endswitch
                                                {{ $boton->boton_pago_detalle }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        Continuar con el Pago
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                        Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.getElementById('formPago').addEventListener('submit', function(e) {
                    let submitButton = this.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';
                });
            </script>
        @endpush

</x-app-layout>
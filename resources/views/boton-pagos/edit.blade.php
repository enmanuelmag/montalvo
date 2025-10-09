<x-admin-layout>
    <container>
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Editar Método de Pago</h4>
                <div class="dt-action-buttons text-end">
                    <div class="dt-buttons">
                        <a href="{{ route('boton-pagos.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">
                            <strong>Error:</strong> Por favor revise los campos marcados.
                        </div>
                    </div>
                @endif

                <form id="formBotonPago" class="form" action="{{ route('boton-pagos.update', $botonPago) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Campos fijos -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Tipo de Proveedor</label>
                            <input type="text" class="form-control" value="{{ $botonPago->nombre_proveedor }}" readonly>
                            <input type="hidden" name="nombre_proveedor" value="{{ $botonPago->nombre_proveedor }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label required" for="boton_pago_detalle">Detalle</label>
                            <input type="text" id="boton_pago_detalle" name="boton_pago_detalle"
                                   class="form-control @error('boton_pago_detalle') is-invalid @enderror"
                                   value="{{ old('boton_pago_detalle', $botonPago->boton_pago_detalle) }}" required>
                            @error('boton_pago_detalle')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{$botonPago->nombre_proveedor}}
                    <!-- Campos específicos según el proveedor -->
                    @switch($botonPago->nombre_proveedor)
                        @case('PAYPHONE')
                            <div id="campos-payphone">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label required" for="token_boton_pago">Identificador (Token)</label>
                                        <input type="text" id="token_boton_pago" name="token_boton_pago"
                                               class="form-control @error('token_boton_pago') is-invalid @enderror"
                                               value="{{ old('token_boton_pago', $botonPago->token_boton_pago) }}" required>
                                        @error('token_boton_pago')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required" for="key_boton_pago">Id Cliente</label>
                                        <input type="text" id="key_boton_pago" name="key_boton_pago"
                                               class="form-control @error('key_boton_pago') is-invalid @enderror"
                                               value="{{ old('key_boton_pago', $botonPago->key_boton_pago) }}" required>
                                        @error('key_boton_pago')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="clave_boton_pago">Clave Secreta</label>
                                        <input type="password" id="clave_boton_pago" name="clave_boton_pago"
                                               class="form-control @error('clave_boton_pago') is-invalid @enderror"
                                               placeholder="Dejar vacío para mantener la actual">
                                        @error('clave_boton_pago')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="contraseña_codificacion">Contraseña de Codificación</label>
                                        <input type="password" id="contraseña_codificacion"
                                               name="configuracion_adicional[contraseña_codificacion]"
                                               class="form-control"
                                               placeholder="Dejar vacío para mantener la actual">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label required" for="url_boton_pago">URL API PayPhone</label>
                                        <input type="url" id="url_boton_pago" name="url_boton_pago"
                                               class="form-control @error('url_boton_pago') is-invalid @enderror"
                                               value="{{ old('url_boton_pago', $botonPago->url_boton_pago) }}" required>
                                        @error('url_boton_pago')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label required">URL de Respuesta</label>
                                        <input type="url" name="configuracion_adicional[url_respuesta]"
                                               class="form-control"
                                               value="{{ $botonPago->configuracion_adicional['url_respuesta'] ?? route('pagos.publico.estado', ['pago' => 'ID']) }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                            @break

                        @case('PAYPAL')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required" for="usuario_boton_pago">Cliente ID</label>
                                    <input type="text" id="usuario_boton_pago" name="usuario_boton_pago"
                                           class="form-control @error('usuario_boton_pago') is-invalid @enderror"
                                           value="{{ old('usuario_boton_pago', $botonPago->usuario_boton_pago) }}"
                                           placeholder="Por ejemplo: ARsY6UDgbYq3GzKWrfyndl..." >
                                    @error('usuario_boton_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required" for="clave_boton_pago_paypal">Client Secret</label>
                                    <input type="password" id="clave_boton_pago_paypal" name="clave_boton_pago_paypal"
                                           class="form-control @error('clave_boton_pago') is-invalid @enderror"
                                           value="{{ old('clave_boton_pago', $botonPago->clave_boton_pago) }}"
                                    >
                                    @error('clave_boton_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label required" for="url_boton_pago">URL API PayPal</label>
                                    <input type="url" id="url_boton_pago" name="url_boton_pago"
                                           class="form-control @error('url_boton_pago') is-invalid @enderror"
                                           value="{{ old('url_boton_pago', $botonPago->url_boton_pago) }}"
                                           placeholder="https://api-m.sandbox.paypal.com"
                                           required>
                                    @error('url_boton_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @break

                        @case('TRANSFERENCIA')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required" for="configuracion_adicional[banco]">Banco</label>
                                    <input type="text" name="configuracion_adicional[banco]"
                                           class="form-control @error('configuracion_adicional.banco') is-invalid @enderror"
                                           value="{{ old('configuracion_adicional.banco', $botonPago->configuracion_adicional['banco'] ?? '') }}">
                                    @error('configuracion_adicional.banco')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required" for="configuracion_adicional[tipo_cuenta]">Tipo de Cuenta</label>
                                    <select name="configuracion_adicional[tipo_cuenta]"
                                            class="form-select @error('configuracion_adicional.tipo_cuenta') is-invalid @enderror">
                                        <option value="">Seleccione tipo de cuenta</option>
                                        <option value="AHORRO" {{ old('configuracion_adicional.tipo_cuenta', $botonPago->configuracion_adicional['tipo_cuenta'] ?? '') == 'AHORRO' ? 'selected' : '' }}>Ahorro</option>
                                        <option value="CORRIENTE" {{ old('configuracion_adicional.tipo_cuenta', $botonPago->configuracion_adicional['tipo_cuenta'] ?? '') == 'CORRIENTE' ? 'selected' : '' }}>Corriente</option>
                                    </select>
                                    @error('configuracion_adicional.tipo_cuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required" for="configuracion_adicional[numero_cuenta]">Número de Cuenta</label>
                                    <input type="text" name="configuracion_adicional[numero_cuenta]"
                                           class="form-control @error('configuracion_adicional.numero_cuenta') is-invalid @enderror"
                                           value="{{ old('configuracion_adicional.numero_cuenta', $botonPago->configuracion_adicional['numero_cuenta'] ?? '') }}">
                                    @error('configuracion_adicional.numero_cuenta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required" for="configuracion_adicional[identificacion_titular]">Identificación Titular</label>
                                    <input type="text" name="configuracion_adicional[identificacion_titular]"
                                           class="form-control @error('configuracion_adicional.identificacion_titular') is-invalid @enderror"
                                           value="{{ old('configuracion_adicional.identificacion_titular', $botonPago->configuracion_adicional['identificacion_titular'] ?? '') }}">
                                    @error('configuracion_adicional.identificacion_titular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label required" for="configuracion_adicional[titular]">Nombre del Titular</label>
                                    <input type="text" name="configuracion_adicional[titular]"
                                           class="form-control @error('configuracion_adicional.titular') is-invalid @enderror"
                                           value="{{ old('configuracion_adicional.titular', $botonPago->configuracion_adicional['titular'] ?? '') }}">
                                    @error('configuracion_adicional.titular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label" for="configuracion_adicional[instrucciones]">Instrucciones Adicionales</label>
                                    <textarea name="configuracion_adicional[instrucciones]"
                                              class="form-control @error('configuracion_adicional.instrucciones') is-invalid @enderror"
                                              rows="3">{{ old('configuracion_adicional.instrucciones', $botonPago->configuracion_adicional['instrucciones'] ?? '') }}</textarea>
                                    @error('configuracion_adicional.instrucciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @break
                    @endswitch

                    <!-- Estado -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="esta_activo"
                                       name="esta_activo" value="1"
                                        {{ old('esta_activo', $botonPago->esta_activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="esta_activo">Método de pago activo</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('boton-pagos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </container>

    @push('styles')
        <style>
            .required:after {
                content: ' *';
                color: red;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar validaciones
                const form = document.getElementById('formBotonPago');

                // Prevenir envío si hay errores
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    }
                });

                // Mostrar/ocultar contraseñas
                document.querySelectorAll('input[type="password"]').forEach(input => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'btn btn-outline-secondary position-absolute end-0 top-50 translate-middle-y me-2';
                    button.innerHTML = '<i class="fas fa-eye"></i>';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'position-relative';
                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(input);
                    wrapper.appendChild(button);

                    button.addEventListener('click', function() {
                        const type = input.type === 'password' ? 'text' : 'password';
                        input.type = type;
                        button.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                    });
                });

                // Validación de URLs
                document.querySelectorAll('input[type="url"]').forEach(input => {
                    input.addEventListener('blur', function(e) {
                        const url = e.target.value;
                        if (url && !url.match(/^https?:\/\/.+/)) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Por favor ingrese una URL válida comenzando con http:// o https://',
                                icon: 'error'
                            });
                            e.target.value = '';
                        }
                    });
                });

                function validateForm() {
                    // Implementar validaciones específicas según el proveedor
                    return true;
                }
            });
        </script>
    @endpush
</x-admin-layout>
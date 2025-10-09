<x-admin-layout>
    <container>
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Crear Nuevo Método de Pago</h4>
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

                <form id="formBotonPago" class="form" action="{{ route('boton-pagos.store') }}" method="POST">
                    @csrf

                    <!-- Selección del tipo de proveedor -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label required" for="nombre_proveedor">Tipo de Proveedor</label>
                            <select name="nombre_proveedor" id="nombre_proveedor" class="form-select @error('nombre_proveedor') is-invalid @enderror" required>
                                <option value="">Seleccione un proveedor</option>
                                <option value="PAYPAL" {{ old('nombre_proveedor') == 'PAYPAL' ? 'selected' : '' }}>PayPal</option>
                                <option value="PAYPHONE" {{ old('nombre_proveedor') == 'PAYPHONE' ? 'selected' : '' }}>PayPhone</option>
                                <option value="TRANSFERENCIA" {{ old('nombre_proveedor') == 'TRANSFERENCIA' ? 'selected' : '' }}>Transferencia Bancaria</option>
                            </select>
                            @error('nombre_proveedor')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Detalle del botón de pago -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label required" for="boton_pago_detalle">Detalle</label>
                            <input type="text" id="boton_pago_detalle" name="boton_pago_detalle" class="form-control @error('boton_pago_detalle') is-invalid @enderror" placeholder="Ej: PayPal Empresarial" value="{{ old('boton_pago_detalle') }}" required>
                            @error('boton_pago_detalle')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Campos dinámicos según el proveedor -->
                    <!-- Campos de PayPal -->
                    <div id="campos-paypal" class="campos-proveedor" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required" for="usuario_boton_pago">Cliente ID</label>
                                <input type="text" id="usuario_boton_pago" name="usuario_boton_pago"
                                       class="form-control @error('usuario_boton_pago') is-invalid @enderror"
                                       value="{{ old('usuario_boton_pago') }}"
                                       placeholder="Por ejemplo: ARsY6UDgbYq3GzKWrfyndl..." >
                                @error('usuario_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required" for="clave_boton_pago_paypal">Client Secret</label>
                                <input type="password" id="clave_boton_pago_paypal" name="clave_boton_pago_paypal"
                                       class="form-control @error('clave_boton_pago') is-invalid @enderror"
                                       value="{{ old('clave_boton_pago') }}"
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
                                       value="{{ old('url_boton_pago', 'https://api-m.sandbox.paypal.com') }}"
                                       placeholder="https://api-m.sandbox.paypal.com"
                                       required>
                                @error('url_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Campos de PayPhone -->
                    <!-- Campos de PayPhone -->
                    <div id="campos-payphone" class="campos-proveedor" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required" for="token_boton_pago">Identificador (Token)</label>
                                <input type="text" id="token_boton_pago" name="token_boton_pago"
                                       class="form-control @error('token_boton_pago') is-invalid @enderror"
                                       value="{{ old('token_boton_pago') }}"
                                       placeholder="xToAkqTyrEegSZcKWMZPA">
                                @error('token_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required" for="key_boton_pago">Id Cliente</label>
                                <input type="text" id="key_boton_pago" name="key_boton_pago"
                                       class="form-control @error('key_boton_pago') is-invalid @enderror"
                                       value="{{ old('key_boton_pago') }}"
                                       placeholder="fM8kTpjfmEKxcizc9yDE0g">
                                @error('key_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label " for="clave_boton_pago_payphone">Clave Secreta</label>
                                <input type="password" id="clave_boton_pago_payphone" name="clave_boton_pago"
                                       class="form-control @error('clave_boton_pago') is-invalid @enderror"
                                       value="{{ old('clave_boton_pago') }}"
                                       placeholder="scSVViujiUqRgTsKPaqzzQ">
                                @error('clave_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required" for="contraseña_codificacion">Contraseña de Codificación</label>
                                <input type="password" id="contraseña_codificacion"
                                       name="configuracion_adicional[contraseña_codificacion]"
                                       class="form-control @error('configuracion_adicional.contraseña_codificacion') is-invalid @enderror"
                                       value="{{ old('configuracion_adicional.contraseña_codificacion') }}"
                                       placeholder="ec33c7886d414c42806c06f20f6531c">
                                @error('configuracion_adicional.contraseña_codificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required" for="url_boton_pago_payphone">URL API PayPhone</label>
                                <input type="url" id="url_boton_pago_payphone" name="url_boton_pago"
                                       class="form-control @error('url_boton_pago') is-invalid @enderror"
                                       value="{{ old('url_boton_pago', 'https://pay.payphonetodoesposible.com/api/') }}"
                                       placeholder="https://pay.payphonetodoesposible.com/api/">
                                @error('url_boton_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required" for="url_respuesta">URL de Respuesta</label>
                                <input type="url" id="url_respuesta"
                                       name="configuracion_adicional[url_respuesta]"
                                       class="form-control @error('configuracion_adicional.url_respuesta') is-invalid @enderror"
                                       value="{{ old('configuracion_adicional.url_respuesta', 'https://montalvomining.com/pagos/estado/') }}"
                                       placeholder="https://montalvomining.com/pagos/estado/">
                                @error('configuracion_adicional.url_respuesta')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="campos-transferencia" class="campos-proveedor" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required" for="configuracion_adicional[banco]">Banco</label>
                                <input type="text" name="configuracion_adicional[banco]" class="form-control @error('configuracion_adicional.banco') is-invalid @enderror" value="{{ old('configuracion_adicional.banco') }}">
                                @error('configuracion_adicional.banco')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required" for="configuracion_adicional[tipo_cuenta]">Tipo de Cuenta</label>
                                <select name="configuracion_adicional[tipo_cuenta]" class="form-select @error('configuracion_adicional.tipo_cuenta') is-invalid @enderror">
                                    <option value="">Seleccione tipo de cuenta</option>
                                    <option value="AHORRO" {{ old('configuracion_adicional.tipo_cuenta') == 'AHORRO' ? 'selected' : '' }}>Ahorro</option>
                                    <option value="CORRIENTE" {{ old('configuracion_adicional.tipo_cuenta') == 'CORRIENTE' ? 'selected' : '' }}>Corriente</option>
                                </select>
                                @error('configuracion_adicional.tipo_cuenta')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required" for="configuracion_adicional[numero_cuenta]">Número de Cuenta</label>
                                <input type="text" name="configuracion_adicional[numero_cuenta]" class="form-control @error('configuracion_adicional.numero_cuenta') is-invalid @enderror" value="{{ old('configuracion_adicional.numero_cuenta') }}">
                                @error('configuracion_adicional.numero_cuenta')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required" for="configuracion_adicional[identificacion_titular]">Identificación Titular</label>
                                <input type="text" name="configuracion_adicional[identificacion_titular]" class="form-control @error('configuracion_adicional.identificacion_titular') is-invalid @enderror" value="{{ old('configuracion_adicional.identificacion_titular') }}">
                                @error('configuracion_adicional.identificacion_titular')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label required" for="configuracion_adicional[titular]">Nombre del Titular</label>
                                <input type="text" name="configuracion_adicional[titular]" class="form-control @error('configuracion_adicional.titular') is-invalid @enderror" value="{{ old('configuracion_adicional.titular') }}">
                                @error('configuracion_adicional.titular')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label" for="configuracion_adicional[instrucciones]">Instrucciones Adicionales</label>
                                <textarea name="configuracion_adicional[instrucciones]" class="form-control @error('configuracion_adicional.instrucciones') is-invalid @enderror" rows="3">{{ old('configuracion_adicional.instrucciones') }}</textarea>
                                @error('configuracion_adicional.instrucciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="esta_activo" name="esta_activo" value="1" {{ old('esta_activo', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="esta_activo">Método de pago activo</label>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('boton-pagos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
                const proveedorSelect = document.getElementById('nombre_proveedor');
                const camposProveedor = document.querySelectorAll('.campos-proveedor');

                // Función para mostrar/ocultar campos según el proveedor
                function toggleCampos() {
                    camposProveedor.forEach(campo => campo.style.display = 'none');

                    const proveedor = proveedorSelect.value.toLowerCase();
                    if (proveedor) {
                        const camposActuales = document.getElementById(`campos-${proveedor}`);
                        if (camposActuales) {
                            camposActuales.style.display = 'block';
                            if (proveedor === 'paypal') {
                                document.getElementById('usuario_boton_pago').required = true;
                                document.getElementById('clave_boton_pago_paypal').required = true;
                                document.getElementById('url_boton_pago').required = true;
                            }
                        }
                    }
                }

                // Inicializar campos si hay un valor seleccionado
                toggleCampos();

                // Escuchar cambios en el select
                proveedorSelect.addEventListener('change', toggleCampos);

                // Validación del formulario
                const form = document.getElementById('formBotonPago');
                form.addEventListener('submit', function(e) {
                    const proveedor = proveedorSelect.value;
                    let isValid = true;

                    // Validación específica según el proveedor
                    if (proveedor === 'PAYPAL') {
                        isValid = validatePayPal();
                    } else if (proveedor === 'PAYPHONE') {
                        isValid = validatePayPhone();
                    } else if (proveedor === 'TRANSFERENCIA') {
                        isValid = validateTransferencia();
                    }

                    if (!isValid) {
                        e.preventDefault();
                    }
                });

                function validatePayPal() {
                    const clientId = document.getElementById('usuario_boton_pago').value.trim();
                    const clientSecret = document.getElementById('clave_boton_pago_paypal').value.trim();
                    const url = document.getElementById('url_boton_pago').value.trim();

                    if (!clientId || !clientSecret || !url) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Todos los campos de PayPal son requeridos',
                            icon: 'error'
                        });
                        return false;
                    }

                    if (!url.match(/^https?:\/\/.+/)) {
                        Swal.fire({
                            title: 'Error',
                            text: 'La URL API debe comenzar con http:// o https://',
                            icon: 'error'
                        });
                        return false;
                    }

                    return true;
                }
                const noSpaceInputs = document.querySelectorAll('#usuario_boton_pago, #clave_boton_pago_paypal');
                noSpaceInputs.forEach(input => {
                    input.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/\s/g, '');
                    });
                });
                function validatePayPhone() {
                    const token = document.getElementById('token_boton_pago').value;
                    const key = document.getElementById('key_boton_pago').value;
                    const claveSecreta = document.getElementById('clave_boton_pago_payphone').value;
                    const contraseñaCodificacion = document.getElementById('contraseña_codificacion').value;
                    const url = document.getElementById('url_boton_pago_payphone').value;
                    const urlRespuesta = document.getElementById('url_respuesta').value;

                    const camposFaltantes = [];

                    if (!token) camposFaltantes.push('Identificador (Token)');
                    if (!key) camposFaltantes.push('Id Cliente');
                    if (!claveSecreta) camposFaltantes.push('Clave Secreta');
                    if (!contraseñaCodificacion) camposFaltantes.push('Contraseña de Codificación');
                    if (!url) camposFaltantes.push('URL API');
                    if (!urlRespuesta) camposFaltantes.push('URL de Respuesta');

                    if (camposFaltantes.length > 0) {
                        Swal.fire({
                            title: 'Error',
                            text: `Los siguientes campos son requeridos: ${camposFaltantes.join(', ')}`,
                            icon: 'error'
                        });
                        return false;
                    }

                    return true;
                }

                function validateTransferencia() {
                    const campos = ['banco', 'tipo_cuenta', 'numero_cuenta', 'titular', 'identificacion_titular'];
                    let camposFaltantes = [];

                    campos.forEach(campo => {
                        const input = document.querySelector(`[name="configuracion_adicional[${campo}]"]`);
                        if (!input.value.trim()) {
                            camposFaltantes.push(campo.replace('_', ' ').toLowerCase());
                        }
                    });

                    if (camposFaltantes.length > 0) {
                        Swal.fire({
                            title: 'Error',
                            text: `Los siguientes campos son requeridos: ${camposFaltantes.join(', ')}`,
                            icon: 'error'
                        });
                        return false;
                    }
                    return true;
                }

                // Validación de formato de cuenta bancaria
                const numeroCuentaInput = document.querySelector('[name="configuracion_adicional[numero_cuenta]"]');
                if (numeroCuentaInput) {
                    numeroCuentaInput.addEventListener('input', function(e) {
                        // Eliminar espacios y caracteres no numéricos
                        let valor = e.target.value.replace(/\D/g, '');

                        // Limitar a 20 dígitos
                        if (valor.length > 20) {
                            valor = valor.slice(0, 20);
                        }

                        // Formatear con espacios cada 4 dígitos
                        valor = valor.replace(/(\d{4})(?=\d)/g, '$1 ');

                        e.target.value = valor;
                    });
                }

                // Validación de identificación
                const identificacionInput = document.querySelector('[name="configuracion_adicional[identificacion_titular]"]');
                if (identificacionInput) {
                    identificacionInput.addEventListener('input', function(e) {
                        // Permitir solo números
                        let valor = e.target.value.replace(/\D/g, '');

                        // Limitar a 13 dígitos (cédula o RUC)
                        if (valor.length > 13) {
                            valor = valor.slice(0, 13);
                        }

                        e.target.value = valor;
                    });

                    identificacionInput.addEventListener('blur', function(e) {
                        const valor = e.target.value;
                        if (valor.length > 0 && valor.length < 10) {
                            Swal.fire({
                                title: 'Advertencia',
                                text: 'La identificación debe tener al menos 10 dígitos',
                                icon: 'warning'
                            });
                        }
                    });
                }

                // Validación de URLs
                const urlInputs = document.querySelectorAll('input[type="url"]');
                urlInputs.forEach(input => {
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

                // Prevenir espacios en campos sensibles

            });
        </script>
    @endpush

</x-admin-layout>

    <div class="modal-header">
        <h4 class="modal-title">Detalles del Pago</h4>
    </div>

    <div class="modal-body">
        <div class="container-fluid p-3">
            <div class="row">
                <!-- Información Principal -->
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Información del Pago</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="150">Referencia:</th>
                            <td>{{ $pago->referencia }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                @switch($pago->estado)
                                    @case('COMPLETADO')
                                        <span class="badge bg-success">Completado</span>
                                        @break
                                    @case('PENDIENTE')
                                        <span class="badge bg-warning">Pendiente</span>
                                        @break
                                    @case('FALLIDO')
                                        <span class="badge bg-danger">Fallido</span>
                                        @break
                                    @case('REEMBOLSADO')
                                        <span class="badge bg-info">Reembolsado</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <th>Método de Pago:</th>
                            <td>{{ $pago->tipo_pago }}</td>
                        </tr>
                        <tr>
                            <th>Valor:</th>
                            <td>${{ number_format($pago->valor, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Fecha:</th>
                            <td>
                                {{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y H:i:s') : 'Sin fecha' }}
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Información del Cliente -->
                <!-- Información del Cliente -->
                <div class="col-md-6">
                    <h5 class="border-bottom pb-2">Información del Cliente</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="150">Nombre:</th>
                            <td>{{ $pago->cliente }}</td>
                        </tr>
                        <tr>
                            <th>Identificación:</th>
                            <td>{{ $pago->identificacion }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $pago->correo }}</td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td>{{ $pago->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Ciudad:</th>
                            <td>{{ $pago->ciudad ?? 'Quito' }}</td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td>{{ $pago->direccion ?? 'S/N' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Información del Curso -->
            <div class="row mt-3">
                <div class="col-12">
                    <h5 class="border-bottom pb-2">Información del Curso</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="150">Curso:</th>
                            <td>{{ $pago->curso_nombre }}</td>
                        </tr>
                        <tr>
                            <th>ID del Curso:</th>
                            <td>{{ $pago->curso_id }}</td>
                        </tr>
                        @if($pago->descripcion)
                            <tr>
                                <th>Descripción:</th>
                                <td>{{ $pago->descripcion }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

<!-- Comprobante de Transferencia -->
@if($pago->tipo_pago === 'TRANSFERENCIA' && isset($pago->respuesta_proveedor['comprobante_path']))
    @php
        $rutaComprobante = asset('storage/' . $pago->respuesta_proveedor['comprobante_path']);
        $extension = pathinfo($rutaComprobante, PATHINFO_EXTENSION);
    @endphp

    <div class="row mt-3">
        <div class="col-12">
            <h5 class="border-bottom pb-2">Comprobante de Transferencia</h5>

            <div class="text-center">
                @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <!-- Mostrar imagen -->
                    <img src="{{ $rutaComprobante }}"
                         class="img-fluid rounded shadow"
                         alt="Comprobante de transferencia"
                         style="max-height: 400px; cursor: pointer;"
                         onclick="window.open(this.src, '_blank')">
                @elseif(strtolower($extension) === 'pdf')
                    <!-- Mostrar botón PDF -->
                    <a href="{{ $rutaComprobante }}"
                       target="_blank"
                       class="btn btn-outline-primary"
                       title="Abrir comprobante PDF">
                        <i class="fas fa-file-pdf"></i> Ver Comprobante PDF
                    </a>
                @else
                    <!-- Otro tipo de archivo -->
                    <a href="{{ $rutaComprobante }}"
                       target="_blank"
                       class="btn btn-secondary">
                        Descargar Comprobante
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif


            <!-- Detalles del Comprobante -->
            @if($pago->respuesta_proveedor)
                <div class="row mt-3">
                    <div class="col-12">
                        <h5 class="border-bottom pb-2">Detalles del Comprobante</h5>
                        <div class="bg-light p-3 rounded">
                            <table class="table table-sm mb-0">
                                @if(isset($pago->respuesta_proveedor['comentario']))
                                    <tr>
                                        <th width="150">Comentario:</th>
                                        <td>{{ $pago->respuesta_proveedor['comentario'] }}</td>
                                    </tr>
                                @endif
                                @if(!empty($pago->respuesta_proveedor['fecha_comprobante']))
                                    @php
                                        try {
                                            $fechaComprobante = \Carbon\Carbon::parse($pago->respuesta_proveedor['fecha_comprobante'])->format('d/m/Y H:i:s');
                                        } catch (\Exception $e) {
                                            $fechaComprobante = 'Fecha inválida';
                                        }
                                    @endphp
                                    <td>{{ $fechaComprobante }}</td>
                                @endif
                                @if(isset($pago->respuesta_proveedor['motivo_anulacion']))
                                    <tr>
                                        <th>Motivo Anulación:</th>
                                        <td>{{ $pago->respuesta_proveedor['motivo_anulacion'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha Anulación:</th>
                                        <td>{{ \Carbon\Carbon::parse($pago->respuesta_proveedor['fecha_anulacion'])->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Usuario Anuló:</th>
                                        <td>{{ $pago->respuesta_proveedor['usuario_anulacion'] }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Acciones -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cerrar
                            </button>
                        </div>
                        <div>
                            @if($pago->estado === 'PENDIENTE' || $pago->estado === 'PENDIENTE DE VERIFICACION')
                                <button type="button" class="btn btn-danger me-2" onclick="anularPago('{{ $pago->id }}')">
                                    <i class="fas fa-ban me-2"></i>Anular Pago
                                </button>
                                <button type="button" class="btn btn-success me-2" onclick="actualizarEstado('{{ $pago->id }}', 'COMPLETADO')">
                                    <i class="fas fa-check me-2"></i>Marcar como Completado
                                </button>
                            @endif
                            @if($pago->estado === 'COMPLETADO' && !$pago->registrado_moodle)
                                <button type="button" class="btn btn-primary" onclick="registrarEnMoodle('{{ $pago->id }}')">
                                    <i class="fas fa-graduation-cap me-2"></i>Registrar en Moodle
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <script>
            function actualizarEstado(pagoId, estado) {
                let mensaje = '¿Estás seguro de cambiar el estado del pago?';
                if (estado === 'FALLIDO') {
                    mensaje = '¿Estás seguro de anular este pago? Esta acción no se puede deshacer.';
                }

                if (confirm(mensaje)) {
                    const loadingIndicator = document.getElementById('loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.classList.remove('d-none');
                    }

                    $.ajax({
                        url: `/admin/pagos/${pagoId}/estado`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            estado: estado
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(estado === 'FALLIDO' ? 'Pago anulado correctamente' : 'Estado actualizado correctamente');
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error al actualizar el estado');
                        },
                        complete: function() {
                            if (loadingIndicator) {
                                loadingIndicator.classList.add('d-none');
                            }
                        }
                    });
                }
            }

            function anularPago(pagoId) {
                const motivo = prompt('Por favor, ingrese el motivo de la anulación:');
                if (motivo) {
                    $.ajax({
                        url: `/admin/pagos/${pagoId}/anular`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            motivo: motivo
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Pago anulado correctamente');
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error al anular el pago');
                        }
                    });
                }
            }

            // Manejador de errores de carga de imagen
            document.addEventListener('DOMContentLoaded', function() {
                const comprobanteImg = document.querySelector('img[alt="Comprobante de transferencia"]');
                if (comprobanteImg) {
                    comprobanteImg.onerror = function() {
                        this.onerror = null;
                        this.src = '/img/error-imagen.png'; // Asegúrate de tener una imagen de error por defecto
                        alert('Error al cargar el comprobante. Por favor, verifica que la imagen exista.');
                    };
                }
            });

            function registrarEnMoodle(pagoId) {
                const loadingIndicator = document.getElementById('loader-moodle-' + pagoId);
                if (loadingIndicator) {
                    loadingIndicator.classList.remove('d-none');
                }
            
                $.ajax({
                    url: `/procesar-pago-moodle/${pagoId}`,
                    type: 'GET', // o POST si cambias el método en el backend
                    success: function(response) {
                        if (response.status === 'ok') {
                            alert('Usuario registrado y matriculado en Moodle correctamente');
                            location.reload();
                        } else {
                            alert('Algo salió mal: ' + (response.message || 'Error desconocido'));
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Error al procesar el registro en Moodle');
                    },
                    complete: function() {
                        if (loadingIndicator) {
                            loadingIndicator.classList.add('d-none');
                        }
                    }
                });
            }

        </script>

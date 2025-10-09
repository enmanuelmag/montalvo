<x-admin-layout>
    <container>
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Gestión de Métodos de Pago</h4>
                <a href="{{ route('boton-pagos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Método de Pago
                </a>
            </div>
            <div class="card-body">
                {{-- Mensajes de alerta --}}
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <div class="alert-body">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <div class="alert-body">{{ session('error') }}</div>
                    </div>
                @endif

                <div class="card-datatable">
                    <table class="datatables-basic table" id="botonesPagoTable">
                        <thead>
                        <tr>
                            <th>Proveedor</th>
                            <th>Detalle</th>
                            <th>Estado</th>
                            <th>Última Actualización</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($botonesPago as $boton)
                            <tr>
                                <td>
                                    @switch($boton->nombre_proveedor)
                                        @case('PAYPAL')
                                            <i class="fab fa-paypal text-primary"></i>
                                            @break
                                        @case('PAYPHONE')
                                            <i class="fas fa-mobile-alt text-success"></i>
                                            @break
                                        @case('TRANSFERENCIA')
                                            <i class="fas fa-university text-secondary"></i>
                                            @break
                                        @default
                                            <i class="fas fa-credit-card"></i>
                                    @endswitch
                                    {{ $boton->nombre_proveedor }}
                                </td>
                                <td>{{ $boton->boton_pago_detalle }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $boton->esta_activo ? 'badge-light-success' : 'badge-light-danger' }}">
                                        {{ $boton->esta_activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>{{ $boton->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="d-inline-flex">
                                        <button class="btn btn-sm btn-icon btn-primary" onclick="verConfiguracion({{ $boton->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('boton-pagos.edit', $boton) }}" class="btn btn-sm btn-icon btn-warning ms-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-icon {{ $boton->esta_activo ? 'btn-success' : 'btn-danger' }} ms-1"
                                                onclick="toggleEstado({{ $boton->id }})">
                                            <i class="fas fa-toggle-{{ $boton->esta_activo ? 'on' : 'off' }}"></i>
                                        </button>
                                        <form action="{{ route('boton-pagos.destroy', $boton) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-danger ms-1"
                                                    onclick="return confirm('¿Está seguro de eliminar este método de pago?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal para ver configuración --}}
        <div class="modal fade" id="configModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Configuración del Método de Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="configContent">
                            <!-- El contenido se llenará dinámicamente -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </container>

    @push('scripts')
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>

        <script>
            $(function () {
                var dt_basic = $('#botonesPagoTable').DataTable({
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                        search: "Buscar:",
                        paginate: {
                            previous: "‹ Anterior",
                            next: "Siguiente ›"
                        }
                    },
                    dom: '<"row"<"col-sm-12 col-md-12 d-flex justify-content-end"f>>t<"row"<"col-sm-12 col-md-12 d-flex justify-content-end"p>>',
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                });
            });
            // Función para ver la configuración
            function verConfiguracion(id) {
                fetch(`/boton-pagos/${id}/configuracion`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let contentHtml = '<div class="table-responsive"><table class="table">';

                            for (const [key, value] of Object.entries(data.data)) {
                                contentHtml += `
                                <tr>
                                    <th>${key}:</th>
                                    <td>${value}</td>
                                </tr>`;
                            }

                            contentHtml += '</table></div>';
                            document.getElementById('configContent').innerHTML = contentHtml;

                            var modal = new bootstrap.Modal(document.getElementById('configModal'));
                            modal.show();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Función para cambiar el estado
            function toggleEstado(id) {
                fetch(`/boton-pagos/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endpush

</x-admin-layout>
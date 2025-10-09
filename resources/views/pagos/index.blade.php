<x-admin-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestión de Pagos</h4>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#filtrosPago">
                            <i class="fas fa-filter me-2"></i>Filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="collapse" id="filtrosPago">
                <div class="card-body border-bottom">
                    <form id="formFiltros" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" name="fecha_fin">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="estado">
                                <option value="">Todos</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="PENDIENTE DE VERIFICACION">PENDIENTE DE VERIFICACION</option>
                                <option value="PENDIENTE DE CARGA COMPROBANTE">PENDIENTE DE CARGA COMPROBANTE</option>
                                <option value="COMPLETADO">Completado</option>
                                <option value="FALLIDO">Fallido</option>
                                <option value="REEMBOLSADO">Reembolsado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Pago</label>
                            <select class="form-select" name="tipo_pago">
                                <option value="">Todos</option>
                                <option value="TRANSFERENCIA">Transferencia</option>
                                <option value="PAYPAL">PayPal</option>
                                <option value="PAYPHONE">PayPhone</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-eraser me-2"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover nowrap" id="tablaPagos" style="width:100%">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Cliente</th>
                                <th>Curso</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables lo llena -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loader overlay -->
    <div id="loader-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    </div>

    <!-- Modal Detalles -->
    <div class="modal fade" id="modalDetalles" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- El contenido se carga vía AJAX -->
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- DataTables + Moment.js -->
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script>
            $(document).ready(function () {
                let tabla = $('#tablaPagos').DataTable({
                    ajax: '{{ route("pagos.listar") }}',
                    responsive: true, // ✅ Habilitar responsive
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                    },
                    order: [[6, 'desc']],
                    pageLength: 25,
                    columns: [
                        { data: 'referencia' },
                        {
                            data: null,
                            render: function (data) {
                                return `${data.cliente ?? 'Sin nombre'}<br><small class="text-muted">${data.correo ?? ''}</small>`;
                            }
                        },
                        { data: 'curso_nombre' },
                        {
                            data: 'valor',
                            render: function (data) {
                                const valor = parseFloat(data);
                                return isNaN(valor) ? '$0.00' : `$${valor.toFixed(2)}`;
                            }
                        },
                        {
                            data: 'estado',
                            render: function (data) {
                                let badge = 'secondary';
                                if (data === 'COMPLETADO') badge = 'success';
                                else if (data === 'PENDIENTE' || data === 'PENDIENTE DE VERIFICACION') badge = 'warning';
                                else if (data === 'FALLIDO') badge = 'danger';
                                else if (data === 'REEMBOLSADO') badge = 'info';
                                return `<span class="badge bg-${badge}">${data}</span>`;
                            }
                        },
                        {
                            data: 'tipo_pago',
                            render: function (data) {
                                let icon = '';
                                if (data === 'PAYPAL') icon = '<i class="fab fa-paypal text-primary"></i>';
                                else if (data === 'PAYPHONE') icon = '<i class="fas fa-mobile-alt text-success"></i>';
                                else if (data === 'TRANSFERENCIA') icon = '<i class="fas fa-university text-secondary"></i>';
                                return `${icon} ${data}`;
                            }
                        },
                        {
                            data: 'fecha_pago',
                            render: function (data) {
                                return data ? moment(data).format('DD/MM/YYYY HH:mm') : 'Sin fecha';
                            }
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return `
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info" onclick="verDetalles('${row.id}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="cambiarEstado('${row.id}')">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                                            ]
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#formFiltros').on('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $('#loader-overlay').fadeIn(); // ✅ Mostrar loader

                    $.ajax({
                        url: '{{ route("pagos.filtrar") }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                tabla.clear().rows.add(response.data).draw();
                            }
                        },
                        complete: function () {
                            $('#loader-overlay').fadeOut(); // ✅ Ocultar loader
                        },
                        error: function (xhr) {
                            console.error('Error:', xhr);
                            alert('Error al filtrar los pagos');
                        }
                    });
                });
            });

            function verDetalles(id) {
                $.get(`/admin/pagosDetalles/${id}`, function (response) {
                    $('#modalDetalles .modal-body').html(response);
                    new bootstrap.Modal('#modalDetalles').show();
                });
            }

            function cambiarEstado(id) {
                // Lógica para cambiar estado
            }
        </script>
    @endpush
</x-admin-layout>
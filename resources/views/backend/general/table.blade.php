<!-- Basic Floating Label Form section end -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="flex-container card-header">
                    <h4 class="card-title">{{$tableTitle}}</h4>
                    <a class="btn btn-success btn-sm" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="DataTables_Table_0_new"
                       data-bs-toggle="modal" onclick="resetModal()" data-bs-target="#general_modal">
                        <span><i data-feather="plus"></i> Nuevo</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="datatables-basic table" id="datatableGeneral">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Titulo</th>
                            <th>SubTitulo</th>
                            <th>Detalle</th>
                            <th>Imagen</th>
                            <th>Texto Boton</th>
                            <th>Lisk Boton</th>
                            <th>Estado</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- El contenido se llenará dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

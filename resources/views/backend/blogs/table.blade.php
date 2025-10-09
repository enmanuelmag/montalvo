<!-- Basic Floating Label Form section end -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="flex-container card-header">
                    <h4 class="card-title">{{$tableTitle}}</h4>
                    <a href="{{ route('nuevoBlog') }}" class="btn btn-success btn-sm" tabindex="0" aria-controls="DataTables_Table_0" type="button" id="DataTables_Table_0_new">
                        <span><i data-feather="plus"></i> Nuevo Blog</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="datatables-basic table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titulo del Blog</th>
                            <th>Subtitulo</th>
                            <th>Fecha</th>
                            <th>Autor</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

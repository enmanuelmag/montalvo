<!-- Basic Floating Label Form section end -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="flex-container card-header">

                    <a class="btn btn-success btn-sm" type="button" href="{{ route('nuevaCapacitacion') }}">
                        <span><i data-feather="plus"></i> Nueva Capacitación</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="datatables-basic table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titulo del Item a Mostrar</th>
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

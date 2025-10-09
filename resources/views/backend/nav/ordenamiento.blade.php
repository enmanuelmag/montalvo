<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Orden de los items del menu</h4>
        </div>
        <div class="card-body">
            <ul class="list-group" id="basic-list-group">
                @foreach($navBars as $nav)
                    <li class="list-group-item draggable" data-id="{{ $nav->id }}">
                        <div class="d-flex">
                            <div class="more-info">
                                <h5>{{ $nav->nombre_menu }}</h5>
                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="card-footer">
            <a class="btn btn-success btn-sm" type="button"  onclick="enviarNuevoOrden()" >
                <span><i data-feather="save"></i> Actualizar Orden</span>
            </a>
        </div>

    </div>
</div>

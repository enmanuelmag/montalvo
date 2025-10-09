<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="cliente_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="clienteForm">
                        <input type="hidden" name="id_item_cliente" value="0" id="id_item_cliente">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="col-form-label" for="nombre">Nombre Cliente</label>
                                        <input type="text" id="titulo" class="form-control" value="" name="titulo" placeholder="Jhon Die" />
                                    </div>

                                </div>
                                <div class="row mb-1">

                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-label" for="imagen">Imagen Cliente: </label>
                                        <img id="preview_imagen" src="{{ asset('files/img/planceholder.jpg') }}" width="250px" height="250px" alt="Imagen de Sección" class="preview-image">
                                        <input type="file" id="imagen" class="form-control"
                                               value=""
                                               name="imagen" placeholder="imagen" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="saveItemCliente" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                        <button type="submit" id="updateItemCliente" hidden="true" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

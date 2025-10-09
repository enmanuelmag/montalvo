<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="galeria_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="storeGaleriaItemForm" class="form" enctype="multipart/form-data"  method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id_item_galeria" id="id_item_galeria">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="titulo">Titulo: </label>
                                    <input type="text" id="titulo" class="form-control"
                                           value=""
                                           placeholder="Titulo de la Imagen" name="titulo" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="id_categoria">Categoria de la Imagen:</label>
                                    <select class="form-select" required id="id_categoria" name="id_categoria">
                                        <option value="">Seleccione una Categoria</option>
                                        @foreach($categorias as $item) 
                                        <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Detalle:</label>
                                    <input type="text" id="detalle" class="form-control"
                                           value=""
                                           placeholder="Detalle de la Imagen" name="detalle" />
                                </div>
                            </div>

                            <div class="col-md-9 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="imagen">Imagen Galeria: </label>
                                    <img id="preview_imagen" src="{{ asset('files/img/planceholder.jpg') }}" alt="Imagen de Sección" class="preview-image">
                                    <input type="file" id="imagen" class="form-control"
                                           value=""
                                           name="imagen" placeholder="imagen" />
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <button id="saveItemGaleria" type="button" class="btn btn-primary me-1">Guardar</button>
                            <button type="button" id="updateItemGaleria" hidden class="btn btn-primary me-1 ">Actualizar</button>
                            <button type="reset" class="btn btn-outline-secondary">LIMPIAR</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

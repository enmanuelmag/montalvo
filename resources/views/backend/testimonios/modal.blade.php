<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="testimonio_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="testimonioForm">
                        <input type="hidden" name="id_item_testimonio" value="0" id="id_item_testimonio">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="nombre">Nombre Cliente</label>
                                        <input type="text" id="nombre" class="form-control" value="" name="nombre" placeholder="Jhon Die" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="titulo">Empresa o Referencia</label>
                                        <input type="text" id="cargo" class="form-control" value="" name="cargo" placeholder="Nombre de la empresa" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="facebook">Cargo</label>
                                        <input type="text" id="Cargo" class="form-control" value="" name="Cargo" placeholder="Detalle el cargo en su compañia" />
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="empresa">Empresa </label>
                                        <input type="text" id="empresa" class="form-control" value="" name="empresa" placeholder="Home - Blog - Etc" />
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <label class="col-form-label" for="descripcion">Detalle </label>
                                        <input type="text" id="descripcion" class="form-control" value="" name="descripcion" placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="facebook">Valoración del 1 al 5</label>
                                        <input type="number" id="calificacion" min="1" max="5" class="form-control" value="" name="calificacion" placeholder="5" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label" for="imagen">Imagen de Sección: </label>
                                        <img id="preview_imagen" src="{{ asset('files/img/planceholder.jpg') }}" width="250px" height="250px" alt="Imagen de Sección" class="preview-image">
                                        <input type="file" id="imagen" class="form-control"
                                               value=""
                                               name="imagen" placeholder="imagen" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="saveItemTestimonio" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                        <button type="submit" id="updateItemTestimonio" hidden="true" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

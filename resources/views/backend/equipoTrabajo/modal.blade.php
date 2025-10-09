<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="equipo_trabajo_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="equipoForm">
                        <input type="hidden" name="id_item_equipo" value="0" id="id_item_equipo">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="nombre">Nombre del Miembro del Equipo</label>
                                        <input type="text" id="nombre" class="form-control" value="" name="nombre" placeholder="Home - Blog - Etc" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="titulo">Cargo</label>
                                        <input type="text" id="cargo" class="form-control" value="" name="cargo" placeholder="Home - Blog - Etc" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                            <label class="form-label" for="imagen">Imagen de Sección: </label>
                                            <img id="preview_imagen" src="{{ asset('files/img/planceholder.jpg') }}" width="250px" height="250px" alt="Imagen de Sección" class="preview-image">
                                            <input type="file" id="imagen" class="form-control"
                                                   value=""
                                                   name="imagen" placeholder="imagen" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="descripcion">Cargo</label>
                                        <input type="text" id="descripcion" class="form-control" value="" name="descripcion" placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="facebook">Facebook</label>
                                        <input type="text" id="facebook" class="form-control" value="" name="facebook" placeholder="Link" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="twitter">Twitter - X </label>
                                        <input type="text" id="twitter" class="form-control" value="" name="twitter" placeholder="Link" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="instagram">Instagram</label>
                                        <input type="text" id="instagram" class="form-control" value="" name="instagram" placeholder="Link" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="linkedin">LinkedIn</label>
                                        <input type="text" id="linkedin" class="form-control" value="" name="linkedin" placeholder="Link" />
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="col-form-label" for="youtube">YouTube</label>
                                        <input type="text" id="youtube" class="form-control" value="" name="youtube" placeholder="Link" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="saveItemEquipo" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                        <button type="submit" id="updateItemEquipo" hidden="true" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

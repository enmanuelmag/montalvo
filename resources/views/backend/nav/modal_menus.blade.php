<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="nav_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="navForm">
                        <input type="hidden" name="id_nav" value="0" id="id_nav">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="nombre_menu">Nombre Menú</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nombre_menu" class="form-control" value="{{ $nav->nombre_menu ?? '' }}" name="nombre_menu" placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="ruta">Ruta o Link</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="ruta" class="form-control" value="{{ $nav->ruta ?? '' }}" name="ruta" placeholder="Home - Abouts - Contacts" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" hidden="true">
                                <div class="mb-1 row">
                                    <input type="hidden" id="icono" value="-" class="form-control" name="icono" placeholder="Home - Abouts - Contacts" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveNav" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                </div>
            </div>
        </div>
    </div>
</div>

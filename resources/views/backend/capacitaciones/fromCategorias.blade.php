<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="categoriasCursos" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{$modalTitle}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="categoriasCursosForm">
                        <input type="hidden" name="id_categoria" value="0" id="id_categoria">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="titulo">Titulo</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="titulo" class="form-control" value="" name="titulo" placeholder="Home - Blog - Etc" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="titulo">SubTitulo</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="subtitulo" class="form-control" value="" name="subtitulo" placeholder="Home - Blog - Etc" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveCategoria" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                </div>
            </div>
        </div>
    </div>
</div>

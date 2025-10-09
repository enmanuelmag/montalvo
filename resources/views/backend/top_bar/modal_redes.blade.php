<div class="modal-size-lg d-inline-block">
    <!-- Button trigger modal -->
    <!-- Modal -->
    <div class="modal fade text-start" id="redes_sociales_modal" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Red Social</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal" id="redes_form">
                        <input type="hidden" name="id_nav" value="0" id="id_nav">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="nombre">Nombre de la Red Social</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Facebook - Twitter - Instagram" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="link">Link de la Red Social </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" id="link" class="form-control" name="link" placeholder="https://twitter.com" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="icono_red_social">Icono</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="mb-1">
                                            <select class="form-select" id="icono_red_social" name="icono_red_social">
                                                <option value="0">Seleccione</option>
                                                <option value="fab fa-facebook-f fw-normal">icofont-facebook</option>
                                                <option value="fab fa-twitter fw-normal">icofont-twitter</option>
                                                <option value="fab fa-linkedin-in fw-normal">icofont-linkedin</option>
                                                <option value="fab fa-instagram fw-normal">icofont-instagramr</option>
                                                <option value="fab fa-youtube fw-normal">icofont-Youtube</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveSocialMedia" class="btn btn-primary" data-bs-dismiss="modal">Procesar</button>
                </div>
            </div>
        </div>
    </div>
</div>

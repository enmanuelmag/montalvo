<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>
                <div class="card-body">
                    <form id="updateFooterForm" class="form" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">

                                <input type="hidden" name="id" value="{{$landingFooter->id}}">
                                <div class="mb-1">
                                    <label class="form-label" for="titulo_1">Titulo Footer 1: </label>
                                    <input type="text" id="titulo_1" class="form-control"
                                           value="{{$landingFooter->titulo_1}}"
                                           placeholder="Guayaquil - Ecuador" name="titulo_1" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="titulo_2">Titulo Footer 2:</label>
                                    <input type="text" id="titulo_2" class="form-control"
                                           value="{{$landingFooter->titulo_2}}"
                                           placeholder="" name="titulo_2" />
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="direccion">Direccion:</label>
                                    <input type="text" id="direccion" class="form-control"
                                           value="{{$landingFooter->direccion}}"
                                           placeholder="" name="direccion" />
                                </div>
                            </div>



                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="telefono">Telefono:</label>
                                            <input type="tel" id="telefono" class="form-control"
                                                   value="{{$landingFooter->telefono}}"
                                                   placeholder="Lun - Vir" name="telefono" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="email">Email:</label>
                                            <input type="email" id="email" class="form-control"
                                                   value="{{$landingFooter->email}}"
                                                   placeholder="" name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="fax">Fax - Telefono Convencional:</label>
                                            <input type="number" id="fax" class="form-control"
                                                   value="{{$landingFooter->fax}}"
                                                   placeholder="" name="fax" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="nombreEmpresaFooter">Nombre Empresa Footer:</label>
                                            <input type="text" id="nombreEmpresaFooter" class="form-control"
                                                   value="{{$landingFooter->nombreEmpresaFooter}}"
                                                   placeholder="" name="nombreEmpresaFooter" />
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="whatsaap_link">Link de WhatsApp:</label>
                                            <input type="text" id="whatsaap_link" class="form-control"
                                                   value="{{$landingFooter->whatsaap_link}}"
                                                   placeholder="" name="whatsaap_link" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1">ACTUALIZAR</button>
                                <button type="reset" class="btn btn-outline-secondary">LIMPIAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>
                <div class="card-body">
                    <form id="updateServiceForm" class="form" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <input type="hidden" name="id" value="{{$landingServices->id}}">
                                <div class="mb-1">
                                    <label class="form-label" for="title">Titulo: </label>
                                    <input type="text" id="title" class="form-control"
                                           value="{{$landingServices->title}}"
                                           placeholder="Guayaquil - Ecuador" name="title" />
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="description">Descripcion:</label>
                                    <input type="text" id="description" class="form-control"
                                           value="{{$landingServices->description}}"
                                           placeholder="" name="description" />
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="boton_text">Titulo Botón:</label>
                                            <input type="text" id="boton_text" class="form-control"
                                                   value="{{$landingServices->boton_text}}"
                                                   placeholder="Lun - Vir" name="boton_text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="boton_link">Ruta Botón:</label>
                                            <input type="text" id="boton_link" class="form-control"
                                                   value="{{$landingServices->boton_link}}"
                                                   placeholder="" name="boton_link" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1">ACTUALIZAR</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

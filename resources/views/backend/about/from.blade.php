<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>
                <div class="card-body">
                    <form id="updateAboutForm" class="form" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-4 col-12">
                                <input type="hidden" name="id" value="{{$landingAbout->id}}">
                                <div class="mb-1">
                                    <label class="form-label" for="titulo">Titulo: </label>
                                    <input type="text" id="titulo" class="form-control"
                                           value="{{$landingAbout->titulo}}"
                                           placeholder="Guayaquil - Ecuador" name="titulo" />
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="descripcion1">Descripcion:</label>
                                    <input type="text" id="descripcion1" class="form-control"
                                           value="{{$landingAbout->descripcion1}}"
                                           placeholder="" name="descripcion1" />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="parrafo1">Parrafo 1:</label>
                                    <input type="text" id="parrafo1" class="form-control"
                                           value="{{$landingAbout->parrafo1}}"
                                           placeholder="Parrafo 1" name="parrafo1" />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="parrafo2">Parrafo 2:</label>
                                    <input type="text" id="parrafo2" class="form-control"
                                           value="{{$landingAbout->parrafo2}}"
                                           placeholder="" name="parrafo2" />
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="imagen">Imagen de Seccion: </label>
                                    <img id="preview_imagen" src="{{ asset($landingAbout->imagen) }}" alt="Imagen de Seccion" class="preview-image">
                                    <input type="file" id="imagen" class="form-control"
                                           value="{{$landingAbout->imagen}}"
                                           name="imagen" placeholder="imagen" />
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="imagen_seccion">Imagen Fondo Seccion: </label>
                                    <img id="preview_imagen_seccion" src="{{ asset($landingAbout->imagen_seccion) }}" alt="Imagen de Seccion" class="preview-image">
                                    <input type="file" id="imagen_seccion" class="form-control"
                                           value="{{$landingAbout->imagen_seccion}}"
                                           name="imagen_seccion" placeholder="imagen" />
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="btn_text">Titulo Boton:</label>
                                            <input type="text" id="btn_text" class="form-control"
                                                   value="{{$landingAbout->btn_text}}"
                                                   placeholder="Lun - Vir" name="btn_text" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="btn_link">Ruta Boton:</label>
                                            <input type="text" id="btn_link" class="form-control"
                                                   value="{{$landingAbout->btn_link}}"
                                                   placeholder="" name="btn_link" />
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

<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route($ruta) }}" method="POST" class="form" id="from_item_oferta" enctype="multipart/form-data" onsubmit="return prepararContenidoQuill();">

                    @csrf
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <input type="hidden" id="id" name="id" value="{{ $blog->id ?? 0 }}">

                                <div class="mb-1">
                                    <label class="form-label" for="titulo">Nombre de la Oferta: </label>
                                    <input type="text" id="titulo" class="form-control"
                                           value="{{$blog->titulo}}"
                                           placeholder="Guayaquil - Ecuador" name="titulo" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Salario Ofertado</label>
                                    <input type="text" id="autor" class="form-control"
                                           value="{{$blog->autor}}"
                                           placeholder="" name="autor" />
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="subtitulo">Detalles Basicos</label>
                                    <input type="text" id="subtitulo" class="form-control"
                                           value="{{$blog->subtitulo}}"
                                           placeholder="" name="subtitulo" />
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Fecha Maxima de Postulacion</label>
                                    <input type="date" id="fecha" class="form-control"
                                           value="{{$blog->fecha}}"
                                           placeholder="" name="fecha" />
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Telefono</label>
                                    <input type="text" id="tipo" class="form-control"
                                           value="{{$blog->tipo}}"
                                           placeholder="" name="tipo" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Correo de Contacto</label>
                                    <input type="text" id="tags" class="form-control"
                                           value="{{$blog->tags}}"
                                           placeholder="" name="tags" />
                                </div>
                            </div>

                            <input type="hidden" name="detalle_completo" id="detalle_completo">

                            <div class="col-12">
                                <section class="snow-editor">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Detalle completo de la Oferta Laboral</h4>
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">En esta sección usted debera detallar toda la oferta tipo Multitrabajos y Otro buscador de candidatos.</p>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div id="snow-wrapper">
                                                                <div id="snow-container">
                                                                    <div class="quill-toolbar">
                                                                                        <span class="ql-formats">
                                                                                          <select class="ql-header">
                                                                                            <option value="1">Heading</option>
                                                                                            <option value="2">Subheading</option>
                                                                                            <option selected>Normal</option>
                                                                                          </select>
                                                                                          <select class="ql-font">
                                                                                            <option selected>Sailec Light</option>
                                                                                            <option value="sofia">Sofia Pro</option>
                                                                                            <option value="slabo">Slabo 27px</option>
                                                                                            <option value="roboto">Roboto Slab</option>
                                                                                            <option value="inconsolata">Inconsolata</option>
                                                                                            <option value="ubuntu">Ubuntu Mono</option>
                                                                                          </select>
                                                                                        </span>
                                                                        <span class="ql-formats">
                                                                                          <button class="ql-bold"></button>
                                                                                          <button class="ql-italic"></button>
                                                                                          <button class="ql-underline"></button>
                                                                                        </span>
                                                                        <span class="ql-formats">
                                                                                              <button class="ql-list" value="ordered"></button>
                                                                                              <button class="ql-list" value="bullet"></button>
                                                                                            </span>
                                                                        <span class="ql-formats">
                                                                                              <button class="ql-link"></button>
                                                                                              <button class="ql-image"></button>
                                                                                              <button class="ql-video"></button>
                                                                                            </span>
                                                                        <span class="ql-formats">
                                                                                              <button class="ql-formula"></button>
                                                                                              <button class="ql-code-block"></button>
                                                                                            </span>
                                                                        <span class="ql-formats">
                                                                                              <button class="ql-clean"></button>
                                                                                            </span>
                                                                    </div>
                                                                    <div class="editor" id="quillEditor">
                                                                        {!! $blog->detalle !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="imagen">Imagen Referente a la Oferta: </label>
                                    <img id="preview_imagen"
                                         src="{{ $blog->imagen ? asset($blog->imagen) : asset('files/img/planceholder.jpg') }}"
                                         alt="Imagen de Sección"
                                         class="preview-image">
                                    <input type="file" id="imagen" class="form-control"
                                           value="{{$blog->imagen}}"
                                           name="imagen" placeholder="imagen" />
                                </div>
                            </div>



                            <div class="col-12">
                                <button type="submit" id="saveButton" class="btn btn-primary me-1">{{ $boton }}</button>
                                <button type="reset" class="btn btn-outline-secondary">LIMPIAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

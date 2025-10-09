<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <!-- Vertical Wizard -->
                            <section class="modern-vertical-wizard">
                                <div class="bs-stepper vertical wizard-modern modern-vertical-wizard-example">
                                    <input type="hidden" name="id_capacitacion" id="id_capacitacion" value="{{ $capacitacion->id }}">
                                    <!-- Stepper Header -->
                                    <div class="bs-stepper-header">
                                        <!-- Account Details Step -->
                                        <div class="step active" data-target="#informacion_basica" role="tab" id="tab_informacion_basica">
                                            <button type="button" class="step-trigger" aria-selected="true">
                                                <span class="bs-stepper-box">
                                                    <i class="fas fa-file-alt font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Información Básica</span>
                                                    <span class="bs-stepper-subtitle">Rellene todos los campos</span>
                                                </span>
                                            </button>
                                        </div>

                                        <!-- Personal Info Step -->
                                        <div class="step" data-target="#informacion_adicional" role="tab" id="tab_informacion_adicional">
                                            <button type="button" class="step-trigger" aria-selected="false">
                                                <span class="bs-stepper-box">
                                                    <i class="fas fa-file-alt font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Información Adicional</span>
                                                    <span class="bs-stepper-subtitle">Rellene y Seleccione los campos</span>
                                                </span>
                                            </button>
                                        </div>

                                        <!-- Social Links Step -->
                                        <div class="step" data-target="#multimedia" role="tab" id="tab_multimedia">
                                            <button type="button" class="step-trigger" aria-selected="false">
                                                <span class="bs-stepper-box">
                                                    <i class="fas fa-file-alt font-medium-3"></i>
                                                </span>
                                                <span class="bs-stepper-label">
                                                    <span class="bs-stepper-title">Multimedia</span>
                                                    <span class="bs-stepper-subtitle">Agrega 1 Foto y si desea un Video</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Stepper Content -->
                                    <div class="bs-stepper-content">

                                        <!-- Account Details Content -->
                                        <div id="informacion_basica" class="content dstepper-block active" role="tabpanel" aria-labelledby="tab_informacion_basica">
                                            <div class="content-header">
                                                <h5 class="mb-0">Información Básica</h5>
                                                <small class="text-muted">Titulo, Subtitulo o Categoria y Resumen.</small>
                                            </div>
                                            <div class="row">
                                                <div class=" col-sm-12 col-md-6">
                                                    <label class="form-label" for="vertical-modern-username">Titulo de la Capacitación</label>
                                                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="johndoe"
                                                    value="{{ $capacitacion->titulo }}">
                                                </div>
                                                <div class=" col-md-6 col-sm-12">
                                                    <label class="form-label" for="vertical-modern-email">SubTitulo - Categoria</label>
                                                    <input type="text" id="subtitulo_categoria" name="subtitulo_categoria" class="form-control"
                                                           placeholder="john.doe@email.com" value="{{ $capacitacion->subtitulo }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label" for="vertical-modern-confirm-password">Resumen de Maximo 100 Palabras</label>
                                                    <input type="text" id="resumen_minimo" name="resumen_minimo" class="form-control" placeholder="············"
                                                    value="{{ $capacitacion->detalle }}">
                                                </div>
                                                <div class="col-12">
                                                    <section class="snow-editor">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h4 class="card-title">Detalle completo del Curso </h4>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <p class="card-text">En esta sección usted podra detallar lo más relavante de la capacitación.</p>
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
                                                                                        <div class="editor">
                                                                                            {!! $capacitacion->resumen !!}
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

                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-outline-secondary btn-prev waves-effect" disabled>
                                                    <i class="fas fa-arrow-left align-middle me-sm-25 me-0"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                                </button>
                                                <button class="btn btn-primary btn-next waves-effect waves-float waves-light">
                                                    <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                                    <i class="fas fa-arrow-right align-middle ms-sm-25 ms-0"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Personal Info Content -->
                                        <div id="informacion_adicional" class="content dstepper-block" role="tabpanel" aria-labelledby="tab_informacion_adicional">
                                            <div class="content-header">
                                                <h5 class="mb-0">Información Adicional del Curso / Capacitación</h5>
                                                <small>Detalle y Seleccione todos los campos, esta información sera la primera que vea el usuario en la Web.</small>
                                            </div>
                                            <div class="row">
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label" for="vertical-modern-first-name">Precio</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" id="precio_curso" name="precio_curso" class="form-control" placeholder="100.00"
                                                        value="{{$capacitacion->precio}}">
                                                    </div>
                                                </div>
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label" for="fecha">Fecha</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                                        <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $capacitacion->fecha_inicio }}">
                                                    </div>
                                                </div>
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label" for="duracion">Duración del Curso</label>
                                                    <div class="input-group">
                                                        <input type="number" id="duracion" name="duracion" class="form-control" placeholder="40" value="{{$capacitacion->duracion}}">
                                                        <select id="unidad_duracion" name="unidad_duracion" class="form-select">
                                                            <option value="horas" {{ $capacitacion->unidad_duracion == 'horas' ? 'selected' : '' }}>Horas</option>
                                                            <option value="dias" {{ $capacitacion->unidad_duracion == 'dias' ? 'selected' : '' }}>Días</option>
                                                            <option value="semanas" {{ $capacitacion->unidad_duracion == 'semanas' ? 'selected' : '' }}>Semanas</option>
                                                            <option value="meses" {{ $capacitacion->unidad_duracion == 'meses' ? 'selected' : '' }}>Meses</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label" for="modalidad">Modalidad del Curso</label>
                                                    <div class="input-group">
                                                        <select id="modalidad" name="modalidad" class="form-select">
                                                            <option value="presencial" {{ $capacitacion->horario == 'presencial' ? 'selected' : '' }}>Presencial</option>
                                                            <option value="online" {{ $capacitacion->horario == 'online' ? 'selected' : '' }}>Online</option>
                                                            <option value="hibrida" {{ $capacitacion->horario == 'hibrida' ? 'selected' : '' }}>Híbrida</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- Basic -->
                                                <div class="col-md-6 col-sm-12 ">
                                                    <div class="card">
                                                        <label class="form-label" for="basic-ratings">Valoración del Curso</label>

                                                        <div class="basic-ratings"></div>

                                                    </div>
                                                </div>
                                                <div class="mb-1 col-md-6">
                                                    <label class="form-label" for="categoria_id">Categoria del Curso</label>
                                                    <div class="input-group">
                                                        <select id="categoria_id" name="categoria_id" class="form-select">
                                                            @foreach($categorias as $item)
                                                                <option value="{{ $item->id }}" {{ $capacitacion->categoria_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->titulo }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 ">
                                                    <div class="card">
                                                        <label class="form-label" for="basic-ratings">URL del Curso Moodle </label>

                                                        <div class="input-group">
                                                            
                                                            <input type="text" id="link_moodle" name="link_moodle" class="form-control" placeholder="#"
                                                            value="{{$capacitacion->certificacion}}">
                                                        </div>

                                                    </div>
                                                </div> 
                                                <div class="mb-1 col-md-6">
                                                 
                                                    <label class="form-label" for="categoria_id">Curso de Moodle</label>
                                                    <div class="input-group">
                                                        <select id="moodle_id" name="moodle_id" class="form-select">
                                                            @foreach($cursosSimplificados as $item)
                                                                <option value="{{ $item['id'] }}" {{ $capacitacion->lugar == $item['id'] ? 'selected' : '' }}>
                                                                    {{ $item['fullname'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--/ Basic -->
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-primary btn-prev waves-effect waves-float waves-light">
                                                    <i class="fas fa-arrow-left align-middle me-sm-25 me-0"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                                </button>
                                                <button class="btn btn-primary btn-next waves-effect waves-float waves-light">
                                                    <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                                    <i class="fas fa-arrow-right align-middle ms-sm-25 ms-0"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Social Links Content -->
                                        <div id="multimedia" class="content dstepper-block" role="tabpanel" aria-labelledby="tab_multimedia">
                                            <div class="content-header">
                                                <h5 class="mb-0">Multimedia</h5>
                                                <small>Puede Agregar 1 Foto y 1 Video.</small>
                                            </div>
                                            <!-- remove all thumbnails file upload starts -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">Remover todos los archivos</h4>
                                                        </div>
                                                        <div class="card-body">
                                                           <div class="row">
                                                               <div class="col-md-6 col-sm-12">
                                                                   <img src="{{ asset($capacitacion->imagen) }}" alt="imagen" width="200px" height="200px">
                                                               </div>
                                                           </div>
                                                            <button id="clear-dropzone" class="btn btn-outline-primary mb-1">
                                                                <i data-feather="trash" class="me-25"></i>
                                                                <span class="align-middle">Eliminar Multimedia</span>
                                                            </button>
                                                            <form action="#" class="dropzone dropzone-area" id="dpz-remove-all-thumb">
                                                                <div class="dz-message">Suelte sus archivos aqui o de click para subirlos.</div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- remove all thumbnails file upload ends -->

                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-primary btn-prev waves-effect waves-float waves-light">
                                                    <i class="fas fa-arrow-left align-middle me-sm-25 me-0"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                                </button>
                                                <button class="btn btn-success btn-submit waves-effect waves-float waves-light">
                                                    Enviar
                                                </button>
                                            </div>
                                        </div>

                                    </div><!-- End Stepper Content -->

                                </div><!-- End bs-stepper -->
                            </section><!-- End Vertical Wizard -->
                        </div>
                    </div>
                </div><!-- End Card Body -->
            </div><!-- End Card -->
        </div><!-- End col-12 -->
    </div><!-- End Row -->
</section><!-- End Section -->

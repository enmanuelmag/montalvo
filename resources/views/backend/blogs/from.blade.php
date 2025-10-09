<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $Title }}</h4>
                </div>
                <div class="card-body">
                    <form id="updateBlogForm" class="form" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <input type="hidden" name="id" value="{{$blog->id}}">
                                <div class="mb-1">
                                    <label class="form-label" for="titulo">Titulo: </label>
                                    <input type="text" id="titulo" class="form-control"
                                           value="{{$blog->titulo}}"
                                           placeholder="Guayaquil - Ecuador" name="titulo" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="subtitulo">Subtitulo:</label>
                                    <input type="text" id="subtitulo" class="form-control"
                                           value="{{$blog->subtitulo}}"
                                           placeholder="" name="subtitulo" />
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detalle">Detalle</label>
                                    <input type="text" id="detalle" class="form-control"
                                           value="{{$blog->detalle}}"
                                           placeholder="" name="detalle" />
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

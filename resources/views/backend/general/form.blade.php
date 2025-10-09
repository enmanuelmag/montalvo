
<form id="storeGeneralForm" class="form" enctype="multipart/form-data"  method="POST">
    @csrf
    <div class="row">
        <input type="hidden" name="idSeccion" id="idSeccion">
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="titulo">Titulo: </label>
                <input type="text" id="titulo" class="form-control"
                       value=""
                       placeholder="Daule - River Plaza" name="titulo" />
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="subtitulo">Subtitulo:</label>
                <input type="text" id="subtitulo" class="form-control"
                       value=""
                       placeholder="Lun - Vir" name="subtitulo" />
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="mb-1">
                <label class="form-label" for="descripcion">Descripcion:</label>
                <input type="text"  id="descripcion" class="form-control"
                       value=""
                       placeholder="" name="descripcion" />
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="mb-1">
                <label class="form-label" for="imagen">Imagen de Sección: </label>
                <img id="preview_imagen" src="{{ asset('files/img/planceholder.jpg') }}" alt="Imagen de Sección" class="preview-image">
                <input type="file" id="imagen" class="form-control"
                       value=""
                       name="imagen" placeholder="imagen" />
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="btn_text">Titulo Botón:</label>
                        <input type="text" id="btn_text" class="form-control"
                               value=""
                               placeholder="Lun - Vir" name="btn_text" />
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="form-label" for="btn_link">Ruta Botón 1:</label>
                        <input type="text" id="btn_link" class="form-control"
                               value=""
                               placeholder="Lun - Vir" name="btn_link" />
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-12">
        <button id="saveGeneral" type="button" class="btn btn-primary me-1">Guardar</button>
        <button type="button" id="updateGeneral" hidden="true" class="btn btn-primary me-1">Actualizar</button>
        <button type="reset" class="btn btn-outline-secondary">LIMPIAR</button>
    </div>
</form>

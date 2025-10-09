
<form id="updateContactoForm" class="form" enctype="multipart/form-data"  method="POST">
    @csrf
    <div class="row">

        <input type="hidden" name="idlandingAContacto" id="idlandingAContacto" value="{{ $landingAContacto->id }}">
        <input type="hidden" name="idlandingInformacionContacto" id="idlandingInformacionContacto" value="{{ $landingInformacionContacto->id }}">
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="titulo">Titulo: </label>
                <input type="text" id="nombre" class="form-control"
                       value="{{ $landingAContacto->nombre ?? '' }}"
                       placeholder="Contactos" name="nombre" />
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="detalle">Subtitulo:</label>
                <input type="text" id="detalle" class="form-control"
                       value="{{ $landingAContacto->detalle ?? '' }}"
                       placeholder="Lun - Vir" name="detalle" />
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="titulo_2">Descripcion:</label>
                <input type="text"  id="titulo_2" class="form-control"
                       value="{{ $landingInformacionContacto->titulo ?? '' }}"
                       placeholder="" name="titulo_2" />
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="mb-1">
                <label class="form-label" for="subtitulo">Descripcion:</label>
                <input type="text"  id="subtitulo" class="form-control"
                       value="{{ $landingInformacionContacto->subtitulo ?? '' }}"
                       placeholder="" name="subtitulo" />
            </div>
        </div>
        <div class="col-md-12 col-12">
            <div class="mb-1">
                <label class="form-label" for="detalle_2">Descripción:</label>
                <textarea id="detalle_2" class="form-control" name="detalle_2"
                          placeholder="">{{ $landingInformacionContacto->detalle ?? '' }}</textarea>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="mb-1">
                <label class="form-label" for="imagen">Imagen de Sección: </label>
                <img id="preview_imagen" src="{{ asset( $landingAContacto->imagen_seccion ?? '') }}" alt="Imagen de Sección" class="preview-image">
                <input type="file" id="imagen" class="form-control"
                       value=""
                       name="imagen" placeholder="imagen" />
            </div>
        </div>


    </div>
    <div class="col-12">

        <button type="submit" id="updateContacto" class="btn btn-primary me-1">Actualizar</button>

    </div>
</form>

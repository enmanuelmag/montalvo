<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $topBarTitle }}</h4>
                </div>
                <div class="card-body">
                    <form id="updateTopBarForm" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="direccion_top">Dirección: </label>
                                    <input type="text" id="direccion_top" class="form-control"
                                           value="{{ $topBar['direccion'] }}"
                                           placeholder="Daule - River Plaza" name="direccion_top" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="horario_atencion">Horarios de Atención:</label>
                                    <input type="text" id="horario_atencion" class="form-control"
                                           value="{{ $topBar['horario_atencion'] }}"
                                           placeholder="Lun - Vir" name="horario_atencion" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="telefono_top">Teléfono:</label>
                                    <input type="tel" min="9" maxlength="10" max="10" id="telefono_top" class="form-control"
                                           value="{{ $topBar['telefono_contacto'] }}"
                                           placeholder="0909090909" name="telefono_top" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="correo_electronico">Correo Electronico: </label>
                                    <input type="email" id="correo_electronico" class="form-control"
                                           value="{{ $topBar['correo_contacto'] }}"
                                           name="correo_electronico" placeholder="correo_electronico" />
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

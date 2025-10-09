<!-- Tour Booking Start -->
<div class="container-fluid booking py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h5 class="section-booking-title pe-3">{{ $informacionContacto->titulo }}</h5>
                <h1 class="text-white mb-4">{{ $informacionContacto->subtitulo }}</h1>
                <p class="text-white mb-4">{{ $informacionContacto->detalle }}
                </p>

            </div>
            <div class="col-lg-6">
                <h1 class="text-white mb-3">{{ $contacto->nombre }}</h1>
                <p class="text-white mb-4">{{ $contacto->detalle }}</p>
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-white border-0" id="name" placeholder="Ingrese sus Nombres">
                                <label for="name">Nombres</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-white border-0" id="apellidos" placeholder="Ingrese sus Apellidos">
                                <label for="email">Apellidos</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3" data-target-input="nearest">
                                <input type="text" class="form-control bg-white border-0" id="telefono" placeholder="Telefono" data-target="#date3" data-toggle="datetimepicker" />
                                <label for="datetime">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3" data-target-input="nearest">
                                <input type="email" class="form-control bg-white border-0" id="email" placeholder="Ingrese su Email" />
                                <label for="datetime">Correo </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-white border-0" placeholder="Special Request" id="message" style="height: 100px"></textarea>
                                <label for="message">Ingrese su Consulta o Duda </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary text-white w-100 py-3" type="submit">Enviar Consulta o Solicitud</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Tour Booking End -->

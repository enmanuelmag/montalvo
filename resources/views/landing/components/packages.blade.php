<!-- Packages Start -->
<div class="container-fluid packages py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">{{ $capacitacion->titulo }}</h5>
            <h1 class="mb-0">{{ $capacitacion->subtitulo }}</h1>
        </div>
        <div class="packages-carousel owl-carousel">
            @foreach($capacitaciones as $item)
                <div class="packages-item">
                    <div class="packages-img">
                        <img src="{{ asset($item->imagen) }}" class="img-fluid w-100 rounded-top" alt="Image">
                        <div class="packages-info d-flex border border-start-0 border-end-0 position-absolute" style="width: 100%; bottom: 0; left: 0; z-index: 5;">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-map-marker-alt me-2"></i>{{ $item->horario }}</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt me-2"></i>{{$item->duracion }} {{$item->unidad_duracion}}</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-calendar me-2"></i>{{$item->fecha_inicio}}</small>
                        </div>
<div class="packages-price py-2 px-4" style="text-align: center; font-weight: bold;">${{$item->precio}}</div>

                    </div>
                    <div class="packages-content bg-light">
                        <div class="p-4 pb-0">
                            <h5 class="mb-0">{{ $item->titulo }}</h5>
                            <small class="text-uppercase">{{ $item->subtitulo }}</small>
                            <div class="mb-3">
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                                <small class="fa fa-star text-primary"></small>
                            </div>
                            <p class="mb-4">{{ $item->detalle }}</p>
                        </div>
                        
                        <div class="row bg-primary rounded-bottom mx-0">
                            <div class="col-6 text-start px-0">
                                <a href="{{ $item->certificacion }}" target="_blank" class="btn-hover btn text-white py-2 px-4">Ver más detalles</a>
                            </div>
                            <div class="col-6 text-end px-0">
                                <a href="{{ route('pagos.publico.iniciar', ['cursoId' => $item->id]) }}" class="btn-hover btn text-white py-2 px-4">Comprar Ahora</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Packages End -->

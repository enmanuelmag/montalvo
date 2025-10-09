<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h3 class="section-title px-3">{{ $seccionClientes->titulo }}</h3>
        </div>

        <!-- Carousel -->
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                @foreach($clientes->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach($chunk as $item)
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <!-- Agregamos estilos en línea a la imagen -->
                                        <img src="{{ asset($item->imagen) }}"
                                             class="d-block w-100"
                                             alt="{{ $item->titulo }}"
                                             style="width: 80%; height: auto;  max-width: 200px; margin: 0 auto; max-height: 150px;" width="100%" height="100%" >
                                        <!-- Estilo en línea para el texto -->
                                        <h5 class="mt-3" style="font-size: 1rem;">{{ $item->titulo }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- End of Carousel -->
    </div>
</div>

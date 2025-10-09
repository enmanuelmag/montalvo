<!-- Carousel Start -->
<div class="carousel-header">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($general as $index => $item)
                <li data-bs-target="#carouselId" data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($general as $item)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    @if($loop->first)
                        <!-- La primera imagen (visible) se carga inmediatamente con fetchpriority alto -->
                        <img 
                            src="{{ asset($item->imagen ?? '') }}" 
                            class="img-carousel" 
                            alt="{{ $item->titulo ?? 'Imagen del carousel' }}"
                            width="1200"
                            height="600"
                            fetchpriority="high">
                    @else
                        <!-- El resto de imágenes se cargan con lazy loading -->
                        <img 
                            loading="lazy" 
                            src="{{ asset($item->imagen ?? '') }}" 
                            class="img-carousel" 
                            alt="{{ $item->titulo ?? 'Imagen del carousel' }}"
                            width="1200"
                            height="600">
                    @endif
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">{{ $item->titulo ?? '' }}</h4>
                            <h1 class="display-2 text-capitalize text-white mb-4">{{ $item->subtitulo ?? '' }}</h1>
                            <p class="mb-5 fs-5">{{ $item->descripcion ?? '' }}</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-3 px-5" href="{{ $item->btn_link ?? '#' }}">{{ $item->btn_text ?? '' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon btn bg-primary" aria-hidden="false"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon btn bg-primary" aria-hidden="false"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->

<!-- CSS para optimizar el carousel y eliminar el espacio en gris -->
<style>
/* Estilos para las imágenes del carousel */
.img-carousel {
    width: 100%;
    height: auto;
    object-fit: cover;
    aspect-ratio: 2/1; /* Mantiene una proporción consistente */
}

/* Estilos para carousel con placeholders */
.carousel-item {
    position: relative;
    background-color: #f0f0f0; /* Color de fondo mientras carga */
    min-height: auto; /* Eliminar altura mínima fija */
    overflow: hidden; /* Evitar desbordamiento */
}

/* Corregir el contenedor del carousel */
.carousel-header {
    margin-bottom: 0;
    padding-bottom: 0;
    overflow: hidden;
}

/* Ajustar altura del carousel */
.carousel, .carousel-inner {
    height: auto;
    margin-bottom: 0;
    padding-bottom: 0;
}

/* Asegurar que los controles estén visibles */
.carousel-control-prev, .carousel-control-next {
    z-index: 10;
}

/* Asegurar que la imagen se ajuste correctamente */
@media (max-width: 768px) {
    .carousel-item {
        height: auto;
    }
    .img-carousel {
        max-height: 60vh;
    }
    .carousel-caption {
        padding-bottom: 1rem;
    }
}

/* Eliminar cualquier margen inferior excesivo */
#carouselId::after {
    content: none;
}
</style>

<!-- Preload para la primera imagen (colocar en el head) -->
@if(count($general) > 0)
<!-- 
<link 
    rel="preload" 
    href="{{ asset($general[0]->imagen ?? '') }}" 
    as="image"
    fetchpriority="high">
-->
@endif
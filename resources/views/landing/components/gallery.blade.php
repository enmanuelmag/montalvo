<!-- Gallery Start -->
<div class="container-fluid gallery py-5 my-5">
    <div class="mx-auto text-center mb-5" style="max-width: 900px;">
        <h5 class="section-title px-3">{{ $galeria->titulo }}</h5>
        <h1 class="mb-4">{{ $galeria->subtitulo }}</h1>
        <p class="mb-0">{{ $galeria->detalle }}
        </p>
    </div>
    <div class="tab-class text-center">
        <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
            <li class="nav-item">
                <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill"
                   data-bs-toggle="pill" href="#all">
                    <span class="text-dark" style="width: 150px;">Todas</span>
                </a>
            </li>
            @foreach($categoriasGaleria as $item)
            <li class="nav-item">
                <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill "
                   data-bs-toggle="pill" href="#categoria_{{ $item->id }}">
                    <span class="text-dark" style="width: 150px;">{{ $item->titulo }}</span>
                </a>
            </li>
            @endforeach

        </ul>
        <div class="tab-content">
            <div id="all" class="tab-pane fade show p-0 active">
                <div class="row g-2">
                    @foreach($itemsGaleria as $item)
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                        <div class="gallery-item h-100">
                            <img src="{{ asset($item->imagen ?? '') }} " class="img-fluid w-100 h-100 rounded" alt="Image">
                            <div class="gallery-content">
                                <div class="gallery-info">
                                    <h5 class="text-white text-uppercase mb-2">{{ $item->titulo ?? '' }}</h5>
                                    <a href="#" class="btn-hover text-white">{{ $item->detalle ?? '' }} <i class="fa fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                            <div class="gallery-plus-icon">
                                <a href="{{ asset($item->imagen ?? '') }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @foreach($categoriasGaleria as $itemCategoria)
                <div id="categoria_{{ $itemCategoria->id }}" class="tab-pane fade show p-0">
                    <div class="row g-2">

                        @foreach($itemsGaleria as $item)
                            @if($itemCategoria->id == $item->landing_categoria_trabajo_id)
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-2">
                                <div class="gallery-item h-100">
                                    <img src="{{ asset($item->imagen ?? '') }} " class="img-fluid w-100 h-100 rounded" alt="Image">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ $item->titulo ?? '' }}</h5>
                                            <a href="#" class="btn-hover text-white">{{ $item->detalle ?? '' }} <i class="fa fa-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ asset($item->imagen ?? '') }}" data-lightbox="gallery-1" class="my-auto"><i class="fas fa-plus fa-2x text-white"></i></a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Gallery End -->



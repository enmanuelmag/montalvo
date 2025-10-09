<!-- Travel Guide Start -->
<div class="container-fluid guide py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">{{ $seccionEquipo->titulo }}</h5>
            <h1 class="mb-0">{{ $seccionEquipo->subtitulo }}</h1>
        </div>
        <div class="row g-4">
            @foreach($equipoTrabajo as $item)
            <div class="col-md-6 col-lg-3">
                <div class="guide-item">
                    <div class="guide-img">
                        <div class="guide-img-efects">
                            <img src="{{ asset($item->imagen) }}" class="img-fluid w-100 rounded-top fixed-size" alt="Image">
                        </div>
                        <div class="guide-icon rounded-pill p-2">
                            @if ($item->facebook != '#')
                                <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{$item->facebook}}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            
                            @if ($item->twitter != '#')
                                <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{$item->twitter}}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            
                            @if ($item->instagram != '#')
                                <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{$item->instagram}}">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            
                            @if ($item->linkedin != '#')
                                <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{$item->linkedin}}">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="guide-title text-center rounded-bottom p-4">
                        <div class="guide-title-inner">
                            <h4 class="mt-3">{{ $item->nombre }}</h4>
                            <p class="mb-0">{{ $item->cargo }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- Travel Guide End -->


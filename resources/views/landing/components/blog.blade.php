<!-- Blog Start -->
<div class="container-fluid blog py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h5 class="section-title px-3">{{ $blog->subtitulo }}</h5>
            <h1 class="mb-4">{{ $blog->titulo }}</h1>
            <p class="mb-0">{{ $blog->detalle }}
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($blogs as $item)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <div class="blog-img">
                        <div class="blog-img-inner">
                            <img class="img-fluid w-100 rounded-top" src="{{ asset($item->imagen) }}" width="100%" 
     height="100%" alt="Image">
                            <div class="blog-icon">
                                <a href="{{ url('/verBlog/'.$item->id) }}" class="my-auto"><i class="fas fa-link fa-2x text-white"></i></a>
                            </div>
                        </div>
                        <div class="blog-info d-flex align-items-center border border-start-0 border-end-0">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $item->fecha }}</small>

                        </div>
                    </div>
                    <div class="blog-content border border-top-0 rounded-bottom p-4">
                        <p class="mb-3">Publicado por: {{ $item->autor }} </p>
                        <a href="#" class="h4">{{ $item->titulo }}</a>
                        <p class="my-3">{{ $item->tags }}</p>
                        <a href="{{ url('/verBlog/'.$item->id) }}" class="btn btn-primary rounded-pill py-2 px-4">Leer Blog</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row pt-3">
            <div class="col-md-12 text-end">
                <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Ver todos los Blogs</a>
            </div>
        </div>
    </div>
</div>
<!-- Blog End -->

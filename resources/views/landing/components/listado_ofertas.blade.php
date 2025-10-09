<!-- Blog Start -->
<div class="container-fluid blog py-5">
    <div class="container py-5">
        <div class="mx-auto text-center mb-5" style="max-width: 900px;">
            <h1 class="mb-4">Ofertas Laborales Activas y Pasadas.</h1>
            <p class="mb-0">Participa en nuestras ofertas laborales y encuentra el trabajo de tus sueños.
            </p>
        </div>

        <!-- Listado de ofertas en formato de cards -->
        <div class="row">
            @foreach($blogs as $item)
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm d-flex flex-row align-items-center p-3">
                        <!-- Imagen a la izquierda -->
                        <div class="card-img-left me-3" style="width: 30%; max-width: 250px;">
                            <img class="img-fluid rounded" src="{{ asset($item->imagen) }}" alt="Image" style="height: 100%; width: 100%; object-fit: cover;">
                        </div>

                        <!-- Contenido del card -->
                        <div class="card-body" style="width: 70%;">
                            <h4 class="card-title">{{ $item->titulo }}</h4>
                            <p class="card-text text-muted mb-2">Publicado por: {{ $item->autor }}</p>
                            <p class="card-text text-muted mb-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{ $item->fecha }}</p>
                            <p class="card-text">{{ $item->tags }}</p> <!-- Limitar la longitud de los tags o descripción -->

                            <p class="card-text">{{ $item->subtitulo }}</p> <!-- Limitar la longitud de los tags o descripción -->

                            <a href="{{ url('/verOferta/'.$item->id) }}" class="btn btn-primary rounded-pill py-2 px-4 mt-3">Ver Oferta</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Blog End -->

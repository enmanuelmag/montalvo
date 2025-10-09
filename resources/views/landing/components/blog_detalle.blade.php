<!-- Blog Start -->
<div class="container-fluid blog py-10">
    <div class="container py-5">
        <!-- Título del blog -->
        <h1 class="mb-4">{{ $blog->titulo }}</h1>

        <!-- Subtítulo del blog -->
        <h3 class="mb-3 text-muted">{{ $blog->subtitulo }}</h3>

        <!-- Información del autor y fecha -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="text-muted">
                <strong>Autor: </strong>{{ $blog->autor }}
            </span>
            <span class="text-muted">
                <strong>Fecha: </strong>{{ \Carbon\Carbon::parse($blog->fecha)->format('d M, Y') }}
            </span>
        </div>

        <!-- Imagen principal del blog -->
        <div class="mb-4 text-center">
            <img src="{{ asset($blog->imagen) }}" alt="Imagen del Blog" class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
        </div>

        <!-- Resumen del blog -->
        <div class="mb-4">
            <h4 class="text-muted">Resumen</h4>
            <p>{{ $blog->tags }}</p>
        </div>

        <!-- Contenido largo del blog -->
        <div class="blog-content">
            <h4 class="text-muted mb-4">Contenido del Blog</h4>
            <p>{!! $blog->detalle !!}</p> <!-- Esto permite mostrar HTML si está almacenado en el contenido -->
        </div>
    </div>
</div>
<!-- Blog End -->

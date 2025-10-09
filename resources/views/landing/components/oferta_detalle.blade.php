<!-- Blog Start -->
<div class="container-fluid blog py-5">
    <div class="container py-5">

        <!-- Título del blog -->
        <h1 class="mb-4 text-center text-uppercase">{{ $blog->titulo }}</h1>

        <!-- Subtítulo del blog -->
        <!-- Imagen principal del blog ajustada -->
        <div class="mb-4 text-center">
            <img src="{{ asset($blog->imagen) }}" alt="Imagen del Blog" class="img-fluid rounded" style="max-height: 400px; width: auto; object-fit: cover;">
        </div>

        <!-- Información importante: Salario y Fecha de Vencimiento -->
        <div class="row mb-5">
            <div class="col-md-6 text-center mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="text-primary">Salario</h4>
                        <p class="h2 text-dark">{{ $blog->autor }} USD</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="text-danger">Fecha de Vencimiento</h4>
                        <p class="h2 text-dark">{{ \Carbon\Carbon::parse($blog->fecha)->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del autor y fecha -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="text-muted">
                <strong>Fecha Publicada: </strong>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}
            </span>
        </div>

        <!-- Resumen del blog -->
        <div class="mb-4">
            <h4 class="text-muted">Descripción Breve</h4>
            <p>{{ $blog->subtitulo }}</p>
        </div>

        <!-- Contenido largo del blog -->
        <div class="blog-content mb-5">
            <h4 class="text-muted mb-4">Detalles Completos de la Oferta</h4>
            <p>{!! $blog->detalle !!}</p> <!-- Esto permite mostrar HTML si está almacenado en el contenido -->
        </div>

        <!-- Botón para aplicar o más información -->
        <div class="text-center">
            <a href="{{ url('/aplicarOferta/'.$blog->id) }}" class="btn btn-success btn-lg rounded-pill px-5 py-3">Aplicar a esta Oferta</a>
        </div>

    </div>
</div>
<!-- Blog End -->

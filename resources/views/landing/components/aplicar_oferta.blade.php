<x-app-layout>
    <!-- Formulario de Aplicación -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="mx-auto text-center mb-5" style="max-width: 600px;">
                <h1 class="mb-4 text-uppercase">Aplicar a la oferta: {{ $blog->titulo }}</h1>
            </div>

            <!-- Mostrar mensajes de éxito -->
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <form action="{{ route('enviar.oferta', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Nombres -->
                <div class="form-group mb-4">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Tus nombres" required>
                </div>

                <!-- Apellidos -->
                <div class="form-group mb-4">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                </div>

                <!-- Teléfono -->
                <div class="form-group mb-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Tu teléfono" required>
                </div>

                <!-- Correo -->
                <div class="form-group mb-4">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Tu correo" required>
                </div>

                <!-- Hoja de Vida (Archivo) -->
                <div class="form-group mb-4">
                    <label for="hoja_vida" class="form-label">Hoja de Vida (Archivo)</label>
                    <input type="file" class="form-control" id="hoja_vida" name="hoja_vida" accept=".pdf,.doc,.docx" required>
                    <small class="text-muted">Solo se permiten archivos PDF, DOC, DOCX. Tamaño máximo: 2MB</small>
                </div>

                <!-- Botón de envío -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-2">Enviar Aplicación</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>



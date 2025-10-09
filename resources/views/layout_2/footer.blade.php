<!-- Footer Start -->
<div class="container-fluid footer py-5 p-5">
    <div class="row g-4"> <!-- Ajuste aquí: elimina el container interno -->
        <div class="col-md-6 col-lg-4">
            <div class="footer-item d-flex flex-column">
                <h4 class="mb-4 text-white">{{ $footer->titulo_1 }}</h4>
                <a href=""><i class="fas fa-home me-2"></i> {{ $footer->direccion }}</a>
                <a href=""><i class="fas fa-envelope me-2"></i> {{ $footer->email }}</a>
                <a href=""><i class="fas fa-phone me-2"></i> {{ $footer->telefono }}</a>
                <a href="" class="mb-3"><i class="fas fa-print me-2"></i> {{ $footer->fax }}</a>
                <div class="d-flex align-items-center">
                    @foreach($topBar as $top)
                        <a class="btn-square btn btn-primary rounded-circle mx-1" href="{{ $top->url }}"><i class="fab {{ $top->icon }}"></i></a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="footer-item d-flex flex-column">
                <h4 class="mb-4 text-white">{{ $footer->titulo_2 }}</h4>
                @foreach($navBars as $nav)
                    <a href="{{ Route::has($nav->ruta) ? route($nav->ruta) : $nav->ruta }}"><i class="fas fa-angle-right me-2"></i> {{ $nav->nombre_menu }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="footer-item">
                <h4 class="text-white mb-3">Aceptamos todos estos métodos de Pago</h4>
                <div class="footer-bank-card">
                    <a href="#" class="text-white me-2"><i class="fab fa-cc-amex fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-cc-visa fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fas fa-credit-card fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-cc-mastercard fa-2x"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-cc-paypal fa-2x"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-cc-discover fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

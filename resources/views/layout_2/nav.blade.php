
    <!-- Navbar & Hero Start -->
    <nav class="navbar navbar-expand-lg
        {{ !Request::is('/') && !Request::is('home') ? 'navbar-light px-4 px-lg-5 py-3 py-lg-0 sticky-top shadow-sm' : 'navbar-light px-4 px-lg-5 py-3 py-lg-0' }}">
        <a href="" class="navbar-brand p-0 d-flex align-items-center">
            <img src="{{ asset('files/img/LOGOfondo-oscuro.webp') }}" width="100%" 
     height="100%" class="me-6" alt="Image">
        
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                @foreach($navBars as $nav)
                    <a style="font-size: 0.85rem"
                    href="{{ Route::has($nav->ruta) ? route($nav->ruta) : $nav->ruta}}"
                       class="nav-item nav-link {{ ($nav->ruta == 'inicio') ? 'active' : '' }}">
                        {{ $nav->nombre_menu }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>


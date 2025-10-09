<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row align-items-center">
            <li class="nav-item me-auto">
                <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="brand-logo">
                    <img src="{{ asset('files/img/logo2.png') }}" alt="">
                </span>
                    <p class="logo_nav">Montalvo Mining</p>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header"><span data-i18n="Apps &amp; Pages">Landing Page</span><i data-feather="more-horizontal"></i></li>
            <li class="nav-item active"><a class="d-flex align-items-center" href="{{ route('dashboard')}}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a></li>
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Secciones Landing Page</span></a>
                <ul class="menu-content">
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('secciontop') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="secciontop">Nav Top</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionnav') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Menu">Menú</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('secciongeneral') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="General">General</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionnosotros') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Sobre Nosotros">Sobre Nosotros</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionservicios') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Servicios">Servicios</span></a></li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Información de la Sección">Sección Galeria</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="{{ route('seccionGaleriaCategoria') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Galeria">Categorias</span></a></li>
                            <li><a class="d-flex align-items-center" href="{{ route('seccionGaleria') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Galeria">Galeria</span></a></li>

                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Información de la Sección">Sección Cursos / Capacitaciones</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="{{ route('categoriasCursos') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Categorias">Categorias</span></a></li>
                            <li><a class="d-flex align-items-center" href="{{ route('seccionCapacitaciones') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Cursos Capacitaciones">Cursos Capacitaciones</span></a></li>

                        </ul>
                    </li>
                  <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionContactos') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Contactos">Contactos</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionEquipoTrabajo') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Equipo Trabajos">Equipo Trabajos</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionBlogs') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Blogs">Blogs</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionTestimonios') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Nuestros Clientes">Testimonios</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionSuscripciones') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Suscripciones">Suscripciones</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionClientes') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Clientes">Clientes</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionFooter') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Footer">Footer</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionOfertas') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Footer">Ofertas de Trabajo</span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('seccionAplicacionOfertas') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Footer">Aplicaciones a Ofertas </span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('boton-pagos.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="boton Pago">Botones de Pago </span></a></li>
                    <li class="nav-item"><a class="d-flex align-items-center" href="{{ route('pagos.index') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="boton Pago">Lista de Pagos Realizados </span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

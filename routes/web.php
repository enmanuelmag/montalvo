<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BotonPagoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingAboutController;
use App\Http\Controllers\LandingCapacitacionesController;
use App\Http\Controllers\LandingGaleriaController;
use App\Http\Controllers\LandingGeneralController;
use App\Http\Controllers\LandingNavController;
use App\Http\Controllers\LandingServicesController;
use App\Http\Controllers\LandingTopBarController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PagoPublicoController;
use App\Http\Controllers\PayPhoneController;
use App\Http\Controllers\ProfileController;
use App\Models\LandingNav;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ShareMenus;
use App\Http\Controllers\MoodleController;

    


Route::get('/moodle/cursos', [MoodleController::class, 'listarCursos']);
Route::post('/moodle/crear-y-matricular', [MoodleController::class, 'crearYMatricular']);

Route::middleware([ShareMenus::class])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/developer', [HomeController::class, 'developer']);
     Route::get('/defecto', [\App\Http\Controllers\LandingClientesController::class, 'crear'])->name('defecto');

    Route::get('/servicesLanding', [\App\Http\Controllers\LandingServicesController::class, 'servicesLanding'])->name('servicesLanding');
    Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('/galeria', [HomeController::class, 'galeria'])->name('galeria');
    Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
    Route::get('/capacitaciones', [HomeController::class, 'capacitaciones'])->name('capacitaciones');
    Route::get('/contactos', [HomeController::class, 'contactanos'])->name('contactos');
    Route::get('/LoginAcademico', [HomeController::class, 'index'])->name('LoginAcademico');

Route::get('/ofertasLaborales', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'ofertasLaborales'])->name('ofertasLaborales');

    Route::get('/aplicarOferta/{id}', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'mostrarFormulario'])->name('aplicar.oferta');
    Route::post('/aplicarOferta/{id}', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'enviarFormulario'])->name('enviar.oferta');



    Route::get('/verBlog/{id}', [\App\Http\Controllers\LandingBlogsController::class, 'verBlog'])->name('verBlog');
    Route::get('/verOferta/{id}', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'verOferta'])->name('verOferta');
    
       
        
    Route::get('/navigation', [MenuController::class, 'index']);
Route::get('/pagos/iniciar/{cursoId}', [PagoPublicoController::class, 'iniciarPago'])
        ->name('pagos.publico.iniciar');
    Route::post('/pagos/procesar', [PagoPublicoController::class, 'procesarPago'])
        ->name('pagos.publico.procesar');
    Route::get('/pagos/estado/{pago}', [PagoPublicoController::class, 'estadoPago'])
        ->name('publico.estado');
    Route::post('/pagos/confirmar-transferencia/{pago}', [PagoPublicoController::class, 'confirmarTransferencia'])
        ->name('pagos.publico.confirmar-transferencia');
    Route::get('/pagos/payphone/checkout/{pago}', [PayPhoneController::class, 'iniciarPago'])
        ->name('payphone.checkout');
    Route::post('/pagos/payphone/webhook', [PayPhoneController::class, 'confirmarPago'])
        ->name('payphone.webhook')
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/pagos/error/{pago}', [PagoPublicoController::class, 'mostrarError'])
        ->name('pagos.publico.error');
    Route::get('/pagos/verificar-estado/{pago}', [PagoPublicoController::class, 'verificarEstado'])
        ->name('pagos.publico.verificar-estado');
    Route::post('/admin/pagos/{id}/anular', [PagoController::class, 'anularPago'])->name('admin.pagos.anular');
    Route::get('/pagos/paypal/capture/{pago}', [PagoPublicoController::class, 'capturePaypalPayment'])
        ->name('pagos.paypal.capture');

    Route::get('/pagos/estado/{pago}', [PagoPublicoController::class, 'estadoPago'])
        ->name('pagos.publico.estado');

    Route::post('/pagos/generar-link/{pago}', [PagoPublicoController::class, 'generarLinkPago'])
        ->name('pagos.generar-link');

 

    Route::middleware('auth')->group(function () {
                Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        /*
         * seccion de los menu del administrador
         * */
        Route::get('seccionnav', [LandingNavController::class, 'index'])->name('seccionnav');
        Route::get('secciontop', [LandingTopBarController::class, 'index'])->name('secciontop');
        Route::get('secciongeneral', [LandingGeneralController::class, 'index'])->name('secciongeneral');
        Route::get('seccionnosotros', [LandingAboutController::class, 'index'])->name('seccionnosotros');
        Route::get('seccionservicios', [LandingServicesController::class, 'index'])->name('seccionservicios');

        // fin de la seccion de menu del administrador

         Route::post('/top_bar.update', [TopBarController::class, 'update'])->name('top_bar.update');
        Route::post('/datatableSocialMedia', [LandingTopBarController::class, 'getRedesSociales'])->name('datatableSocialMedia');
        Route::post('saveSocialMedia', [LandingTopBarController::class, 'store'])->name('saveSocialMedia');
        Route::get('/redes-sociales/{id}/edit', [LandingTopBarController::class, 'edit'])->name('redes-sociales.edit');
        Route::post('redes-sociales.update', [LandingTopBarController::class, 'update'])->name('redes-sociales.update');
        Route::delete('redes-sociales.destroy/{id}', [LandingTopBarController::class, 'delete'])->name('redes-sociales.destroy');
        // SECCION NAV MENU

        Route::post('/datatableNav', [LandingNavController::class, 'getNavDatatable'])->name('datatableNav');
        Route::post('nav.save', [LandingNavController::class, 'store'])->name('nav.save');
        Route::get('/nav/{id}/edit', [LandingNavController::class, 'edit'])->name('nav.edit');
        Route::post('nav.update', [LandingNavController::class, 'update'])->name('nav.update');
                Route::post('nav.ordenamiento', [LandingNavController::class, 'ordenamiento'])->name('nav.ordenamiento');

        Route::delete('nav.destroy/{id}', [LandingNavController::class, 'delete'])->name('nav.destroy');
        // SECCION GENERAL

        Route::post('/datatableGeneral', [LandingGeneralController::class, 'getGeneralDatatable'])->name('datatableGeneral');
        Route::post('general.save', [LandingGeneralController::class, 'store'])->name('general.save');
        Route::get('/general/{id}/edit', [LandingGeneralController::class, 'edit'])->name('general.edit');
        Route::post('general.update', [LandingGeneralController::class, 'update'])->name('general.update');
        Route::delete('general.destroy/{id}', [LandingGeneralController::class, 'delete'])->name('general.destroy');
        // SECCION NOSOTROS

        Route::post('/datatableNosotros', [LandingAboutController::class, 'getNosotrosDatatable'])->name('datatableNosotros');
        Route::post('nosotros.save', [LandingAboutController::class, 'update'])->name('nosotros.save');
        Route::post('nosotros_item.save', [LandingAboutController::class, 'storeItem'])->name('nosotros_item.save');
        Route::post('nosotros_item.update', [LandingAboutController::class, 'updateItem'])->name('nosotros_item.update');
        Route::get('/nosotros/{id}/edit', [LandingAboutController::class, 'editItem'])->name('nosotros.edit');
        Route::post('nosotros.update', [LandingAboutController::class, 'update'])->name('nosotros.update');
        Route::delete('nosotros.destroy/{id}', [LandingAboutController::class, 'deleteItem'])->name('nosotros.destroy');


        // SECCION SERVICIOS
        Route::post('/datatableServices', [LandingServicesController::class, 'getServicesDatatable'])->name('datatableServices');
        Route::post('services.save', [LandingServicesController::class, 'update'])->name('services.save');
        Route::post('services_item.save', [LandingServicesController::class, 'storeItem'])->name('services_item.save');
        Route::post('services_item.update', [LandingServicesController::class, 'updateItem'])->name('services_item.update');
        Route::get('/services/{id}/edit', [LandingServicesController::class, 'editItem'])->name('services.edit');
        Route::post('services.update', [LandingServicesController::class, 'update'])->name('services.update');
        Route::delete('services.destroy/{id}', [LandingServicesController::class, 'deleteItem'])->name('services.destroy');

        // SECCION GALERIA
        Route::get('seccionGaleriaCategoria', [LandingGaleriaController::class, 'indexCategorias'])->name('seccionGaleriaCategoria');
        Route::get('seccionGaleria', [LandingGaleriaController::class, 'indexGaleria'])->name('seccionGaleria');
        Route::post('/datatableCategoriaGaleria', [LandingGaleriaController::class, 'datatableCategoia'])->name('datatableCategoriaGaleria');
        Route::post('save.categoria', [LandingGaleriaController::class, 'saveCategoria'])->name('save.categoria');
        Route::get('/categoria/{id}/edit', [LandingGaleriaController::class, 'editCategoria'])->name('categoria.edit');
        Route::post('update.categoria', [LandingGaleriaController::class, 'updateCategoria'])->name('update.categoria');
        Route::delete('destroy.categoria/{id}', [LandingGaleriaController::class, 'destroyCategoria'])->name('destroy.categoria');

        Route::post('/datatableGaleria', [LandingGaleriaController::class, 'datatableGaleria'])->name('datatableGaleria');
        Route::post('update.galeria', [LandingGaleriaController::class, 'updateGaleria'])->name('update.galeria');

        Route::post('save.item.galeria', [LandingGaleriaController::class, 'storeGaleriaItem'])->name('save.item.galeria');
        Route::get('/galeria/{id}/edit', [LandingGaleriaController::class, 'editGaleriaItem'])->name('galeria.edit');
        Route::post('update.item.galeria', [LandingGaleriaController::class, 'updateGaleriaItem'])->name('update.item.galeria');
        Route::delete('destroy.galeria/{id}', [LandingGaleriaController::class, 'destroyItemGaleria'])->name('destroy.galeria');

     // SECCION CAPACITACIONES
        Route::get('seccionCapacitaciones', [LandingCapacitacionesController::class, 'index'])->name('seccionCapacitaciones');

        Route::post('update.seccioncapacitacion', [LandingCapacitacionesController::class, 'updateSeccionCapacitacion'])->name('update.seccioncapacitacion');
        Route::get('/capacitaciones/{id}/edit', [LandingCapacitacionesController::class, 'editCapacitacion'])->name('capacitaciones.edit');
        Route::post('datatableCapacitaciones', [LandingCapacitacionesController::class, 'getCursosDatatable'])->name('datatableCapacitaciones');
        Route::post('capacitaciones.update', [LandingCapacitacionesController::class, 'update'])->name('capacitaciones.update');

        Route::get('nuevaCapacitacion', [LandingCapacitacionesController::class, 'crearCapacitacion'])->name('nuevaCapacitacion');
        Route::post('capacitaciones_item.save', [LandingCapacitacionesController::class, 'storeCapacitacion'])->name('capacitaciones_item.save');
        Route::post('capacitaciones_item.update', [LandingCapacitacionesController::class, 'updateCapacitacion'])->name('capacitaciones_item.update');
        Route::get('/capacitaciones/{id}/edit', [LandingCapacitacionesController::class, 'editCapacitacion'])->name('capacitaciones.edit');
        Route::post('capacitaciones.update', [LandingCapacitacionesController::class, 'update'])->name('capacitaciones.update');
        Route::delete('capacitaciones.destroy/{id}', [LandingCapacitacionesController::class, 'deleteItem'])->name('capacitaciones.destroy');


        // SECCION CATEGORIAS DE CURSOS
        Route::get('seccionCategorias', [LandingCapacitacionesController::class, 'indexCategorias'])->name('categoriasCursos');
        Route::post('datatableCategorias', [LandingCapacitacionesController::class, 'getCapacitacionesDatatable'])->name('datatableCategorias');
        Route::post('categorias.save', [LandingCapacitacionesController::class, 'storeCategoria'])->name('categorias.save');
        Route::get('/categoriaCurso/{id}/edit', [LandingCapacitacionesController::class, 'editCategoria'])->name('categoriaCurso.edit');
        Route::post('update.categoriaCurso', [LandingCapacitacionesController::class, 'updateCategoria'])->name('update.categoriaCurso');
        Route::delete('destroy.categoriaCurso/{id}', [LandingCapacitacionesController::class, 'destroyCategoria'])->name('destroy.categoriaCurso');

     //SECCION CAPACITACIONES
        Route::get('seccionContactos', [\App\Http\Controllers\LandingContactosController::class, 'index'])->name('seccionContactos');
        Route::post('contactos.update', [\App\Http\Controllers\LandingContactosController::class, 'update'])->name('contactos.update');

//  SECCION EQUIPO DE TRABAJO
        Route::get('seccionEquipoTrabajo', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'index'])->name('seccionEquipoTrabajo');
        Route::post('equipo.update', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'update'])->name('equipo.update');
        Route::post('equipoTrabajo_item.save', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'store'])->name('equipoTrabajo_item.save');
        Route::post('datatableEquipoTrabajo', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'getDatatable'])->name('datatableEquipoTrabajo');
        Route::get('/equipoTrabajo/{id}/edit', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'edit'])->name('equipoTrabajo.edit');
        Route::post('equipoTrabajo.update', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'updateEquipo'])->name('equipoTrabajo.update');
        Route::delete('equipoTrabajo.destroy/{id}', [\App\Http\Controllers\LandingEquipoTrabajoController::class, 'delete'])->name('equipoTrabajo.destroy');


        // SECCION TESTIMONIOS
        Route::get('seccionTestimonios', [\App\Http\Controllers\LandingTestimoniosController::class, 'index'])->name('seccionTestimonios');
        Route::post('testimonioSeccion.update', [\App\Http\Controllers\LandingTestimoniosController::class, 'update'])->name('testimonioSeccion.update');
        Route::post('testimonios_item.save', [\App\Http\Controllers\LandingTestimoniosController::class, 'store'])->name('testimonios_item.save');
        Route::post('datatableTestimonios', [\App\Http\Controllers\LandingTestimoniosController::class, 'getDatatable'])->name('datatableTestimonios');
        Route::get('/testimonios/{id}/edit', [\App\Http\Controllers\LandingTestimoniosController::class, 'edit'])->name('testimonios.edit');
        Route::post('testimonios.update', [\App\Http\Controllers\LandingTestimoniosController::class, 'updateTestimonio'])->name('testimonios.update');
        Route::delete('testimonios.destroy/{id}', [\App\Http\Controllers\LandingTestimoniosController::class, 'delete'])->name('testimonios.destroy');

  // SECCION SUSCRIPCIONES
        Route::get('seccionSuscripciones', [\App\Http\Controllers\LandingSuscripcionesController::class, 'index'])->name('seccionSuscripciones');
        Route::post('suscripcionSeccion.update', [\App\Http\Controllers\LandingSuscripcionesController::class, 'update'])->name('suscripcionSeccion.update');

        // SECCION CLIENTES
        Route::get('seccionClientes', [\App\Http\Controllers\LandingClientesController::class, 'index'])->name('seccionClientes');
        Route::post('clientesSeccion.update', [\App\Http\Controllers\LandingClientesController::class, 'update'])->name('clientesSeccion.update');
        Route::post('datatableClientes', [\App\Http\Controllers\LandingClientesController::class, 'datatableClientes'])->name('datatableClientes');
        Route::post('clientes_item.save', [\App\Http\Controllers\LandingClientesController::class, 'store'])->name('clientes_item.save');
        Route::get('/clientes/{id}/edit', [\App\Http\Controllers\LandingClientesController::class, 'edit'])->name('clientes.edit');
        Route::post('clientes.update', [\App\Http\Controllers\LandingClientesController::class, 'updateCliente'])->name('clientes.update');
        Route::delete('clientes.destroy/{id}', [\App\Http\Controllers\LandingClientesController::class, 'delete'])->name('clientes.destroy');



       
        // SECCION FOOTER
        Route::get('seccionFooter', [\App\Http\Controllers\LandingFooterController::class, 'index'])->name('seccionFooter');
        Route::post('footerSeccion.update', [\App\Http\Controllers\LandingFooterController::class, 'update'])->name('footerSeccion.update');

        // SECCION BLOGS
        Route::get('seccionBlogs', [\App\Http\Controllers\LandingBlogsController::class, 'index'])->name('seccionBlogs');
        Route::post('blogsSeccion.update', [\App\Http\Controllers\LandingBlogsController::class, 'update'])->name('blogsSeccion.update');
        Route::get('nuevoBlog', [\App\Http\Controllers\LandingBlogsController::class, 'crearBlog'])->name('nuevoBlog');
        Route::post('datatableBlogs', [\App\Http\Controllers\LandingBlogsController::class, 'datatableBlogs'])->name('datatableBlogs');
        Route::post('blogs_item.save', [\App\Http\Controllers\LandingBlogsController::class, 'store'])->name('blogs_item.save');
        Route::get('/blogs/{id}/edit', [\App\Http\Controllers\LandingBlogsController::class, 'edit'])->name('blogs.edit');
        Route::post('blogs.update', [\App\Http\Controllers\LandingBlogsController::class, 'updateBlog'])->name('blogs.update');
        Route::delete('blogs.destroy/{id}', [\App\Http\Controllers\LandingBlogsController::class, 'delete'])->name('blogs.destroy');


        // SECCION ofertas laborales
        Route::get('seccionOfertas', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'index'])->name('seccionOfertas');
        Route::get('nueva_oferta', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'create'])->name('nueva_oferta');
        Route::post('datatable_ofertas', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'datatableOfertas'])->name('datatable_ofertas');
        Route::get('/oferta/{id}/edit', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'edit'])->name('oferta.edit');
        Route::post('oferta.update', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'update'])->name('oferta.update');
        Route::post('oferta.store', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'store'])->name('oferta.store');
        Route::delete('oferta.destroy/{id}', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'delete'])->name('oferta.destroy');

        Route::get('seccionAplicacionOfertas', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'indexAplicacionesOferta'])->name('seccionAplicacionOfertas');
        Route::post('datatable_aplicaciones_ofertas', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'datatableOfertasRecibidas'])->name('datatable_aplicaciones_ofertas');
        Route::get('descargar_hoja_vida/{id}', [\App\Http\Controllers\LandingOfertaLaboralController::class, 'descargar_hoja_vida'])->name('descargar_hoja_vida');

  // SECCION DE BOTON DE PAGOS
        Route::resource('boton-pagos', BotonPagoController::class);
        Route::post('boton-pagos/{botonPago}/toggle', [BotonPagoController::class, 'toggle'])->name('boton-pagos.toggle');
        Route::get('boton-pagos/{botonPago}/configuracion', [BotonPagoController::class, 'obtenerConfiguracion'])->name('boton-pagos.configuracion');

        Route::get('/admin/pagos', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/procesar-pago-moodle/{id}', [PagoController::class, 'procesarPagoMoodle']);
        Route::get('/admin/pagos/listar', [PagoController::class, 'listar'])->name('pagos.listar');
Route::get('/admin/pagos/{id}', [PagoController::class, 'show'])->name('pagos.show');
Route::get('/admin/pagosDetalles/{id}', [PagoController::class, 'show'])->name('pagos.show');

        Route::post('/admin/pagos/filtrar', [PagoController::class, 'filtrar'])->name('pagos.filtrar');
        
        Route::post('/admin/pagos/{pago}/estado', [PagoController::class, 'actualizarEstado'])->name('pagos.actualizar-estado');
        Route::get('/admin/pagos/exportar', [PagoController::class, 'exportar'])->name('pagos.exportar');



    });
    require __DIR__.'/auth.php';
});

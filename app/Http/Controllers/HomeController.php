<?php

namespace App\Http\Controllers;

use App\Models\HomeFront;
use App\Models\HomeSeccion2Front;
use App\Models\HomeSeccion3Front;
use App\Models\HomeSeccion4Front;
use App\Models\HomeSeccion5Front;
use App\Models\HomeSeccion6Front;
use App\Models\HomeSeccion8Front;
use App\Models\HomeSeccion9Front;
use App\Models\LandingAbout;
use App\Models\LandingAboutItem;
use App\Models\LandingBlogs;
use App\Models\LandingBlogsDetalles;
use App\Models\LandingCategoriasTrabajos;
use App\Models\LandingClientes;
use App\Models\LandingClientesItems;
use App\Models\LandingContactos;
use App\Models\LandingCursos;
use App\Models\LandingCursosDetalles;
use App\Models\LandingEquipoTrabajo;
use App\Models\LandingGaleriaTrabajos;
use App\Models\LandingGeneral;
use App\Models\LandingInformacionContactos;
use App\Models\LandingItemEquipoTrabajo;
use App\Models\LandingItemGaleriaTrabajos;
use App\Models\LandingServices;
use App\Models\LandingServicesItem;
use App\Models\LandingSuscribete;
use App\Models\LandingTestimonios;
use App\Models\LandingTestimoniosDetalles;
use App\Models\PagosEfectuados;
use App\Models\RedesSociales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /*
    public function index()
    {
        $general = LandingGeneral::all();
        $about = LandingAbout::where('id', 1)->first();
        $aboutItems = LandingAboutItem::where('estado', 1)->get();
        $services = LandingServices::where('id', 1)->first();
        $services_items = LandingServicesItem::where('estado', 1)->get();
        $galeria = LandingGaleriaTrabajos::find(1);
        $itemsGaleria = LandingItemGaleriaTrabajos::where('estado', 1)->get();
        $categoriasGaleria = LandingCategoriasTrabajos::where('estado', 1)->get();
        $capacitacion = LandingCursos::where('estado', 1)->first();
        $capacitaciones = LandingCursosDetalles::where('estado', 1)->get();
        $contacto = LandingContactos::where('estado', 1)->first();
        $informacionContacto = LandingInformacionContactos::where('estado', 1)->first();
        $seccionEquipo = LandingEquipoTrabajo::where('estado', 1)->first();
        $equipoTrabajo = LandingItemEquipoTrabajo::where('estado', 1)->get();
                $seccionTestimonios = LandingTestimonios::where('estado', 1)->first();
        $testimonios = LandingTestimoniosDetalles::where('estado', 1)->get();
                $suscripcion = LandingSuscribete::where('estado', 1)->first();
  $clientes = LandingClientesItems::where('estado', 1)->get();
        $seccionClientes = LandingClientes::where('estado', 1)->first();
        $blog = LandingBlogs::first();
        $blogs = LandingBlogsDetalles::where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();


        // L車gica para hacer la llamada a la base de datos
              return view('landing/home', compact('general', 'about',
            'aboutItems', 'services', 'services_items', 'galeria', 'categoriasGaleria','itemsGaleria',
            'capacitacion', 'capacitaciones','contacto', 'informacionContacto',
            'seccionEquipo', 'equipoTrabajo', 'seccionTestimonios', 'testimonios', 'suscripcion',
            'clientes', 'seccionClientes','blog', 'blogs'));
            
            return view('landing/home2');

    }
    */
    public function developer(){}
    /*
    public function index()
    {
         $general = LandingGeneral::all();
        $about = LandingAbout::where('id', 1)->first();
        $aboutItems = LandingAboutItem::where('estado', 1)->get();
        $services = LandingServices::where('id', 1)->first();
        $services_items = LandingServicesItem::where('estado', 1)->get();
        $galeria = LandingGaleriaTrabajos::find(1);
        $itemsGaleria = LandingItemGaleriaTrabajos::where('estado', 1)->get();
        $categoriasGaleria = LandingCategoriasTrabajos::where('estado', 1)->get();
        $capacitacion = LandingCursos::where('estado', 1)->first();
        $capacitaciones = LandingCursosDetalles::where('estado', 1)->get();
        $contacto = LandingContactos::where('estado', 1)->first();
        $informacionContacto = LandingInformacionContactos::where('estado', 1)->first();
        $seccionEquipo = LandingEquipoTrabajo::where('estado', 1)->first();
        $equipoTrabajo = LandingItemEquipoTrabajo::where('estado', 1)->get();
        $seccionTestimonios = LandingTestimonios::where('estado', 1)->first();
        $testimonios = LandingTestimoniosDetalles::where('estado', 1)->get();
                $suscripcion = LandingSuscribete::where('estado', 1)->first();
  $clientes = LandingClientesItems::where('estado', 1)->get();
        $seccionClientes = LandingClientes::where('estado', 1)->first();
$blog = LandingBlogs::first();
        $blogs = LandingBlogsDetalles::where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();


        // L車gica para hacer la llamada a la base de datos
        return view('landing/home', compact('general', 'about',
            'aboutItems', 'services', 'services_items', 'galeria', 'categoriasGaleria','itemsGaleria',
            'capacitacion', 'capacitaciones','contacto', 'informacionContacto',
            'seccionEquipo', 'equipoTrabajo','seccionTestimonios', 'testimonios', 'suscripcion',
            'clientes', 'seccionClientes', 'blog', 'blogs'));

    }
    */
    public function index()
{
    // Establecer tiempo de caché (3600 segundos = 1 hora)
    $cacheTime = 3600;
    
    // Cargar todos los datos de la página principal desde caché
    $general = Cache::remember('home_general', $cacheTime, function () {
        return LandingGeneral::all();
    });
    
    $about = Cache::remember('home_about', $cacheTime, function () {
        return LandingAbout::where('id', 1)->first();
    });
    
    $aboutItems = Cache::remember('home_about_items', $cacheTime, function () {
        return LandingAboutItem::where('estado', 1)->get();
    });
    
    $services = Cache::remember('home_services', $cacheTime, function () {
        return LandingServices::where('id', 1)->first();
    });
    
    $services_items = Cache::remember('home_services_items', $cacheTime, function () {
        return LandingServicesItem::where('estado', 1)->get();
    });
    
    $galeria = Cache::remember('home_galeria', $cacheTime, function () {
        return LandingGaleriaTrabajos::find(1);
    });
    
    $itemsGaleria = LandingItemGaleriaTrabajos::where('estado', 1)->get();
    
    $categoriasGaleria = LandingCategoriasTrabajos::where('estado', 1)->get();
    
    $capacitacion = Cache::remember('home_capacitacion', $cacheTime, function () {
        return LandingCursos::where('estado', 1)->first();
    });
    
    $capacitaciones = LandingCursosDetalles::where('estado', 1)->get();
    
    $contacto = Cache::remember('home_contacto', $cacheTime, function () {
        return LandingContactos::where('estado', 1)->first();
    });
    
    $informacionContacto = Cache::remember('home_informacion_contacto', $cacheTime, function () {
        return LandingInformacionContactos::where('estado', 1)->first();
    });
    
    $seccionEquipo = Cache::remember('home_seccion_equipo', $cacheTime, function () {
        return LandingEquipoTrabajo::where('estado', 1)->first();
    });
    
    $equipoTrabajo = LandingItemEquipoTrabajo::where('estado', 1)->get();
    
    
    $seccionTestimonios = LandingTestimonios::where('estado', 1)->first();
    
    $testimonios = LandingTestimoniosDetalles::where('estado', 1)->get();
    
    $suscripcion = Cache::remember('home_suscripcion', $cacheTime, function () {
        return LandingSuscribete::where('estado', 1)->first();
    });
    
    $clientes = LandingClientesItems::where('estado', 1)->get();
    
    $seccionClientes = Cache::remember('home_seccion_clientes', $cacheTime, function () {
        return LandingClientes::where('estado', 1)->first();
    });
    
    $blog = Cache::remember('home_blog', $cacheTime, function () {
        return LandingBlogs::first();
    });
    
    $blogs = LandingBlogsDetalles::where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
    
    // Retornar la vista con todos los datos
    return view('landing/home', compact(
        'general', 'about', 'aboutItems', 'services', 'services_items', 
        'galeria', 'categoriasGaleria', 'itemsGaleria', 'capacitacion', 
        'capacitaciones', 'contacto', 'informacionContacto', 'seccionEquipo', 
        'equipoTrabajo', 'seccionTestimonios', 'testimonios', 'suscripcion',
        'clientes', 'seccionClientes', 'blog', 'blogs'
    ));
}

/*
public function servicesLanding(){
     $services = LandingServices::all();
     dd($services);
    
    $services_items = LandingServicesItem::where('estado', 1)->get();
    
     return view('landing/partial/servicios', compact(
        'services', 'services_items'
    ));
}
*/
public function capacitaciones(){
     $capacitacion = LandingCursos::where('estado', 1)->first();
    
    
    $capacitaciones =  LandingCursosDetalles::where('estado', 1)->get();
    return view('landing/partial/capacitaciones', compact(
        'capacitacion', 
        'capacitaciones'
    ));
    
}
public function galeria(){
      $galeria =  LandingGaleriaTrabajos::find(1);
    $categoriasGaleria =  LandingCategoriasTrabajos::where('estado', 1)->get();
    
    $itemsGaleria = LandingItemGaleriaTrabajos::where('estado', 1)->get();

    return view('landing/partial/galeria', compact(
        'galeria',
        'itemsGaleria',
        'categoriasGaleria'
    ));
    
}

public function blogs(){
     $blog = LandingBlogs::first();
 
    
    $blogs =  LandingBlogsDetalles::where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
 
    return view('landing/partial/blogs', compact(
        'blog', 
        'blogs'
    ));
    
}
public function contactanos(){
     $contacto = LandingContactos::where('estado', 1)->first();
    
    
    $informacionContacto = LandingInformacionContactos::where('estado', 1)->first();
    
    return view('landing/partial/contactanos', compact(
        'contacto', 
        'informacionContacto'
    ));
    
}

public function nosotros(){
     $about = LandingAbout::where('id', 1)->first();

    
    $aboutItems = LandingAboutItem::where('estado', 1)->get();
    
    return view('landing/partial/nosotros', compact(
        'about', 
        'aboutItems'
    ));
    
}
    

    
     public function dashboard()
    {
        
        $stats = [
            // Estadísticas generales
            'total_ventas' => PagosEfectuados::where('estado', 'COMPLETADO')
                ->whereYear('fecha_pago', now()->year)
                ->sum('valor'),

            'incremento_ventas' => $this->calcularIncrementoVentas(),

            /*'total_estudiantes' => User::where('role', 'student')
                ->where('active', true)
                ->count(),


             */
            'total_estudiantes' => PagosEfectuados::where('estado', 'COMPLETADO')
                ->distinct('identificacion')
                ->count('identificacion'),
            'nuevos_estudiantes' => PagosEfectuados::where('estado', 'COMPLETADO')
                ->whereMonth('fecha_pago', now()->month)
                ->distinct('identificacion')
                ->count('identificacion'),

           /* 'nuevos_estudiantes' => User::where('role', 'student')
                ->whereMonth('created_at', now()->month)
                ->count(),
           */

            'cursos_activos' => LandingCursosDetalles::where('estado', 1)->count(),

            'completados_mes' => LandingCursosDetalles::where('estado', 1)
                ->whereMonth('updated_at', now()->month)
                ->count(),

            'pagos_pendientes' => PagosEfectuados::where('estado', 'PENDIENTE')->count(),

            'monto_pendiente' => PagosEfectuados::where('estado', 'PENDIENTE')
                ->sum('valor'),

            // Datos para el gráfico de ventas mensuales
            'ventas_mensuales' => $this->obtenerVentasMensuales(),

            // Datos para el gráfico de estudiantes por curso
            'estudiantes_por_curso' => $this->obtenerEstudiantesPorCurso(),

            // Actividad reciente
            'actividad_reciente' => $this->obtenerActividadReciente(),
        ];
 
        return view('dashboard', compact('stats'));
    }

    private function calcularIncrementoVentas()
    {
        $mesActual = PagosEfectuados::where('estado', 'COMPLETADO')
            ->whereMonth('fecha_pago', now()->month)
            ->sum('valor');

        $mesAnterior = PagosEfectuados::where('estado', 'COMPLETADO')
            ->whereMonth('fecha_pago', now()->subMonth()->month)
            ->sum('valor');

        if ($mesAnterior == 0) return 100;

        return round((($mesActual - $mesAnterior) / $mesAnterior) * 100, 2);
    }

   private function obtenerVentasMensuales()
{
    $ventas = PagosEfectuados::selectRaw('EXTRACT(MONTH FROM fecha_pago) as mes, SUM(valor) as total')
        ->where('estado', 'COMPLETADO')
        ->whereYear('fecha_pago', now()->year)
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->keyBy('mes'); // 🔑 Acceso más directo por número de mes

    $meses = [];
    $valores = [];

    for ($i = 1; $i <= 12; $i++) {
        $meses[] = Carbon::create()->month($i)->format('M'); // Ej: Jan, Feb...
        $valores[] = isset($ventas[$i]) ? round($ventas[$i]->total, 2) : 0;
    }

    return [
        'meses' => $meses,
        'valores' => $valores
    ];
}

private function obtenerEstudiantesPorCurso()
{
    $datos = DB::table('pagos_efectuados as pagos')
        ->join('landing_cursos_detalles as cursos', 'pagos.curso_id', '=', 'cursos.id')
        ->select('cursos.titulo', DB::raw('count(*) as total'))
        ->where('pagos.estado', 'COMPLETADO')
        ->groupBy('cursos.titulo')
        ->get();

    // Estructura en el formato requerido
    $cursos = [];
    $valores = [];

    foreach ($datos as $dato) {
        $cursos[] = $dato->titulo;
        $valores[] = $dato->total;
    }

    return [
        'cursos' => $cursos,
        'valores' => $valores
    ];
}

   private function obtenerActividadReciente()
{
    return PagosEfectuados::orderByDesc('fecha_pago')
        ->limit(5)
        ->get()
        ->map(function ($pago) {
            return [
                'titulo' => 'Nuevo pago recibido',
                'descripcion' => "Pago de $" . number_format($pago->valor, 2) . " por " . $pago->cliente,
                'tiempo' => Carbon::parse($pago->fecha_pago)->diffForHumans(),
                'color' => '#10B981',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            ];
        });
}
}

<?php

namespace App\Http\Controllers;

use App\Models\LandingCursos;
use App\Models\LandingCursosCategorias;
use App\Models\LandingCursosDetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;


class LandingCapacitacionesController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Sobre Cursos';
        $tableTitle = 'Lista de Items';
        $landingCapacitaciones = LandingCursos::where('estado', 1)->first();
        return view('backend.capacitaciones.capacitaciones', compact('Title', 'tableTitle', 'landingCapacitaciones'));
    }

    public function updateSeccionCapacitacion(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];
        $seccionCursos = LandingCursos::find($id);
        $seccionCursos->titulo = $request->input('titulo');
        $seccionCursos->subtitulo = $request->input('descripcion1');
        $seccionCursos->save();
        return response()->json(['success' => true, 'msg' => 'Actualizado Con Exito']);
    }


    public function crearCapacitacion()
    {
        $Title = 'Agregar Publicidad sobre Curso';
        $categorias = LandingCursosCategorias::where('estado', 1)->get();
    
                $moodle = new MoodleController();
        $response = $moodle->listarCursos(); // Este devuelve un JsonResponse
    
        // Accede al contenido real (decode JSON)
        $cursosMoodle = $response->getData(true); // convierte JsonResponse a array
        $cursosSimplificados = [];
            foreach ($cursosMoodle as $curso) {
                if (isset($curso['id'], $curso['fullname']) && $curso['id'] != 1) {
                    $cursosSimplificados[] = [
                        'id' => $curso['id'],
                        'fullname' => html_entity_decode($curso['fullname'])
                    ];
                }
            }
                    
                
        return view('backend.capacitaciones.capacitacion_item', compact('Title', 'categorias', 'cursosSimplificados'));
    }
    
    public function storeCapacitacion(Request $request)
    {
        try {
            // Valores por defecto para la imagen y el video
            $defaultImage = 'default.png';
            $defaultVideo = 'default_video.mp4';

// Inicializar variables para almacenar los nombres de archivo
            $imageName = $defaultImage;
            $videoName = $defaultVideo;

// Obtener todos los archivos subidos
            $files = $request->file('files');

            if ($files && is_array($files)) {
                foreach ($files as $file) {
                    // Obtener MIME type para verificar si es imagen o video
                    $mimeType = $file->getMimeType();
                    $extension = $file->getClientOriginalExtension();

                    // Generar un timestamp único dentro del bucle para cada archivo
                    $currentTimestamp = now()->format('YmdHisv');  // Añadir milisegundos para mayor precisión

                    // Obtener el título sin espacios (reemplazar espacios con guiones bajos)
                    $titulo = str_replace(' ', '_', $request->input('titulo'));

                    // Si es una imagen
                    if (strstr($mimeType, 'image')) {
                        // Generar nombre único para la imagen
                        $imageName = 'image_' . $titulo . '_' . $currentTimestamp . '.' . $extension;
                        $directory = public_path('files/cursos');

                        // Verifica si el directorio existe, si no, créalo
                        if (!file_exists($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        // Ruta completa para la imagen
                        $imagePath = $directory . '/' . $imageName;

                        // Crea la imagen desde el archivo y guarda en el path especificado
                        $imgResource = imagecreatefromstring(file_get_contents($file->getRealPath()));
                        if ($imgResource) {
                            imagejpeg($imgResource, $imagePath, 90);  // Ajusta la calidad de la imagen según sea necesario
                            imagedestroy($imgResource);  // Liberar recursos
                        } else {
                            throw new \Exception('Error al crear la imagen desde el archivo.');
                        }

                    }
                    // Si es un video
                    elseif (strstr($mimeType, 'video')) {
                        // Generar nombre único para el video
                        $videoName = 'video_' . $titulo . '_' . $currentTimestamp . '.' . $extension;
                        $directory = public_path('files/cursos');

                        // Verifica si el directorio existe, si no, créalo
                        if (!file_exists($directory)) {
                            mkdir($directory, 0755, true);
                        }

                        // Ruta completa para el video
                        $videoPath = $directory . '/' . $videoName;

                        // Mover el video subido al directorio de destino
                        if (!$file->move($directory, $videoName)) {
                            throw new \Exception('Error al mover el archivo de video.');
                        }
                    }
                }
            }


            // Procesar los demás campos y guardar en la base de datos
            $capacitacion = new LandingCursosDetalles();
            $capacitacion->titulo = $request->input('titulo');
            $capacitacion->subtitulo = $request->input('subtitulo');
            $capacitacion->categoria_id = $request->input('categoria_id');
            $capacitacion->detalle = $request->input('resumen');
            $capacitacion->calificacion = $request->input('calificacion');
            $capacitacion->resumen = $request->input('detalle_completo');
            $capacitacion->precio = $request->input('precio');
            $capacitacion->fecha_inicio = $request->input('fecha');
            $capacitacion->fecha_fin = $request->input('fecha');
            $capacitacion->duracion = $request->input('cantidad_duracion');
            $capacitacion->unidad_duracion = $request->input('unidad_duracion');
            $capacitacion->metodologia = $request->input('modalidad');
            $capacitacion->lugar = $request->input('moodle_id');
            $capacitacion->certificacion = $request->input('link_moodle');
            
            $capacitacion->horario = $request->input('modalidad');

            // Guardar solo los nombres de los archivos
            $capacitacion->imagen = $imageName;
            $capacitacion->video = $videoName;

            // Guardar en la base de datos
            $capacitacion->save();

            return response()->json(['success' => true, 'message' => 'Capacitación guardada correctamente'], 200);

        } catch (\Exception $e) {
            // Manejar excepciones y registrar el error
            Log::error('Error al guardar la capacitación: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Ocurrió un error al guardar la capacitación'.$e->getMessage()], 500);
        }

    }


    public function updateCapacitacion(Request $request)
    {
        // Buscar la capacitación por ID
        $capacitacion = LandingCursosDetalles::findOrFail($request->id);

        // Actualizar los campos solo si existen en la solicitud
        $capacitacion->resumen = $request->input('detalle_completo') ?? $capacitacion->detalle_completo;
        $capacitacion->calificacion = $request->input('calificacion') ?? $capacitacion->calificacion;
        $capacitacion->titulo = $request->input('titulo') ?? $capacitacion->titulo;
        $capacitacion->subtitulo = $request->input('subtitulo') ?? $capacitacion->subtitulo;
        $capacitacion->detalle = $request->input('resumen') ?? $capacitacion->resumen;
        $capacitacion->precio = $request->input('precio') ?? $capacitacion->precio;
        $capacitacion->categoria_id = $request->input('categoria_id') ?? $capacitacion->categoria_id;
        $capacitacion->fecha_inicio = $request->input('fecha') ?? $capacitacion->fecha;
        $capacitacion->fecha_fin = $request->input('fecha') ?? $capacitacion->fecha;
        $capacitacion->duracion = $request->input('cantidad_duracion') ?? $capacitacion->cantidad_duracion;
        $capacitacion->unidad_duracion = $request->input('unidad_duracion') ?? $capacitacion->unidad_duracion;
        $capacitacion->metodologia = $request->input('modalidad') ?? $capacitacion->modalidad;
        $capacitacion->certificacion = $request->input('link_moodle') ?? $capacitacion->certificacion;
        $capacitacion->lugar = $request->input('moodle_id');

        $capacitacion->horario = $request->input('modalidad') ?? $capacitacion->modalidad;


        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (is_array($files)) {
                foreach ($files as $file) {
                    // Obtener MIME type para verificar si es imagen o video
                    $mimeType = $file->getMimeType();
                    $extension = $file->getClientOriginalExtension();

                    // Generar un timestamp único
                    $currentTimestamp = now()->format('YmdHisv');  // Incluye milisegundos

                    // Obtener el título y reemplazar espacios con guiones bajos
                    $titulo = str_replace(' ', '_', $request->input('titulo'));

                    // Ruta donde se almacenarán los archivos
                    $directory = public_path('files/cursos');

                    // Verificar si el directorio existe, si no, crearlo
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    // Eliminar el archivo anterior si existe
                    if ($capacitacion->file_path) {
                        Storage::delete($capacitacion->file_path);
                    }

                    // Si es una imagen
                    if (strstr($mimeType, 'image')) {
                        // Generar nombre único para la imagen
                        $imageName = 'image_' . $titulo . '_' . $currentTimestamp . '.' . $extension;
                        $imagePath = $directory . '/' . $imageName;

                        // Crear la imagen desde el archivo y guardarla
                        $imgResource = imagecreatefromstring(file_get_contents($file->getRealPath()));
                        if ($imgResource) {
                            imagejpeg($imgResource, $imagePath, 90);  // Ajusta la calidad según sea necesario
                            imagedestroy($imgResource);  // Liberar recursos

                            // Guardar la ruta de la imagen en la base de datos
                            $capacitacion->imagen = 'files/cursos/' . $imageName;
                        } else {
                            throw new \Exception('Error al crear la imagen desde el archivo.');
                        }
                    }
                    // Si es un video
                    elseif (strstr($mimeType, 'video')) {
                        // Generar nombre único para el video
                        $videoName = 'video_' . $titulo . '_' . $currentTimestamp . '.' . $extension;
                        $videoPath = $directory . '/' . $videoName;

                        // Mover el video subido al directorio de destino
                        if (!$file->move($directory, $videoName)) {
                            throw new \Exception('Error al mover el archivo de video.');
                        }

                        // Guardar la ruta del video en la base de datos
                        $capacitacion->video = 'files/cursos/' . $videoName;
                    }
                }
            }
        }

        // Guardar los cambios en la base de datos
        $capacitacion->save();

        // Retornar respuesta, redirigir o lo que necesites
        return response()->json([
            'message' => 'Capacitación actualizada correctamente',
            'capacitacion' => $capacitacion
        ]);
    }

    public function editCapacitacion($id)
    {
        $capacitacion = LandingCursosDetalles::find($id);
        $Title = 'Agregar Publicidad sobre Curso';
        $categorias = LandingCursosCategorias::where('estado', 1)->get();
        $moodle = new MoodleController();
        $response = $moodle->listarCursos(); // Este devuelve un JsonResponse
        //dd($response);
        // Accede al contenido real (decode JSON)
       
       
        $cursosMoodle = $response->getData(true); // convierte JsonResponse a array
        $cursosSimplificados = [];
            foreach ($cursosMoodle as $curso) {
                if (isset($curso['id'], $curso['fullname']) && $curso['id'] != 1) {
                    $cursosSimplificados[] = [
                        'id' => $curso['id'],
                        'fullname' => html_entity_decode($curso['fullname'])
                    ];
                }
            }
            
        return view('backend.capacitaciones.capacitacion_item_edit',
            compact('Title', 'categorias', 'capacitacion', 'cursosSimplificados'));
    }
    public function getCursosDatatable()
    {

        try {
            $about = LandingCursosDetalles::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'subtitulo' => $item->subtitulo,
                    'fecha_inicio' => $item->fecha_inicio,
                    'estado' => $item->estado == 1 ? 'Activo' : 'Inactivo',
                    'actions' => '
                    <div class="d-flex align-items-center">
                        <a type="button" href="/capacitaciones/'.$item->id.'/edit" class="btn btn-sm btn-primary me-2" >
                            <i data-feather="edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger me-2" onclick="deleteNavItem(' . $item->id . ')">
                            <i data-feather="x-circle"></i>
                        </button>
                    </div>
                ',
                ];
            }

            return response()->json([
                'draw' => intval(request()->input('draw')), // Mismo draw que envía el datatables
                'recordsTotal' => $about->count(),
                'recordsFiltered' => $about->count(),
                'data' => $data
            ], 200);

            // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteItem($id)
    {
        $capacitacion = LandingCursosDetalles::find($id);
        $capacitacion->estado = 0;
        $capacitacion->save();
        if ($capacitacion) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Capacitación"], 500);
        }
    }

    // SECCION PARA LAS CATEGORIAS
    public function indexCategorias()
    {
        $Title = 'Sección CATEGORIAS DE CURSOS ';
        $tableTitle = 'Lista de Items';
        $modalTitle = 'Agregar Nueva Categoría';
        $landingCapacitacionesCategorias = LandingCursosCategorias::where('estado', 1)->first();
        return view('backend.capacitaciones.categorias', compact('Title', 'tableTitle', 'landingCapacitacionesCategorias', 'modalTitle'));
    }

    public function getCapacitacionesDatatable()
    {

        try {
            $about = LandingCursosCategorias::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'estado' => $item->estado == 1 ? 'Activo' : 'Inactivo',
                    'actions' => '
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-primary me-2" onclick="openEditModal(' . $item->id . ')">
                            <i data-feather="edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger me-2" onclick="deleteNavItem(' . $item->id . ')">
                            <i data-feather="x-circle"></i>
                        </button>
                    </div>
                ',
                ];
            }

            return response()->json([
                'draw' => intval(request()->input('draw')), // Mismo draw que envía el datatables
                'recordsTotal' => $about->count(),
                'recordsFiltered' => $about->count(),
                'data' => $data
            ], 200);

            // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }

    public function storeCategoria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'subtitulo' => 'required|string|max:255',
            ]);

            $data = [
                'titulo' => $validatedData['titulo'],
                'subtitulo' => $validatedData['subtitulo'],
            ];

            $about = LandingCursosCategorias::create($data);

            return response()->json($about, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar la el Items', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateCategoria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'subtitulo' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $categoria = LandingCursosCategorias::find($validatedData['id']);
            $categoria->titulo = $validatedData['titulo'];
            $categoria->subtitulo = $validatedData['subtitulo'];
            $categoria->save();
            if ($categoria) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Actualizar la Categoria"], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }
    public function editCategoria($id)
    {
        $categoria = LandingCursosCategorias::find($id);
        return response()->json(['data' => $categoria]);
    }
    public function destroyCategoria($id)
    {
        $categoria = LandingCursosCategorias::find($id);
        $categoria->estado = 0;
        $categoria->save();
        if ($categoria) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Categoria"], 500);
        }
    }
}

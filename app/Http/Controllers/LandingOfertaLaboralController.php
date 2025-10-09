<?php

namespace App\Http\Controllers;

use App\Models\LandingAplicacionOferta;
use App\Models\LandingBlogsDetalles;
use App\Models\LandingOfertaLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class LandingOfertaLaboralController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Ofertas';
        $tableTitle = 'Listado de Ofertas';
        return view('backend.ofertas.ofertas', compact('Title','tableTitle'));
    }
    public function create()
    {
        $Title = 'Crear Oferta Laboral';
        $ruta = 'oferta.store';
        $boton = 'Lanzar Oferta Laboral';
        $blog = new LandingOfertaLaboral();
        return view('backend.ofertas.item_oferta', compact('Title' ,'blog', 'ruta', 'boton'));
    }

    public function datatableOfertas(Request $request)
    {
        try {
            $about = LandingOfertaLaboral::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'subtitulo' => $item->subtitulo,
                    'fecha' => $item->fecha,
                    'autor' => $item->autor,
                    'estado' => $item->estado == 1 ? 'Activo' : 'Inactivo',
                    'actions' => '
                    <div class="d-flex align-items-center">
                        <a type="button" href="/oferta/'.$item->id.'/edit" class="btn btn-sm btn-primary me-2" >
                            <i data-feather="edit"></i>
                        </a>
                        <button type="button" onclick="deleteNavItem(' . $item->id . ')" class="btn btn-sm btn-danger me-2" >
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

    public function store(Request $request)
    {


        try {
            $blog = new LandingOfertaLaboral();

            // Verificar si se subió una imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                // Sanitizar el nombre del archivo: quitar caracteres especiales y espacios
                $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imageDir = public_path('front/img/ofertas/'); // Directorio donde guardar la imagen
                $imagePath = $imageDir . $imageName;

                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($imageDir)) {
                    mkdir($imageDir, 0775, true); // Crear directorio con permisos 775
                }

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Convertir a color verdadero si es necesario
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    // Guardar como WebP
                    if (!imagewebp($imgResource, $imagePath)) {
                        throw new \Exception('Error al guardar la imagen en formato WebP.');
                    }
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/ofertas/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Imagen por defecto si no se subió ninguna imagen
                $imagenPath = 'front/img/placeholder.jpg';
            }

            // Asignar valores al modelo
            $blog->titulo = $request->titulo;
            $blog->subtitulo = $request->subtitulo;
            $blog->detalle = $request->detalle_completo;
            $blog->imagen = $imagenPath;
            $blog->fecha = $request->fecha;
            $blog->autor = $request->autor;
            $blog->tipo = $request->tipo;
            $blog->tags = $request->tags;
            $blog->estado = 1;

            // Guardar en la base de datos
            $blog->save();

            return redirect()->route('seccionOfertas')->with('success', 'Oferta Generada exitosamente.');

        } catch (\Exception $e) {
            // Manejar el error y redirigir con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar la oferta Laboral: ' . $e->getMessage()]);
            //dd($e->getMessage());
        }
    }

    public function update(Request $request)
    {

        try {
            $blog = LandingOfertaLaboral::findOrFail($request->id);

            // Verificar si se subió una imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                // Sanitizar el nombre del archivo: quitar caracteres especiales y espacios
                $originalName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imageDir = public_path('front/img/ofertas/'); // Directorio donde guardar la imagen
                $imagePath = $imageDir . $imageName;

                // Verificar si el directorio existe, si no, crearlo
                if (!file_exists($imageDir)) {
                    mkdir($imageDir, 0775, true); // Crear directorio con permisos 775
                }

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Convertir a color verdadero si es necesario
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    // Guardar como WebP
                    if (!imagewebp($imgResource, $imagePath)) {
                        throw new \Exception('Error al guardar la imagen en formato WebP.');
                    }
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/ofertas/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Imagen por defecto si no se subió ninguna imagen
                $imagenPath = $blog->imagen;
            }

            // Asignar valores al modelo
            $blog->titulo = $request->titulo;
            $blog->subtitulo = $request->subtitulo;
            $blog->detalle = $request->detalle_completo;
            $blog->imagen = $imagenPath;
            $blog->fecha = $request->fecha;
            $blog->autor = $request->autor;
            $blog->tipo = $request->tipo;
            $blog->tags = $request->tags;
            $blog->estado = 1;

            // Guardar en la base de datos
            $blog->save();

            return redirect()->route('seccionOfertas')->with('success', 'Oferta actualizado exitosamente.');

        } catch (\Exception $e) {
            // Manejar el error y redirigir con un mensaje de error
            return redirect()->back()->withErrors(['error' => 'Hubo un error al guardar el blog: ' . $e->getMessage()]);
           // dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $Title = 'Editar Oferta Laboral';
        $ruta = 'oferta.update';
        $boton = 'Actualizar Oferta Laboral';
        $blog = LandingOfertaLaboral::find($id);
        return view('backend.ofertas.item_oferta', compact('Title' ,'blog', 'ruta', 'boton'));
    }
    public function delete(Request $request)
    {
        try {
            // Buscar el blog por el ID
            $blog = LandingOfertaLaboral::findOrFail($request->id);

            // Eliminar la imagen si existe
            if ($blog->imagen && file_exists(public_path($blog->imagen)) && $blog->imagen !== 'front/img/placeholder.jpg') {
                unlink(public_path($blog->imagen));
            }

            // Eliminar el blog de la base de datos
            $blog->estado = 0;
            $blog->save();

            return response()->json(['success' => true, 'message' => 'Oferta Larotal eliminado exitosamente.']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al eliminar el blog: ' . $e->getMessage()], 500);
        }
    }

    public function verOferta($id)
    {
        $blog = LandingOfertaLaboral::find($id);
        return view('landing/components/ver_oferta', compact('blog'));
    }

    public function ofertasLaborales()
    {
        $blogs = LandingOfertaLaboral::where('estado', 1)->orderBy('id', 'desc')->get();
        return view('landing/components/ofertas_laborales', compact('blogs'));
    }

    // Mostrar el formulario de aplicación
    public function mostrarFormulario($id)
    {
        $blog = LandingOfertaLaboral::find($id); // Cargar los detalles de la oferta
        return view('landing/components/aplicar_oferta', compact('blog'));
    }

    // Enviar el formulario de aplicación
    public function enviarFormulario(Request $request, $id)
    {
        // Validar los campos del formulario
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'hoja_vida' => 'required|mimes:pdf,doc,docx|max:2048', // Verifica el archivo de la hoja de vida
        ]);

        try {
            // Obtener los datos del formulario
            $nombres = $request->input('nombres');
            $apellidos = $request->input('apellidos');

            // Verificar si se ha cargado el archivo correctamente
            if ($request->hasFile('hoja_vida')) {
                $hoja_vida = $request->file('hoja_vida');

                // Verificar si el archivo es válido
                if (!$hoja_vida->isValid()) {
                    return redirect()->back()->withErrors(['error' => 'Error al subir el archivo.']);
                }

                // Generar el nombre del archivo
                $nombreArchivo = 'hoja_de_vida_' . str_replace(' ', '_', $nombres) . '_' . str_replace(' ', '_', $apellidos) . '.' . $hoja_vida->getClientOriginalExtension();

                // Definir la ruta de la carpeta
                $carpetaDestino = public_path('files/documentos/hojas_vida');

                // Verificar si la carpeta existe, si no, crearla
                if (!File::exists($carpetaDestino)) {
                    File::makeDirectory($carpetaDestino, 0755, true); // Crear la carpeta con permisos 0755
                }

                // Usar el método nativo de PHP para mover el archivo a la ubicación especificada
                $rutaArchivoCompleta = $carpetaDestino . '/' . $nombreArchivo;
                $guardadoExitoso = $hoja_vida->move($carpetaDestino, $nombreArchivo);

                // Verificar si el archivo se guardó correctamente
                if (!$guardadoExitoso) {
                    return redirect()->back()->withErrors(['error' => 'El archivo no se pudo guardar correctamente.']);
                }

                // Guardar en la base de datos
                LandingAplicacionOferta::create([
                    'nombres' => $request->nombres,
                    'apellidos' => $request->apellidos,
                    'telefono' => $request->telefono,
                    'correo' => $request->correo,
                    'hoja_vida' => 'files/documentos/hojas_vida/' . $nombreArchivo, // Guardamos la ruta relativa del archivo
                    'oferta_id' => $id
                ]);

                // Redirigir con éxito
                return redirect()->route('aplicar.oferta', $id)->with('success', 'Aplicación enviada con éxito');
            } else {
                return redirect()->back()->withErrors(['error' => 'No se subió ningún archivo.']);
            }

        } catch (\Exception $e) {
            // Manejar cualquier excepción y registrar el error
            Log::error('Error al guardar el archivo de la hoja de vida: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Hubo un error al procesar su solicitud. Por favor intente nuevamente.']);
        }
    }


    public function indexAplicacionesOferta()
    {
        $Title = 'Aplicaciones a ofertas de Trabajo ';
        $tableTitle = 'Listado de Ofertas';
        return view('backend.ofertas.Aplicaciones_oferta', compact('Title','tableTitle'));
    }

    public function datatableOfertasRecibidas(Request $request)
    {
        try {
            // $about = LandingAplicacionOferta::orderBy('id', 'asc')->get();
            $about = LandingAplicacionOferta::with('ofertaLaboral')
                ->orderBy('id', 'asc')
                ->get();
            $data = [];

            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id, // ID de la aplicación
                    'nombres' => $item->nombres, // Atributo 'nombres' de la tabla 'LandingAplicacionOferta'
                    'apellidos' => $item->apellidos, // Atributo 'apellidos' de la tabla 'LandingAplicacionOferta'
                    'telefono' => $item->telefono, // Atributo 'telefono' de la tabla 'LandingAplicacionOferta'
                    'correo' => $item->correo, // Atributo 'correo' de la tabla 'LandingAplicacionOferta'
                    'Oferta_Aplicada' => $item->ofertaLaboral->titulo, // Atributo 'titulo' de la tabla relacionada 'LandingOfertaLaboral'
                    'actions' => '
                <div class="d-flex align-items-center">
                    <a type="button" href="/descargar_hoja_vida/'.$item->id.'" class="btn btn-sm btn-primary me-2" >
                        <i data-feather="download"></i>
                    </a>
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

    public function descargar_hoja_vida($id)
    {
        try {
            // Encontrar la aplicación por ID
            $aplicacion = LandingAplicacionOferta::find($id);

            if (!$aplicacion) {
                return redirect()->back()->withErrors(['error' => 'Aplicación no encontrada.']);
            }

            // Obtener la ruta del archivo
            $archivo = $aplicacion->hoja_vida; // La ruta guardada en la base de datos (ej: files/hojas_vida/hoja_de_vida_OSCAR_LEONARDO_CORNEJO_BAQUERO.pdf)

            // Generar la ruta completa (debido a que está en public/)
            $rutaArchivo = public_path($archivo);
           // dd($rutaArchivo);
            // Verificar si el archivo existe
            if (file_exists($rutaArchivo)) {
                // Descargar el archivo
                return response()->download($rutaArchivo);
            } else {
              //  dd("el archiv no existe");
                // En caso de que el archivo no exista, lanzar un error 404 o un mensaje personalizado
                return redirect()->back()->withErrors(['error' => 'El archivo no existe o ha sido eliminado.']);
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción y mostrarla para depuración
          //  dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error al intentar descargar el archivo: ' . $e->getMessage()]);
        }
    }
}

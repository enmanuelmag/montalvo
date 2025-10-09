<?php

namespace App\Http\Controllers;

use App\Models\LandingAbout;
use App\Models\LandingAboutItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class LandingAboutController extends Controller
{
    //

    public function index()
    {
        $Title = 'Sección Sobre Nosotros';
        $modalTitle = 'Agregar Sobre Nosotros';
        $tableTitle = 'Lista de Items';
        $landingAbout = LandingAbout::where('estado', 1)->first();
        return view('backend.about.about', compact('Title', 'modalTitle','tableTitle', 'landingAbout'));
    }

    public function getNosotrosDatatable()
    {

        try {
            $about = LandingAboutItem::where('estado', 1)->orderBy('id', 'asc')->get();
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
/*
    public function update(Request $request) {
       
        $validatedData = $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'imagen_seccion' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion1' => 'required|string|max:255',
            'parrafo1' => 'required|string|max:255',
            'parrafo2' => 'required|string|max:255',
            'btn_text' => 'required|string|max:255',
            'btn_link' => 'required|string|max:255',
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];
        $imagenPath = null;

        try {
            // Buscar el registro existente
            $general = LandingAbout::findOrFail($id);

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());

                // Obtén la fecha y hora actual formateada
                $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
                $imageName = 'imagen_seccion_about_' . $currentDateTime . '.jpg';
                $directory = public_path('files/img/home/about');

                // Verifica si el directorio existe, si no, créalo
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                $imagePath = $directory . '/' . $imageName;

                // Crea la imagen desde el archivo y guarda en el path especificado
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    imagejpeg($imgResource, $imagePath, 90);
                    imagedestroy($imgResource);
                    $imagenPath = 'files/img/home/about/' . $imageName;
                    Log::info('Imagen de sección guardada en: ' . $imagenPath);

                    // Eliminar la imagen anterior si existe
                    if ($general->imagen) {
                        $oldImagePath = public_path($general->imagen);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Mantener la imagen actual si no se ha subido una nueva
                $imagenPath = $general->imagen;
            }

            // Manejo de la nueva imagen "imagen_seccion"
            if ($request->hasFile('imagen_seccion')) {
                $imageSeccion = $request->file('imagen_seccion');
                Log::info('Nueva imagen de sección encontrada: ' . $imageSeccion->getClientOriginalName());

                // Obtén la fecha y hora actual formateada
                $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
                $imageSeccionName = 'about_fondo.jpg';
                $directorySeccion = public_path('files/img');

                // Verifica si el directorio existe, si no, créalo
                if (!file_exists($directorySeccion)) {
                    mkdir($directorySeccion, 0755, true);
                }

                $imageSeccionPath = $directorySeccion . '/' . $imageSeccionName;

                // Crea la imagen desde el archivo y guarda en el path especificado
                $imgSeccionResource = imagecreatefromstring(file_get_contents($imageSeccion->getRealPath()));
                if ($imgSeccionResource) {
                    imagejpeg($imgSeccionResource, $imageSeccionPath, 90);
                    imagedestroy($imgSeccionResource);
                    $imagenSeccionPath = 'files/img/' . $imageSeccionName;
                    Log::info('Nueva imagen de sección guardada en: ' . $imagenSeccionPath);

                    // Eliminar la imagen anterior si existe
                    if ($general->imagen_seccion) {
                        $oldImageSeccionPath = public_path($general->imagen_seccion);
                        if (file_exists($oldImageSeccionPath)) {
                            unlink($oldImageSeccionPath);
                        }
                    }
                } else {
                    throw new \Exception('Error al crear la nueva imagen de sección desde el archivo.');
                }
            } else {
                // Mantener la imagen actual de sección si no se ha subido una nueva
                $imagenSeccionPath = $general->imagen_seccion;
            }



            // Actualizar el registro con los nuevos datos
            $general->update([
                'titulo' => $validatedData['titulo'],
                'descripcion1' => $validatedData['descripcion1'],
                'parrafo1' => $validatedData['parrafo1'],
                'parrafo2' => $validatedData['parrafo2'],
                'btn_text' => $validatedData['btn_text'],
                'btn_link' => $validatedData['btn_link'],
                'imagen' => $imagenPath,
                'imagen_seccion' => $imagenSeccionPath,
                'btn_text' => $validatedData['btn_text'],
                'btn_link' => $validatedData['btn_link'],
            ]);

            return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
        } catch (\Exception $e) {
            Log::error('Error in updateAbout method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

*/
public function update(Request $request) {
    // Validar los datos recibidos
    $validatedData = $request->validate([
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        'imagen_seccion' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        'titulo' => 'required|string|max:255',
        'descripcion1' => 'required|string|max:255',
        'parrafo1' => 'required|string|max:255',
        'parrafo2' => 'required|string|max:255',
        'btn_text' => 'required|string|max:255',
        'btn_link' => 'required|string|max:255',
        'id' => 'required|integer'
    ]);

    $id = $validatedData['id'];
    $imagenPath = null; // Inicializar como null

    try {
        // Buscar el registro existente
        $general = LandingAbout::findOrFail($id);

        // Inicializar con las rutas actuales de las imágenes, en caso de que no se suban nuevas imágenes
        $imagenPath = $general->imagen;
        $imagenSeccionPath = $general->imagen_seccion;

        // Manejo de la imagen principal "imagen"
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            Log::info('Imagen encontrada: ' . $image->getClientOriginalName());

            // Generar el nombre de la nueva imagen
            $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
            $imageName = 'imagen_seccion_about_' . $currentDateTime . '.jpg';
            $directory = public_path('files/img/home/about');

            // Verificar si el directorio existe, si no, crearlo
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $imagePath = $directory . '/' . $imageName;

            // Crear la imagen desde el archivo y guardarla
            if ($image->getClientOriginalExtension() === 'jpg' || $image->getClientOriginalExtension() === 'jpeg') {
                $imgResource = imagecreatefromjpeg($image->getRealPath());
            } elseif ($image->getClientOriginalExtension() === 'png') {
                $imgResource = imagecreatefrompng($image->getRealPath());
            } elseif ($image->getClientOriginalExtension() === 'gif') {
                $imgResource = imagecreatefromgif($image->getRealPath());
            } else {
                throw new \Exception('Formato de imagen no soportado.');
            }

            // Verificar si se pudo crear el recurso de imagen
            if ($imgResource) {
                imagejpeg($imgResource, $imagePath, 90);
                imagedestroy($imgResource); // Liberar la memoria del recurso de imagen
                $imagenPath = 'files/img/home/about/' . $imageName;
                Log::info('Imagen guardada en: ' . $imagenPath);

                // Eliminar la imagen anterior si existe
                if ($general->imagen && file_exists(public_path($general->imagen))) {
                    unlink(public_path($general->imagen));
                }

                // Verificar si la imagen fue guardada correctamente
                if (!file_exists($imagePath)) {
                    throw new \Exception('La imagen no fue guardada correctamente.');
                }
            } else {
                throw new \Exception('Error al procesar la imagen.');
            }
        }
// Manejo de la nueva imagen "imagen_seccion"
if ($request->hasFile('imagen_seccion')) {
    $imageSeccion = $request->file('imagen_seccion');
    Log::info('Nueva imagen de sección encontrada: ' . $imageSeccion->getClientOriginalName());

    // Verificar el tipo MIME
    Log::info('Tipo MIME de la imagen de sección: ' . $imageSeccion->getMimeType());

    // Establecer el nombre de la imagen (con extensión .jpg, ya que la transformaremos a JPEG)
    $imageSeccionName = 'about_fondo.jpg';
    $directorySeccion = public_path('files/img');

    // Verificar si el directorio existe, si no, crearlo
    if (!file_exists($directorySeccion)) {
        mkdir($directorySeccion, 0755, true);
    }

    $imageSeccionPath = $directorySeccion . '/' . $imageSeccionName;

    // Crear la imagen desde el archivo, independientemente de su formato original
    $imgSeccionResource = null;
    if ($imageSeccion->getClientOriginalExtension() === 'jpg' || $imageSeccion->getClientOriginalExtension() === 'jpeg') {
        $imgSeccionResource = imagecreatefromjpeg($imageSeccion->getRealPath());
    } elseif ($imageSeccion->getClientOriginalExtension() === 'png') {
        $imgSeccionResource = imagecreatefrompng($imageSeccion->getRealPath());
    } elseif ($imageSeccion->getClientOriginalExtension() === 'gif') {
        $imgSeccionResource = imagecreatefromgif($imageSeccion->getRealPath());
    } elseif ($imageSeccion->getClientOriginalExtension() === 'webp') {
        $imgSeccionResource = imagecreatefromwebp($imageSeccion->getRealPath());
    } else {
        throw new \Exception('Formato de imagen no soportado.');
    }

    // Verificar si se pudo crear el recurso de imagen
    if ($imgSeccionResource) {
        Log::info('Intentando guardar la imagen de sección en formato JPG en: ' . $imageSeccionPath);

        // Guardar la imagen transformada a formato JPG
        imagejpeg($imgSeccionResource, $imageSeccionPath, 90); // Convertir la imagen a JPEG y guardarla
        imagedestroy($imgSeccionResource);  // Liberar la memoria del recurso de imagen

        // Verificar si la imagen fue guardada correctamente
        if (!file_exists($imageSeccionPath)) {
            Log::error('Error: La imagen no fue guardada en la ruta especificada.');
            throw new \Exception('La imagen de sección no fue guardada correctamente.');
        } else {
            Log::info('La imagen de sección fue guardada exitosamente en: ' . $imageSeccionPath);
        }

        // Actualizar el path de la imagen de sección
        $imagenSeccionPath = 'files/img/' . $imageSeccionName;

      
    } else {
        throw new \Exception('Error al procesar la nueva imagen de sección.');
    }
}
        // Actualizar el registro con los nuevos datos
        $general->update([
            'titulo' => $validatedData['titulo'],
            'descripcion1' => $validatedData['descripcion1'],
            'parrafo1' => $validatedData['parrafo1'],
            'parrafo2' => $validatedData['parrafo2'],
            'btn_text' => $validatedData['btn_text'],
            'btn_link' => $validatedData['btn_link'],
            'imagen' => $imagenPath, // Actualizar el path de la imagen principal
            'imagen_seccion' => $imagenSeccionPath, // Actualizar el path de la imagen de sección
        ]);

        return response()->json(['success' => true, 'imagen_path' => $imagenPath, 'imagen_seccion'=>$imagenSeccionPath]);
    } catch (\Exception $e) {
        Log::error('Error en el método update: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}

    public function storeItem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
            ]);

            $data = [
                'titulo' => $validatedData['titulo'],
            ];

            $about = LandingAboutItem::create($data);

            return response()->json($about, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar la el Items', 'message' => $e->getMessage()], 500);
        }
    }

    public function editItem($id)
    {
        $nav = LandingAboutItem::find($id);
        return response()->json($nav, 200);
    }

    public function updateItem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $idAbout = $validatedData['id'];
            $data = [
                'titulo' => $validatedData['titulo'],
            ];

            $about = LandingAboutItem::findOrFail($idAbout);
            $about->update($data);

            return response()->json($about, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al Actualizar la Red Social', 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteItem($id)
    {
        $nav = LandingAboutItem::find($id);
        $nav->delete();
        return response()->json(['message' => 'Item eliminado correctamente'], 200);
    }


}

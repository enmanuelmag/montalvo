<?php

namespace App\Http\Controllers;

use App\Models\LandingGeneral;
use App\Services\LandingEstadosService;
use App\Services\LandingGeneralService;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LandingGeneralController extends Controller
{

    public function index()
    {
        $Title = 'Sección General';
        $modalTitle = 'Agregar Sección Item';
        $tableTitle = 'Lista de Items';
        return view('backend.general.general', compact('Title', 'modalTitle','tableTitle'));
    }

    public function show($id)
    {
        $landingGeneral = $this->generalService->find(1);
        return view('landing-general.show', compact('landingGeneral'));
    }

    public function edit($id)
    {
        $landingGeneral = LandingGeneral::find($id);
        return response()->json([
            'draw' => intval(request()->input('draw')), // Mismo draw que envía el datatables
            'recordsTotal' => $landingGeneral->count(),
            'recordsFiltered' => $landingGeneral->count(),
            'data' => $landingGeneral
        ], 200);
    }

/*
    public function update(Request $request) {
        
        $id = $request->idSeccion;
        $imagenPath = null;

        try {
            // Buscar el registro existente
            $general = LandingGeneral::findOrFail($id);

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());

                // Obtén la fecha y hora actual formateada
                $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
                $imageName = 'imagen_seccion_general_' . $currentDateTime . '.jpg';
                $directory = public_path('files/img/home/general');

                // Verifica si el directorio existe, si no, créalo
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                }

                $imagePath = $directory . '/' . $imageName;

                // Crea la imagen desde el archivo y guarda en el path especificado
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    imagejpeg($imgResource, $imagePath, 50);
                    imagedestroy($imgResource);
                    $imagenPath = 'files/img/home/general/' . $imageName;
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

            // Actualizar el registro con los nuevos datos
            $general->update([
                'titulo' => $request->titulo,
                'subtitulo' => $request->subtitulo,
                'descripcion' => $request->descripcion,
                'imagen' => $imagenPath,
                'btn_text' => $request->btn_text,
                'btn_link' => $request->btn_link,
            ]);

            return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
        } catch (\Exception $e) {
            Log::error('Error in updateGeneral method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    */
    public function update(Request $request) {
    $id = $request->idSeccion;
    $imagenPath = null;
    try {
        // Buscar el registro existente
        $general = LandingGeneral::findOrFail($id);
        
        // Manejo de la imagen
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());
            
            // Obtén la fecha y hora actual formateada
            $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
            $imageName = 'imagen_seccion_general_' . $currentDateTime . '.webp';
            $directory = public_path('files/img/home/general');
            
            // Verifica si el directorio existe, si no, créalo
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $imagePath = $directory . '/' . $imageName;
            
            // Determinamos el tipo de imagen original
            $imageType = exif_imagetype($image->getRealPath());
            $imgResource = null;
            
            // Creamos el recurso de imagen según su tipo
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $imgResource = imagecreatefromjpeg($image->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $imgResource = imagecreatefrompng($image->getRealPath());
                    // Preservar transparencia si existe
                    imagealphablending($imgResource, true);
                    imagesavealpha($imgResource, true);
                    break;
                case IMAGETYPE_GIF:
                    $imgResource = imagecreatefromgif($image->getRealPath());
                    break;
                case IMAGETYPE_WEBP:
                    $imgResource = imagecreatefromwebp($image->getRealPath());
                    break;
                default:
                    // Para otros formatos, intentamos con imagecreatefromstring
                    $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
            }
            
            if ($imgResource) {
                // Obtener dimensiones originales
                $originalWidth = imagesx($imgResource);
                $originalHeight = imagesy($imgResource);
                
                // Crear imagen con las mismas dimensiones pero optimizada
                $newImage = imagecreatetruecolor($originalWidth, $originalHeight);
                
                // Preservar transparencia para PNG o GIF
                if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                    imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                }
                
                // Copiar y reescalar la imagen
                imagecopyresampled(
                    $newImage, 
                    $imgResource, 
                    0, 0, 0, 0, 
                    $originalWidth, 
                    $originalHeight, 
                    $originalWidth, 
                    $originalHeight
                );
                
                // Guardar como WebP con calidad óptima (85 es un buen equilibrio entre calidad y tamaño)
                imagewebp($newImage, $imagePath, 85);
                
                // Liberar memoria
                imagedestroy($imgResource);
                imagedestroy($newImage);
                
                $imagenPath = 'files/img/home/general/' . $imageName;
                Log::info('Imagen de sección guardada en formato WebP: ' . $imagenPath);
                
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
        
        // Actualizar el registro con los nuevos datos
        $general->update([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'descripcion' => $request->descripcion,
            'imagen' => $imagenPath,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
        ]);
        
        return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
    } catch (\Exception $e) {
        Log::error('Error in updateGeneral method: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}
/*
    public function store(Request $request)
    {
     
        $imagenPath = null;

        try {
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());

                // Obtén la fecha y hora actual formateada
                $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
                $imageName = 'imagen_seccion_general_' . $currentDateTime . '.jpg';
                $directory = public_path('files/img/home/general');

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
                    $imagenPath = 'files/img/home/general/' . $imageName;
                    Log::info('Imagen de sección guardada en: ' . $imagenPath);
                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            }
            $data = [
                'titulo' => $request['titulo'],
                'subtitulo' => $request['subtitulo'],
                'descripcion' => $request['descripcion'],
                'imagen' => $imagenPath,
                'btn_text' => $request['btn_text'],
                'btn_link' => $request['btn_link'],

            ];
          //  dd($data);
            $resultado = LandingGeneral::create($data); // Cambié `created` a `create`

            if ($resultado) { // Cambié la verificación del resultado
                return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
            } else {
                return response()->json(['success' => false, 'error' => 'Error al guardar en la base de datos'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    */
    
    public function store(Request $request)
{
    $imagenPath = null;
    try {
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());
            
            // Obtén la fecha y hora actual formateada
            $currentDateTime = \Carbon\Carbon::now()->format('Ymd_His');
            $imageName = 'imagen_seccion_general_' . $currentDateTime . '.webp';
            $directory = public_path('files/img/home/general');
            
            // Verifica si el directorio existe, si no, créalo
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $imagePath = $directory . '/' . $imageName;
            
            // Determinamos el tipo de imagen original
            $imageType = exif_imagetype($image->getRealPath());
            $imgResource = null;
            
            // Creamos el recurso de imagen según su tipo
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $imgResource = imagecreatefromjpeg($image->getRealPath());
                    break;
                case IMAGETYPE_PNG:
                    $imgResource = imagecreatefrompng($image->getRealPath());
                    // Preservar transparencia si existe
                    imagealphablending($imgResource, true);
                    imagesavealpha($imgResource, true);
                    break;
                case IMAGETYPE_GIF:
                    $imgResource = imagecreatefromgif($image->getRealPath());
                    break;
                case IMAGETYPE_WEBP:
                    $imgResource = imagecreatefromwebp($image->getRealPath());
                    break;
                default:
                    // Para otros formatos, intentamos con imagecreatefromstring
                    $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
            }
            
            if ($imgResource) {
                // Obtener dimensiones originales
                $originalWidth = imagesx($imgResource);
                $originalHeight = imagesy($imgResource);
                
                // Crear imagen con las mismas dimensiones pero optimizada
                $newImage = imagecreatetruecolor($originalWidth, $originalHeight);
                
                // Preservar transparencia para PNG o GIF
                if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
                    imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                }
                
                // Copiar y reescalar la imagen
                imagecopyresampled(
                    $newImage, 
                    $imgResource, 
                    0, 0, 0, 0, 
                    $originalWidth, 
                    $originalHeight, 
                    $originalWidth, 
                    $originalHeight
                );
                
                // Guardar como WebP con calidad óptima (80-85 es un buen equilibrio entre calidad y tamaño)
                imagewebp($newImage, $imagePath, 85);
                
                // Liberar memoria
                imagedestroy($imgResource);
                imagedestroy($newImage);
                
                $imagenPath = 'files/img/home/general/' . $imageName;
                Log::info('Imagen de sección guardada en formato WebP: ' . $imagenPath);
            } else {
                throw new \Exception('Error al crear la imagen desde el archivo.');
            }
        }
        
        $data = [
            'titulo' => $request['titulo'],
            'subtitulo' => $request['subtitulo'],
            'descripcion' => $request['descripcion'],
            'imagen' => $imagenPath,
            'btn_text' => $request['btn_text'],
            'btn_link' => $request['btn_link'],
        ];
        
        $resultado = LandingGeneral::create($data);
        
        if ($resultado) {
            return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
        } else {
            return response()->json(['success' => false, 'error' => 'Error al guardar en la base de datos'], 500);
        }
    } catch (\Exception $e) {
        Log::error('Error in store method: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}

    public function getGeneralDatatable()
    {

        try {
            $general = LandingGeneral::where('estado', 1)->get();
            $data = [];
            foreach ($general as $item) {
                $data[] = [
                    'id' => $item->id,
                    'titulo' => $item->titulo,
                    'subtitulo' => $item->subtitulo,
                    'descripcion' => $item->descripcion,
                    'imagen' => '<img src="'.asset($item->imagen).'" alt="Imagen" style="width: 50px; height: auto;">',
                    'btn_text' => $item->btn_text,
                    'btn_link' => $item->btn_link,
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
                'recordsTotal' => $general->count(),
                'recordsFiltered' => $general->count(),
                'data' => $data
            ], 200);

           // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }
    
      public function delete($id)
    {
        $nav = LandingGeneral::find($id);
        $nav->delete();
        return response()->json(['message' => 'Item eliminado correctamente'], 200);
    }
}

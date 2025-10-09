<?php

namespace App\Http\Controllers;

use App\Models\LandingSuscribete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingSuscripcionesController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Suscripciones';
        $landingSuscripciones = LandingSuscribete::where('estado', 1)->first();
        return view('backend.suscripciones.suscripciones', compact('Title', 'landingSuscripciones'));
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'titulo' => 'required|string|max:255',
            'detalle' => 'required|string|max:255',
            'subtitulo' => 'required|string|max:255',
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];
        $imagenPath = null;

        try {
            // Buscar el registro existente
            $suscripcion = LandingSuscribete::findOrFail($id);

            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());

                // Obtén la fecha y hora actual formateada

                $imageName = 'imagen_seccion_suscribete_.jpg';
                $directory = public_path('files/img');

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
                    $imagenPath = 'files/img/' . $imageName;
                    Log::info('Imagen de sección guardada en: ' . $imagenPath);


                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Mantener la imagen actual si no se ha subido una nueva
                $imagenPath = $suscripcion->imagen;
            }

            $suscripcion->titulo = $validatedData['titulo'];
            $suscripcion->detalle = $validatedData['detalle'];
            $suscripcion->subtitulo = $validatedData['subtitulo'];
            $suscripcion->imagen = $imagenPath;
            $suscripcion->save();

            return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
        } catch (\Exception $e) {
            Log::error('Error in updateAbout method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


}

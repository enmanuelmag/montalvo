<?php

namespace App\Http\Controllers;

use App\Models\LandingContactos;
use App\Models\LandingInformacionContactos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingContactosController extends Controller
{
    //
    // nombre de la imagen de fondo : fondo_seccion_contacto
    public function index()
    {
        $Title = 'Sección Contactos';
        $landingAContacto = LandingContactos::where('estado', 1)->first();
        $landingInformacionContacto = LandingInformacionContactos::where('estado', 1)->first();
        return view('backend.contactos.contactos', compact('Title', 'landingAContacto', 'landingInformacionContacto'));
    }

    public function update(Request $request) {


        $idContacto = $request->input('idlandingAContacto');
        $idInformacionContacto = $request->input('idlandingInformacionContacto');
        $imagenPath = null;

        try {
            // Buscar el registro existente
            $contacto = LandingContactos::findOrFail($idContacto);


            $informacionContacto = LandingInformacionContactos::findOrFail($idInformacionContacto);


            // Manejo de la imagen
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                Log::info('Imagen de sección encontrada: ' . $image->getClientOriginalName());


                $imageName = 'fondo_seccion_contacto.jpg';
                $directory = public_path('files/img/');

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

                    // Eliminar la imagen anterior si existe
                    if ($contacto->imagen) {
                        $oldImagePath = public_path($contacto->imagen);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                // Mantener la imagen actual si no se ha subido una nueva
                $imagenPath = $contacto->imagen_seccion;
            }

            // Actualizar el registro con los nuevos datos
            $contacto->update([
                'nombre' => $request->input('nombre'),
                'detalle' => $request->input('detalle'),
                'imagen_seccion' => $imagenPath,

            ]);

            $informacionContacto->update([
                'titulo' => $request->input('titulo_2'),
                'subtitulo' => $request->input('subtitulo'),
                'detalle' => $request->input('detalle_2'),
            ]);

            $contacto->save();
            $informacionContacto->save();
            return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
        } catch (\Exception $e) {
            Log::error('Error in updateAbout method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}

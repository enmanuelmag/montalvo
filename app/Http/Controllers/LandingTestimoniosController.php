<?php

namespace App\Http\Controllers;

use App\Models\LandingTestimonios;
use App\Models\LandingTestimoniosDetalles;
use Illuminate\Http\Request;

class LandingTestimoniosController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Testimonios';
        $tableTitle = 'Lista de Items';
        $modalTitle = 'Agregar Testimonio';
        $testimonio = LandingTestimonios::where('estado', 1)->first();
        return view('backend.testimonios.testimonios', compact('Title', 'tableTitle', 'testimonio', 'modalTitle'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];
        $seccionTestimonios = LandingTestimonios::find($id);
        $seccionTestimonios->titulo = $request->input('titulo');
        $seccionTestimonios->subtitulo = $request->input('subtitulo');
        $seccionTestimonios->save();
        return response()->json(['success' => true, 'msg' => 'Actualizado Con Exito']);
    }
    public function getDatatable()
    {

        try {
            $itemTrabajo = LandingTestimoniosDetalles::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($itemTrabajo as $item) {
                $data[] = [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'cargo' => $item->cargo,
                    'empresa' => $item->cargo,
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
                'recordsTotal' => $itemTrabajo->count(),
                'recordsFiltered' => $itemTrabajo->count(),
                'data' => $data
            ], 200);

            // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'nombre' => 'string|max:255',
                'cargo' => 'string|max:255',
                'descripcion' => 'string|max:255',
                'empresa' => 'string|max:255',
                'calificacion' => 'string|max:255',
            ]);
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

// Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

// Reemplazar los espacios por guiones bajos o eliminarlos
                $originalName = str_replace(' ', '_', $originalName); // Reemplaza espacios por guiones bajos

// O bien, si prefieres eliminar los espacios directamente
// $originalName = str_replace(' ', '', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/testimonio/');

// Verificar si el directorio no existe y crearlo
                if (!is_dir($directoryPath)) {
                    mkdir($directoryPath, 0777, true); // true para crear directorios recursivamente
                }

                $imagePath = $directoryPath . $imageName;

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Guardar la imagen como WebP
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    imagewebp($imgResource, $imagePath);
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/testimonio/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = 'front/img/testimonio/default.png';
            }
            $data = [
                'nombre' => $validatedData['nombre'],
                'detalle' => $validatedData['descripcion'],
                'imagen' => $imagenPath,
                'cargo' => $validatedData['cargo'],
                'empresa' => $validatedData['empresa'],
                'calificacion' => $validatedData['calificacion'],
                'estado' => 1,
            ];

            $itemTestimonio = new LandingTestimoniosDetalles($data);
            $itemTestimonio->save();

            if ($itemTestimonio) {
                return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar el ITEM"], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $equipoItem = LandingTestimoniosDetalles::find($id);
        return response()->json($equipoItem, 200);
    }

    public function updateTestimonio(Request $request)
    {
        //dd($request->all());
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'nombre' => 'string|max:255',
                'cargo' => 'string|max:255',
                'descripcion' => 'string|max:255',
                'empresa' => 'string|max:255',
                'calificacion' => 'string|max:255',
                'id_item_testimonio' => 'required|integer',
            ]);
            $idEquipo = $validatedData['id_item_testimonio'];
            $equipoItem = LandingTestimoniosDetalles::find($idEquipo);

            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

// Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

// Reemplazar los espacios por guiones bajos o eliminarlos
                $originalName = str_replace(' ', '_', $originalName); // Reemplaza espacios por guiones bajos

// O bien, si prefieres eliminar los espacios directamente
// $originalName = str_replace(' ', '', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/testimonio/');

// Verificar si el directorio no existe y crearlo
                if (!is_dir($directoryPath)) {
                    mkdir($directoryPath, 0777, true); // true para crear directorios recursivamente
                }

                $imagePath = $directoryPath . $imageName;

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Guardar la imagen como WebP
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    imagewebp($imgResource, $imagePath);
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/testimonio/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = $equipoItem->imagen;
            }
            $equipoItem->nombre = $validatedData['nombre'];
            $equipoItem->cargo = $validatedData['cargo'];
            $equipoItem->imagen = $imagenPath;
            $equipoItem->detalle = $validatedData['descripcion'];
            $equipoItem->empresa = $validatedData['empresa'];
            $equipoItem->calificacion = $validatedData['calificacion'];

            $equipoItem->save();



            if ($equipoItem) {
                return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar el ITEM"], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al Actualizar la Red Social', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $equipoItem = LandingTestimoniosDetalles::find($id);
        $equipoItem->estado = 0;
        $equipoItem->save();
        if ($equipoItem) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Item"], 500);
        }
    }

}

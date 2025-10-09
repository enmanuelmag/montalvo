<?php

namespace App\Http\Controllers;

use App\Models\LandingEquipoTrabajo;
use App\Models\LandingItemEquipoTrabajo;
use Illuminate\Http\Request;

class LandingEquipoTrabajoController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Equipo de Trabajo';
        $modalTitle = 'Agregar Miembro del Equipo';
        $tableTitle = 'Lista de Items';
        $equipo = LandingEquipoTrabajo::where('estado', 1)->first();
        return view('backend.equipoTrabajo.equipoTrabajo', compact('equipo', 'Title', 'modalTitle', 'tableTitle'));
    }
    
     public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];
        $seccionCursos = LandingEquipoTrabajo::find($id);
        $seccionCursos->titulo = $request->input('titulo');
        $seccionCursos->subtitulo = $request->input('subtitulo');
        $seccionCursos->save();
        return response()->json(['success' => true, 'msg' => 'Actualizado Con Exito']);
    }

    public function getDatatable()
    {

        try {
            $itemTrabajo = LandingItemEquipoTrabajo::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($itemTrabajo as $item) {
                $data[] = [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'cargo' => $item->cargo,
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
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'nombre' => 'string|max:255',
                'cargo' => 'string|max:255',
                'descripcion' => 'string|max:255',
                'facebook' => 'string|max:255',
                'twitter' => 'string|max:255',
                'linkedin' => 'string|max:255',
                'instagram' => 'string|max:255',
                'youtube' => 'string|max:255',
            ]);
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/equipo_trabajo/');

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
                    $imagenPath = 'front/img/equipo_trabajo/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = 'front/img/equipo_trabajo/default.png';
            }
            $data = [
                'nombre' => $validatedData['nombre'],
                'cargo' => $validatedData['cargo'],
                'imagen' => $imagenPath,
                'descripcion' => $validatedData['descripcion'],
                'facebook' => $validatedData['facebook'],
                'twitter' => $validatedData['twitter'],
                'linkedin' => $validatedData['linkedin'],
                'instagram' => $validatedData['instagram'],
                'youtube' => $validatedData['youtube'],
            ];


            $itemEquipo = new LandingItemEquipoTrabajo($data);
            $itemEquipo->save();

            if ($itemEquipo) {
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
        $equipoItem = LandingItemEquipoTrabajo::find($id);
        return response()->json($equipoItem, 200);
    }

    public function updateEquipo(Request $request)
    {
        //dd($request->all());
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'nombre' => 'string|max:255',
                'cargo' => 'string|max:255',
                'descripcion' => 'string|max:255',
                'facebook' => 'string|max:255',
                'twitter' => 'string|max:255',
                'linkedin' => 'string|max:255',
                'instagram' => 'string|max:255',
                'youtube' => 'string|max:255',
                'id_item_equipo' => 'integer',
            ]);
            $idEquipo = $validatedData['id_item_equipo'];
            $equipoItem = LandingItemEquipoTrabajo::find($idEquipo);

            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/equipo_trabajo/');

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
                    $imagenPath = 'front/img/equipo_trabajo/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = $equipoItem->imagen;
            }
            $equipoItem->nombre = $validatedData['nombre'];
            $equipoItem->cargo = $validatedData['cargo'];
            $equipoItem->imagen = $imagenPath;
            $equipoItem->descripcion = $validatedData['descripcion'];
            $equipoItem->facebook = $validatedData['facebook'];
            $equipoItem->twitter = $validatedData['twitter'];
            $equipoItem->linkedin = $validatedData['linkedin'];
            $equipoItem->instagram = $validatedData['instagram'];
            $equipoItem->youtube = $validatedData['youtube'];
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
        $equipoItem = LandingItemEquipoTrabajo::find($id);
        $equipoItem->estado = 0;
        $equipoItem->save();
        if ($equipoItem) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Item"], 500);
        }
    }
}

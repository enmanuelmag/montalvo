<?php

namespace App\Http\Controllers;

use App\Models\LandingClientes;
use App\Models\LandingClientesItems;
use Illuminate\Http\Request;

class LandingClientesController extends Controller
{
    //
    public function index()
    {
        $Title = 'Seccion Clientes';
        $modalTitle = 'Agregar Cliente';
        $tableTitle = 'Lista de Items';
        $landingClientes = LandingClientes::where('estado', 1)->first();
        return view('backend.clientes.clientes', compact('Title', 'landingClientes', 'modalTitle', 'tableTitle'));
    }

    public function update(Request $request)
    {
        $clienteSeccion = LandingClientes::findOrFail($request->id);
        $clienteSeccion->titulo = $request->titulo;

        $clienteSeccion->save();
        return response()->json(['success' => true, 'imagen_path' => 'Actualizado']);
    }

    public function datatableClientes()
    {

        try {
            $about = LandingClientesItems::where('estado', 1)->orderBy('id', 'asc')->get();
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
                'draw' => intval(request()->input('draw')), // Mismo draw que env赤a el datatables
                'recordsTotal' => $about->count(),
                'recordsFiltered' => $about->count(),
                'data' => $data
            ], 200);

            // return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurri車 un error al obtener los datos', 'message' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
                'titulo' => 'string|max:255',
            ]);
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $originalName = str_replace(' ', '_', $originalName); // Reemplaza espacios por guiones bajos

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/clientes/');

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
                    $imagenPath = 'front/img/clientes/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = 'front/img/clientes/default.png';
            }

            $itemCliente = new LandingClientesItems();
            $itemCliente->titulo = $request->titulo;
            $itemCliente->imagen = $imagenPath;
            $itemCliente->save();

            if ($itemCliente) {
                return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar el ITEM"], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validaci車n fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurri車 un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $equipoItem = LandingClientesItems::find($id);
        return response()->json($equipoItem, 200);
    }

    public function updateCliente(Request $request)
    {
        //dd($request->all());
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'titulo' => 'string|max:255',
                'id_item_cliente' => 'required|integer',
            ]);
            $idCliente = $validatedData['id_item_cliente'];
            $clienteItem = LandingClientesItems::find($idCliente);

            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

// Obtener el nombre original del archivo sin la extensi車n
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

// Reemplazar los espacios por guiones bajos o eliminarlos
                $originalName = str_replace(' ', '_', $originalName); // Reemplaza espacios por guiones bajos

// O bien, si prefieres eliminar los espacios directamente
// $originalName = str_replace(' ', '', $originalName);

                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $directoryPath = public_path('front/img/clientes/');

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
                    $imagenPath = 'front/img/clientes/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = $clienteItem->imagen;
            }
            $clienteItem->titulo = $validatedData['titulo'];
            $clienteItem->imagen = $imagenPath;

            $clienteItem->save();



            if ($clienteItem) {
                return response()->json(['success' => true, 'imagen_path' => $imagenPath]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar el ITEM"], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validaci車n fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurri車 un error al Actualizar la Red Social', 'message' => $e->getMessage()], 500);
        }
    }
    public function delete($id)
    {
        $equipoItem = LandingClientesItems::find($id);
        $equipoItem->estado = 0;
        $equipoItem->save();
        if ($equipoItem) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Item"], 500);
        }
    }
}

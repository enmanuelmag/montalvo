<?php

namespace App\Http\Controllers;

use App\Models\LandingCategoriasTrabajos;
use App\Models\LandingGaleriaTrabajos;
use App\Models\LandingItemGaleriaTrabajos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingGaleriaController extends Controller
{
    //
    public function indexGaleria()
    {
        $Title = 'Sección Galeria';
        $modalTitle = 'Agregar Item de la Galeria';
        $tableTitle = 'Lista de Items';
        $categorias = LandingCategoriasTrabajos::where('estado', 1)->get();
   
        $galeria = LandingGaleriaTrabajos::find(1);
        return view('backend.galeria.galeria', compact('categorias', 'galeria','Title', 'modalTitle', 'tableTitle'));
    }
    public function datatableGaleria(Request $request)
    {

        $itemsGaleria = DB::table('landing_items_galeria_trabajos')
            ->join('landing_categorias_trabajos', 'landing_items_galeria_trabajos.landing_categoria_trabajo_id', '=', 'landing_categorias_trabajos.id')
            ->where('landing_items_galeria_trabajos.estado', '=', 1)
            ->select('landing_items_galeria_trabajos.*', 'landing_categorias_trabajos.titulo as categoria_nombre')
            ->get();
       

        foreach ($itemsGaleria as $item) {
            $data[] = [
                'id' => $item->id,
                'titulo' => $item->titulo,
                'detalle' => $item->detalle,
                'imagen' => '<img src="'.asset($item->imagen).'" alt="Imagen" style="width: 50px; height: auto;">',
                'categoria' => $item->categoria_nombre,
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
            'recordsTotal' => $itemsGaleria->count(),
            'recordsFiltered' => $itemsGaleria->count(),
            'data' => $data
        ], 200);
    }
    public function updateGaleria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'subtitulo' => 'required|string|max:255',
                'detalle' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $galeria = LandingGaleriaTrabajos::find($validatedData['id']);
            $galeria->titulo = $validatedData['titulo'];
            $galeria->subtitulo = $validatedData['subtitulo'];
            $galeria->detalle = $validatedData['detalle'];
            $galeria->save();
            if ($galeria) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar la Galeria"], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }

    public function storeGaleriaItem(Request $request){
        try {
            $validatedData = $request->validate([
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'detalle' => 'required|string|max:255',
                'id_categoria' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
            ]);
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imagePath = public_path('front/img/galeria/' . $imageName);

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Guardar la imagen como PNG
                    if (!imageistruecolor($imgResource)) {
                        imagepalettetotruecolor($imgResource);
                    }

                    imagewebp($imgResource, $imagePath);
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/galeria/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
            } else {
                $imagenPath = 'front/img/galeria/default.png';
            }

            $data = [
                'titulo' => $validatedData['titulo'],
                'detalle' => $validatedData['detalle'],
                'imagen' => $imagenPath,
                'landing_categoria_trabajo_id' => $validatedData['id_categoria'],
            ];

            $itemGaleria = new LandingItemGaleriaTrabajos($data);
            $itemGaleria->save();

            if ($itemGaleria) {
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
    public function editGaleriaItem($id)
    {
        $item = LandingItemGaleriaTrabajos::find($id);
        return response()->json(['data' => $item]);
    }
    public function updateGaleriaItem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'detalle' => 'required|string|max:255',
                'id_categoria' => 'required|string|max:255',
                'titulo' => 'required|string|max:255',
                'id_item_galeria' => 'required|integer',
            ]);
            $item = LandingItemGaleriaTrabajos::find($validatedData['id_item_galeria']);
            $item->titulo = $validatedData['titulo'];
            $item->detalle = $validatedData['detalle'];
            $item->landing_categoria_trabajo_id = $validatedData['id_categoria'];
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');

                // Obtener el nombre original del archivo sin la extensión
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = date('Ymd_His') . '_' . substr(microtime(), 2, 6);
                $imageName = $originalName . '_' . $timestamp . '.webp';
                $imagePath = public_path('front/img/galeria/' . $imageName);

                // Crear una imagen desde el archivo subido
                $imgResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imgResource) {
                    // Guardar la imagen como PNG
                    imagewebp($imgResource, $imagePath);
                    imagedestroy($imgResource);
                    $imagenPath = 'front/img/galeria/' . $imageName;

                } else {
                    throw new \Exception('Error al crear la imagen desde el archivo.');
                }
                $item->imagen = $imagenPath;
            }
            $item->save();
            if ($item) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar el ITEM"], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return
            response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }

    public function indexCategorias()
    {
        $Title = 'Sección Galeria';
        $tableTitle = 'Lista de Items';
        $modalTitle = 'Agregar Categoria de la Galeria';
        return view('backend.galeria.categorias', compact('Title', 'tableTitle','modalTitle'));
    }
    public function datatableCategoia(Request $request)
    {
        $nav = LandingCategoriasTrabajos::where('estado', '=', 1)->get();
        $data = [];
        foreach ($nav as $redSocial) {
            $data[] = [
                'id' => $redSocial->id,
                'titulo' => $redSocial->titulo,
                'estado' => $redSocial->estado == 1 ? 'Activo' : 'Inactivo',
                'actions' => '
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-sm btn-primary me-2" onclick="openEditModal(' . $redSocial->id . ')">
                            <i data-feather="edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger me-2" onclick="deleteNavItem(' . $redSocial->id . ')">
                            <i data-feather="x-circle"></i>
                        </button>
                    </div>
                ',
            ];
        }

        return response()->json(['data' => $data]);
    }
    public function saveCategoria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
            ]);
            $data = [
                'titulo' => $validatedData['titulo'],
                'subtitulo' => '',
            ];
            $categoria = new LandingCategoriasTrabajos($data);
            $categoria->save();
            if ($categoria) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar la Categoria"], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }
    public function updateCategoria(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'titulo' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $categoria = LandingCategoriasTrabajos::find($validatedData['id']);
            $categoria->titulo = $validatedData['titulo'];
            $categoria->save();
            if ($categoria) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => "Error al Guardar la Categoria"], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }
    public function editCategoria($id)
    {
        $categoria = LandingCategoriasTrabajos::find($id);
        return response()->json(['data' => $categoria]);
    }
    public function destroyCategoria($id)
    {
        $categoria = LandingCategoriasTrabajos::find($id);
        $categoria->estado = 0;
        $categoria->save();
        if ($categoria) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Categoria"], 500);
        }
    }
    
     public function destroyItemGaleria($id)
    {
        $categoria = LandingItemGaleriaTrabajos::find($id);
        $categoria->estado = 0;
        $categoria->save();
        if ($categoria) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => "Error al Eliminar la Item"], 500);
        }
    }
}

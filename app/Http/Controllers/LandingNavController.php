<?php

namespace App\Http\Controllers;

use App\Models\LandingNav;
use Illuminate\Http\Request;

class LandingNavController extends Controller
{
    //
    public function index()
    {
        $topBarTitle = 'Menú Principal';
        $tableTitle = 'Menú Principal';
        $modalTitle = 'Agregar Menú Principal';
        return view('backend.nav.nav', compact('topBarTitle', 'tableTitle', 'modalTitle'));
    }
    public function datatable(Request $request)
    {
        $nav = LandingNav::where('estado', '=', 1)->get();
        return response()->json(['data' => $nav]);
    }
    public function getNavDatatable()
    {
        try {
            $menus = LandingNav::where('estado', '=', 1)->get();

            $data = [];
            foreach ($menus as $redSocial) {
                $data[] = [
                    'id' => $redSocial->id,
                    'nombre_menu' => $redSocial->nombre_menu,
                    'ruta' => $redSocial->ruta,
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

            return response()->json(['data' => $data], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al obtener las redes sociales', 'message' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_menu' => 'required|string|max:255',
                'ruta' => 'required|string|max:255',
            ]);

            $data = [
                'nombre_menu' => $validatedData['nombre_menu'],
                'ruta' => $validatedData['ruta'],
                'icono' => '--',
            ];

            $navMenu = LandingNav::create($data);

            return response()->json($navMenu, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre_menu' => 'required|string|max:255',
                'ruta' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $idNav = $validatedData['id'];
            $data = [
                'nombre_menu' => $validatedData['nombre_menu'],
                'ruta' => $validatedData['ruta'],
            ];

            $nav = LandingNav::find($idNav);
            $nav->update($data);


            return response()->json($nav, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al Actualizar', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $nav = LandingNav::find($id);
        $nav->delete();
        return response()->json(['message' => 'Item eliminado correctamente'], 200);
    }
    public function edit($id)
    {
        $nav = LandingNav::find($id);
        return response()->json($nav, 200);
    
    }
    public function ordenamiento(Request $request)
    {
        $orderedItems = $request->input('orderedItems');
        foreach ($orderedItems as $item) {
            // Suponiendo que tienes un modelo llamado `User` o algún otro modelo relacionado
            LandingNav::where('id', $item['id'])->update(['ordenamiento' => $item['order']]);

        }
        return response()->json(['message' => 'Orden actualizado correctamente']);

    }
}


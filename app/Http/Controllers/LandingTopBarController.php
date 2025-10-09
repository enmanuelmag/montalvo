<?php

namespace App\Http\Controllers;

use App\Models\LandingTopBar;
use Illuminate\Http\Request;

class LandingTopBarController extends Controller
{
    //
    public function index()
    {
        $topBarTitle = 'Redes Sociales';
        return view('backend.top_bar.top_bar', compact('topBarTitle'));
    }
    public function datatable(Request $request)
    {
        $topBar = LandingTopBar::where('estado', '=', 1)->get();
        return response()->json(['data' => $topBar]);
    }
    public function getRedesSociales()
    {
        try {
            $redesSociales = LandingTopBar::where('estado', '=', 1)->get();

            $data = [];
            foreach ($redesSociales as $redSocial) {
                $data[] = [
                    'id' => $redSocial->id,
                    'name' => $redSocial->name,
                    'url' => $redSocial->url,
                    'icon' => '<i data-feather="'.strtolower($this->getWordBeforeCom($redSocial->url)).'">',
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
                'name' => 'required|string|max:255',
                'link' => 'required|url',
                'icon' => 'required|string|max:255',
            ]);

            $data = [
                'name' => $validatedData['name'],
                'url' => $validatedData['link'],
                'icon' => $validatedData['icon'],
            ];

            $redSocial = LandingTopBar::create($data);

            return response()->json($redSocial, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar la red social', 'message' => $e->getMessage()], 500);
        }
    }

     public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'string|max:255',
                'link' => 'string|max:255',
                'icono_red_social' => 'string|max:255',
                'id' => 'required|integer',
            ]);
            $idNav = $validatedData['id'];
            $data = [
                'name' => $validatedData['nombre'],
                'url' => $validatedData['link'],
                'icon' => $validatedData['icono_red_social'],
            ];

            $redSocial = LandingTopBar::find($idNav);
            $redSocial->update($data);


            return response()->json($redSocial, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al Actualizar la Red Social', 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $landingGeneral = LandingTopBar::find($id);
        return response()->json([
            'draw' => intval(request()->input('draw')), // Mismo draw que envía el datatables
            'recordsTotal' => $landingGeneral->count(),
            'recordsFiltered' => $landingGeneral->count(),
            'data' => $landingGeneral
        ], 200);
    }


    public function delete($id)
    {
        $landingGeneral = LandingTopBar::find($id);
        $landingGeneral->delete();
        return response()->json(['message' => 'Item eliminado correctamente'], 200);
    }

    function getWordBeforeCom($url) {
        // Eliminar 'http://' o 'https://' si están presentes
        $url = str_replace(['http://', 'https://'], '', $url);

        // Dividir la URL por '.com' y tomar la primera parte
        $parts = explode('.com', $url);

        if (count($parts) > 1) {
            // Tomar la parte antes de '.com' y dividirla por '/'
            $subParts = explode('/', $parts[0]);
            // Tomar la última parte antes de '/'
            $lastPart = end($subParts);

            // Dividir la última parte por '.'
            $subParts = explode('.', $lastPart);
            // Tomar la última parte antes de '.'
            return end($subParts);
        }

        return null; // Si no hay '.com' en la URL
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\LandingServices;
use App\Models\LandingServicesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class LandingServicesController extends Controller
{
    //
    public function index()
    {
        $Title = 'Sección Servicios';
        $modalTitle = 'Agregar Servicios';
        $tableTitle = 'Lista de Items';
        $landingServices = LandingServices::where('estado', 1)->first();
        return view('backend.services.services', compact('Title', 'modalTitle','tableTitle', 'landingServices'));
    }
    public function getServicesDatatable()
    {

        try {
            $about = LandingServicesItem::where('estado', 1)->orderBy('id', 'asc')->get();
            $data = [];
            foreach ($about as $item) {
                $data[] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'icon' => '  <i class="fas '.$item->icon.' fa-2x text-primary"></i>',
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
    public function update(Request $request) {
      
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'boton_text' => 'required|string|max:255',
            'boton_link' => 'required|string|max:255',
            'id' => 'required|integer'
        ]);
        $id = $validatedData['id'];


        try {
            // Buscar el registro existente
            $services = LandingServices::findOrFail($id);
            // Actualizar el registro con los nuevos datos
            $services->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'btn_text' => $validatedData['boton_text'],
                'btn_link' => $validatedData['boton_link'],
            ]);

            return response()->json(['success' => true, 'message' => 'Sección actualizada correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Error in updateAbout method: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
    public function storeItem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'icon' => 'required|string|max:255',
            ]);

            $data = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'icon' => $validatedData['icon'],
            ];

            $about = LandingServicesItem::create($data);

            return response()->json($about, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al guardar la el Items', 'message' => $e->getMessage()], 500);
        }
    }

    public function editItem($id)
    {
        $nav = LandingServicesItem::find($id);
        return response()->json($nav, 200);
    }

    public function updateItem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'icon' => 'required|string|max:255',
                'id' => 'required|integer',
            ]);
            $idService = $validatedData['id'];
            $data = [
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'icon' => $validatedData['icon'],
            ];

            $about = LandingServicesItem::findOrFail($idService);
            $about->update($data);

            return response()->json($about, 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validación fallida', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al Actualizar el Item', 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteItem($id)
    {
        $nav = LandingServicesItem::find($id);
        $nav->delete();
        return response()->json(['message' => 'Item eliminado correctamente'], 200);
    }
    public function servicesLanding()
    {
        $services = LandingServices::where('id', 1)->first();
        $services_items = LandingServicesItem::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('landing/components/servicios_landing', compact('services', 'services_items'));
    }
    
}

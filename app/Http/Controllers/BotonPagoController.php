<?php

namespace App\Http\Controllers;

use App\Models\BotonPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BotonPagoController extends Controller
{
    public function index()
    {
        $botonesPago = BotonPago::all();
        return view('boton-pagos.index', compact('botonesPago'));
    }

    public function create()
    {
        return view('boton-pagos.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre_proveedor' => 'required|string|max:255',
            'boton_pago_detalle' => 'required|string|max:255',
            'esta_activo' => 'boolean',
        ];

        // Agregar reglas específicas según el proveedor
        switch ($request->nombre_proveedor) {
            case 'TRANSFERENCIA':
                $rules = array_merge($rules, [
                    'configuracion_adicional.banco' => 'required|string',
                    'configuracion_adicional.tipo_cuenta' => 'required|string',
                    'configuracion_adicional.numero_cuenta' => 'required|string',
                    'configuracion_adicional.titular' => 'required|string',
                    'configuracion_adicional.identificacion_titular' => 'required|string',
                ]);
                break;

            case 'PAYPAL':
                $rules = array_merge($rules, [
                    'usuario_boton_pago' => 'required|string',
                    'clave_boton_pago_paypal' => 'required|string',
                    'url_boton_pago' => 'required|url',
                ]);
                break;

            case 'PAYPHONE':
                $rules = array_merge($rules, [
                    'token_boton_pago' => 'required|string',
                    'key_boton_pago' => 'required|string',
                    'url_boton_pago' => 'required|url',
                ]);
                break;
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $botonPago = new BotonPago();
            $botonPago->nombre_proveedor = $request->nombre_proveedor;
            $botonPago->boton_pago_detalle = $request->boton_pago_detalle;
            $botonPago->esta_activo = $request->esta_activo ?? true;

            // Configuración específica según el proveedor
            switch ($request->nombre_proveedor) {
                case 'TRANSFERENCIA':
                    $botonPago->configuracion_adicional = [
                        'banco' => $request->input('configuracion_adicional.banco'),
                        'tipo_cuenta' => $request->input('configuracion_adicional.tipo_cuenta'),
                        'numero_cuenta' => $request->input('configuracion_adicional.numero_cuenta'),
                        'titular' => $request->input('configuracion_adicional.titular'),
                        'identificacion_titular' => $request->input('configuracion_adicional.identificacion_titular'),
                        'instrucciones' => $request->input('configuracion_adicional.instrucciones'),
                    ];
                    break;

                case 'PAYPAL':
                    $botonPago->usuario_boton_pago = $request->usuario_boton_pago;
                    $botonPago->clave_boton_pago = $request->clave_boton_pago_paypal;
                    $botonPago->url_boton_pago = $request->url_boton_pago;
                    break;

                case 'PAYPHONE':
                    $botonPago->token_boton_pago = $request->token_boton_pago;
                    $botonPago->key_boton_pago = $request->key_boton_pago;
                    $botonPago->url_boton_pago = $request->url_boton_pago;
                    break;
            }

            $botonPago->save();

            return redirect()
                ->route('boton-pagos.index')
                ->with('success', 'Método de pago registrado exitosamente');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al registrar el método de pago: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(BotonPago $botonPago)
    {

        if (!empty($botonPago->configuracion_adicional) && is_string($botonPago->configuracion_adicional)) {
            $decoded = json_decode($botonPago->configuracion_adicional, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $botonPago->configuracion_adicional = $decoded;
            } else {
                Log::error('Error al decodificar JSON en configuracion_adicional: ' . json_last_error_msg());
                $botonPago->configuracion_adicional = []; // Evitar errores asignando un array vacío
            }
        }
        return view('boton-pagos.edit', compact('botonPago'));
    }

    public function update(Request $request, BotonPago $botonPago)
    {
        $validator = Validator::make($request->all(), [
            'boton_pago_detalle' => 'required|string|max:255',
            'esta_activo' => 'boolean',
        ]);

        // Añadir reglas según el tipo de proveedor
        switch ($botonPago->nombre_proveedor) {
            case 'TRANSFERENCIA':
                $validator->addRules([
                    'configuracion_adicional.banco' => 'required|string',
                    'configuracion_adicional.tipo_cuenta' => 'required|string',
                    'configuracion_adicional.numero_cuenta' => 'required|string',
                    'configuracion_adicional.titular' => 'required|string',
                    'configuracion_adicional.identificacion_titular' => 'required|string',
                ]);
                break;

            case 'PAYPAL':
                $validator->addRules([
                    'usuario_boton_pago' => 'required|string',
                    'url_boton_pago' => 'required|url',
                ]);
                break;

            case 'PAYPHONE':
                $validator->addRules([
                    'token_boton_pago' => 'required|string',
                    'url_boton_pago' => 'required|url',
                ]);
                break;
        }

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $botonPago->boton_pago_detalle = $request->boton_pago_detalle;
            $botonPago->esta_activo = $request->esta_activo ?? $botonPago->esta_activo;

            switch ($botonPago->nombre_proveedor) {
                case 'TRANSFERENCIA':
                    $botonPago->configuracion_adicional = [
                        'banco' => $request->input('configuracion_adicional.banco'),
                        'tipo_cuenta' => $request->input('configuracion_adicional.tipo_cuenta'),
                        'numero_cuenta' => $request->input('configuracion_adicional.numero_cuenta'),
                        'titular' => $request->input('configuracion_adicional.titular'),
                        'identificacion_titular' => $request->input('configuracion_adicional.identificacion_titular'),
                        'instrucciones' => $request->input('configuracion_adicional.instrucciones'),
                    ];
                    break;

                case 'PAYPAL':
                    $botonPago->usuario_boton_pago = $request->usuario_boton_pago;
                    if ($request->filled('clave_boton_pago')) {
                        $botonPago->clave_boton_pago = $request->clave_boton_pago;
                    }
                    $botonPago->url_boton_pago = $request->url_boton_pago;
                    break;

                case 'PAYPHONE':
                    $botonPago->token_boton_pago = $request->token_boton_pago;
                    $botonPago->key_boton_pago = $request->key_boton_pago;
                    if ($request->filled('clave_boton_pago')) {
                        $botonPago->clave_boton_pago = $request->clave_boton_pago;
                    }
                    $botonPago->url_boton_pago = $request->url_boton_pago;
                    break;
            }

            $botonPago->save();

            return redirect()
                ->route('boton-pagos.index')
                ->with('success', 'Método de pago actualizado exitosamente');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el método de pago: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(BotonPago $botonPago)
    {
        try {
            $botonPago->delete();
            return redirect()
                ->route('boton-pagos.index')
                ->with('success', 'Método de pago eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el método de pago: ' . $e->getMessage());
        }
    }

    public function toggle(BotonPago $botonPago)
    {
        try {
            $botonPago->esta_activo = !$botonPago->esta_activo;
            $botonPago->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'esta_activo' => $botonPago->esta_activo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerConfiguracion(BotonPago $botonPago)
    {
        return response()->json([
            'success' => true,
            'data' => $botonPago->configuracion_adicional
        ]);
    }
}
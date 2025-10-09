<?php

namespace App\Http\Controllers;

use App\Models\PagosEfectuados;
use App\Models\BotonPago;
use App\Models\LandingCursosDetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\MoodleController;
use App\Mail\ConfirmacionMatriculaMoodle;

class PagoController extends Controller
{
   public function index()
{
    $pagos = PagosEfectuados::with('botonPago')
                ->orderBy('fecha_pago', 'desc') // o 'asc' si quieres de más antiguos a más recientes
                ->get();

    return view('pagos.index', compact('pagos'));
}

    public function create()
    {
        $botonesPago = BotonPago::where('esta_activo', true)->get();
        return view('pagos.create', compact('botonesPago'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identificacion' => 'nullable|string|max:20',
            'cliente' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'boton_pago_id' => 'required|exists:boton_pagos,id',
            'curso_id' => 'required|integer',
            'curso_nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tipo_pago' => 'required|in:TRANSFERENCIA,PAYPAL,PAYPHONE'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
      $pago = new PagosEfectuados();
        $pago->identificacion = $request->identificacion;
        $pago->cliente = $request->cliente;
        $pago->correo = $request->correo;
        $pago->telefono = $request->telefono;
        $pago->boton_pago_id = $request->boton_pago_id;
        $pago->referencia = $this->generarReferencia();
        $pago->fecha_pago = Carbon::now();
        $pago->curso_id = $request->curso_id;
        $pago->curso_nombre = $request->curso_nombre;
        $pago->valor = $request->valor;
        $pago->descripcion = $request->descripcion;
        $pago->estado = 'PENDIENTE DE CARGA COMPROBANTE';
        $pago->tipo_pago = $request->tipo_pago;
        
        // ✅ Nuevos campos con valor por defecto si están vacíos
        $pago->ciudad = $request->filled('ciudad') ? $request->ciudad : 'Quito';
        $pago->direccion = $request->filled('direccion') ? $request->direccion : 'S/N';
        
        $pago->save();

            // Redireccionar según el tipo de pago
            switch ($pago->tipo_pago) {
                case 'TRANSFERENCIA':
                    return redirect()->route('pagos.transferencia', $pago);
                case 'PAYPAL':
                    return redirect()->route('pagos.paypal.process', $pago);
                case 'PAYPHONE':
                    return redirect()->route('pagos.payphone.process', $pago);
                default:
                    return redirect()
                        ->route('pagos.show', $pago)
                        ->with('success', 'Pago registrado exitosamente');
            }

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al registrar el pago: ' . $e->getMessage())
                ->withInput();
        }
    }

public function show($id)
{
    $pago = PagosEfectuados::findOrFail($id);
    return view('pagos.show', compact('pago'));
}

    public function anularPago(Request $request, $id)
    {
        $pago = PagosEfectuados::findOrFail($id);

        // Validar que el pago esté en estado PENDIENTE
     

        // Actualizar el estado y guardar el motivo
        $pago->estado = 'FALLIDO';
        $pago->respuesta_proveedor = array_merge(
            $pago->respuesta_proveedor ?? [],
            [
                'motivo_anulacion' => $request->motivo,
                'fecha_anulacion' => now()->format('Y-m-d H:i:s'),
                'usuario_anulacion' => auth()->user()->name
            ]
        );

        try {
            $pago->save();

            // Enviar correo de notificación
            /* Descomentar cuando se implemente el correo
            Mail::to($pago->correo)->send(new PagoAnulado($pago));
            */

            return response()->json([
                'success' => true,
                'message' => 'Pago anulado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al anular el pago'
            ], 500);
        }
    }
    public function actualizarEstado(PagosEfectuados $pago, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:PENDIENTE,COMPLETADO,FALLIDO,REEMBOLSADO,PENDIENTE DE CARGA COMPROBANTE,PENDIENTE DE VERIFICACION',
            'respuesta_proveedor' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pago->estado = $request->estado;
            if ($request->has('respuesta_proveedor')) {
                $pago->respuesta_proveedor = $request->respuesta_proveedor;
            }
            $pago->save();

            // Si el pago está completado y aún no está registrado en Moodle
            if ($pago->estado === 'COMPLETADO' && !$pago->registrado_moodle) {
                // Aquí iría la lógica para registrar en Moodle
                // $this->registrarEnMoodle($pago);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'pago' => $pago
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function generarReferencia()
    {
        $referencia = strtoupper(Str::random(8));

        // Verificar que la referencia sea única
        while (PagosEfectuados::where('referencia', $referencia)->exists()) {
            $referencia = strtoupper(Str::random(8));
        }

        return $referencia;
    }

    public function filtrar(Request $request)
    {
        $query = PagosEfectuados::with('botonPago');

        if ($request->fecha_inicio) {
            $query->where('fecha_pago', '>=', Carbon::parse($request->fecha_inicio)->startOfDay());
        }

        if ($request->fecha_fin) {
            $query->where('fecha_pago', '<=', Carbon::parse($request->fecha_fin)->endOfDay());
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->tipo_pago) {
            $query->where('tipo_pago', $request->tipo_pago);
        }

        $pagos = $query->get();

        return response()->json([
            'success' => true,
            'data' => $pagos
        ]);
    }
public function listar()
{
       $pagos = PagosEfectuados::with('botonPago')
                ->orderBy('fecha_pago', 'desc') // o 'asc' si quieres de más antiguos a más recientes
                ->get();
    return response()->json(['data' => $pagos]);
}
    public function exportar(Request $request)
    {
        // Aquí iría la lógica para exportar pagos
        // Se implementará en una próxima iteración
    }
    public function procesarPagoMoodle($id_pago)
{
    // 1. Buscar el pago
    $pago = PagosEfectuados::findOrFail($id_pago);
    $moodle_curso = LandingCursosDetalles::findOrFail($pago->curso_id);
    // 2. Generar datos necesarios para Moodle
    $nombreCompleto = explode(' ', $pago->cliente, 2);
    $firstname = $nombreCompleto[0] ?? 'Nombre';
    $lastname = $nombreCompleto[1] ?? 'Apellido';
    $password = 'Mont2024!' . rand(100, 999);  // cumple todos los requisitos
    $datosMoodle = new Request([
        'username' => $pago->identificacion, // o puedes usar algo como: Str::slug($pago->cliente) . rand(100,999)
        'password' => $password, // o Str::random(12)
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $pago->correo,
        'course_id' => $moodle_curso->lugar,
    ]);

    // 3. Llamar al controlador de Moodle
    $moodle = new MoodleController();
    $resultado = $moodle->crearYMatricular($datosMoodle);

    // 4. Guardar info de Moodle si todo salió bien
    $body = $resultado->getData(true);

    if (isset($body['usuario']['id'])) {
        $pago->registrado_moodle = true;
        $pago->moodle_user_id = $body['usuario']['id'];
        $pago->fecha_registro_moodle = now();
        
        // 👇 aquí inyectamos la contraseña en los datos guardados
        $body['password'] = $password;
        $pago->datos_moodle = $body;
    
        $matriculado = $body['matricula']['status'] === 'matriculado' || $body['matricula']['status'] === 'ya_matriculado';
        $pago->matriculado_moodle = $matriculado;
        $pago->save();
    
        if ($matriculado) {
            Mail::to($pago->correo)->send(new ConfirmacionMatriculaMoodle($pago));
        }
    }

    return response()->json([
        'status' => 'ok',
        'moodle' => $body
    ]);
}

}
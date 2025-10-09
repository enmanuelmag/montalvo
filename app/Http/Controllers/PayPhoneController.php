<?php

namespace App\Http\Controllers;

use App\Models\PagosEfectuados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayPhoneController extends Controller
{
    public function iniciarPago(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->boton_pago_id;

            // Preparar los datos para PayPhone
            $data = [
                "phoneNumber" => "593".substr($pago->telefono, 1), // Convertir formato: 0991234567 -> 593991234567
                "countryCode" => "EC",
                "clientUserId" => $botonPago->key_boton_pago,
                "reference" => $pago->referencia,
                "responseUrl" => $botonPago->configuracion_adicional['url_respuesta'],
                "amount" => intval($pago->valor * 100), // PayPhone requiere el monto en centavos
                "amountWithTax" => intval($pago->valor * 100),
                "amountWithoutTax" => 0,
                "tax" => 0,
                "clientTransactionId" => $pago->id,
                "currency" => "USD",
                "language" => "es",
                "expirationTime" => strtotime("+1 hour"), // Tiempo de expiración del pago: 1 hora
                "storeId" => null,
                "documentId" => $pago->identificacion ?? '',
                "email" => $pago->correo,
                "concepts" => [
                    [
                        "amount" => intval($pago->valor * 100),
                        "description" => "Pago del curso: " . $pago->curso_nombre
                    ]
                ]
            ];

            // Realizar petición a PayPhone
            $response = Http::withHeaders([
                'Authorization' => $botonPago->token_boton_pago,
                'Content-Type' => 'application/json'
            ])->post($botonPago->url_boton_pago . 'button/api/button/V2/Generate', $data);

            if ($response->successful()) {
                $responseData = $response->json();

                // Guardar la respuesta en el pago
                $pago->respuesta_proveedor = [
                    'payphone_request' => $data,
                    'payphone_response' => $responseData,
                    'transaction_id' => $responseData['transactionId'] ?? null,
                ];
                $pago->save();

                // Redireccionar al botón de pago de PayPhone
                return redirect($responseData['payWithPayPhone']);
            } else {
                // Manejar error de PayPhone
                $errorData = $response->json();
                throw new \Exception('Error de PayPhone: ' . ($errorData['message'] ?? 'Error desconocido'));
            }

        } catch (\Exception $e) {
            // Actualizar estado del pago
            $pago->estado = 'FALLIDO';
            $pago->respuesta_proveedor = [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ];
            $pago->save();

            // Redireccionar con error
            return redirect()->route('pagos.publico.error', $pago)
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    public function confirmarPago(Request $request)
    {
        // Validar la firma del webhook
        if (!$this->validarFirma($request)) {
            return response()->json(['error' => 'Firma inválida'], 400);
        }

        $transactionId = $request->input('id');
        $clientTransactionId = $request->input('clientTransactionId');

        // Buscar el pago
        $pago = PagosEfectuado::find($clientTransactionId);
        if (!$pago) {
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }

        try {
            // Verificar el estado del pago con PayPhone
            $botonPago = $pago->botonPago;
            $response = Http::withHeaders([
                'Authorization' => $botonPago->token_boton_pago
            ])->get($botonPago->url_boton_pago . "api/button/V2/Confirm/{$transactionId}");

            if ($response->successful()) {
                $responseData = $response->json();

                // Actualizar el estado del pago según la respuesta
                $pago->estado = $responseData['transactionStatus'] === 'Approved' ? 'COMPLETADO' : 'FALLIDO';
                $pago->respuesta_proveedor = array_merge(
                    $pago->respuesta_proveedor ?? [],
                    ['confirmacion' => $responseData]
                );
                $pago->save();

                // Si el pago fue exitoso y aún no está registrado en Moodle
                if ($pago->estado === 'COMPLETADO' && !$pago->registrado_moodle) {
                    // Aquí iría la lógica para registrar en Moodle
                    // $this->registrarEnMoodle($pago);
                }

                return response()->json(['success' => true]);
            } else {
                throw new \Exception('Error al confirmar con PayPhone');
            }

        } catch (\Exception $e) {
            // Registrar el error
            $pago->estado = 'FALLIDO';
            $pago->respuesta_proveedor = array_merge(
                $pago->respuesta_proveedor ?? [],
                ['error_confirmacion' => $e->getMessage()]
            );
            $pago->save();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function validarFirma(Request $request)
    {
        // Implementar la validación de la firma según la documentación de PayPhone
        // Esta es una implementación básica, ajustar según los requerimientos de seguridad
        return true;
    }
}
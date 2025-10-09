<?php

namespace App\Http\Controllers;

use App\Models\PagosEfectuados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPhoneController extends Controller
{
    public function iniciarPago(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->boton_pago_id;

            // Preparar los datos para PayPhone
            $data = [
                "phoneNumber" => "593" . substr($pago->telefono, 1), // Convertir formato: 0991234567 -> 593991234567
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
        Log::channel('payphone')->info('PayPhone Webhook recibido', [
            'request_data' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Validar la firma del webhook
        if (!$this->validarFirma($request)) {
            Log::channel('payphone')->error('PayPhone Webhook firma inválida', [
                'request_data' => $request->all()
            ]);
            return response()->json(['error' => 'Firma inválida'], 400);
        }

        $transactionId = $request->input('id');
        $clientTransactionId = $request->input('clientTransactionId');

        Log::channel('payphone')->info('PayPhone Webhook procesando', [
            'transaction_id' => $transactionId,
            'client_transaction_id' => $clientTransactionId
        ]);

        // Buscar el pago
        $pago = PagosEfectuados::find($clientTransactionId);
        if (!$pago) {
            Log::channel('payphone')->error('PayPhone Webhook pago no encontrado', [
                'client_transaction_id' => $clientTransactionId,
                'transaction_id' => $transactionId
            ]);
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }

        try {
            // Verificar el estado del pago con PayPhone
            $botonPago = $pago->botonPago;

            Log::channel('payphone')->info('PayPhone verificando estado desde webhook', [
                'pago_id' => $pago->id,
                'transaction_id' => $transactionId,
                'endpoint' => $botonPago->url_boton_pago . "api/button/V2/Confirm/{$transactionId}"
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $botonPago->token_boton_pago
            ])->get($botonPago->url_boton_pago . "api/button/V2/Confirm/{$transactionId}");

            Log::channel('payphone')->info('PayPhone confirmación response', [
                'pago_id' => $pago->id,
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'response_json' => $response->json(),
                'is_successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                $estadoAnterior = $pago->estado;
                $nuevoEstado = $responseData['transactionStatus'] === 'Approved' ? 'COMPLETADO' : 'FALLIDO';

                // Actualizar el estado del pago según la respuesta
                $pago->estado = $nuevoEstado;
                $pago->respuesta_proveedor = array_merge(
                    $pago->respuesta_proveedor ?? [],
                    [
                        'webhook_data' => $request->all(),
                        'confirmacion' => $responseData,
                        'webhook_processed_at' => now()->toDateTimeString()
                    ]
                );
                $pago->save();

                Log::channel('payphone')->info('PayPhone webhook procesado exitosamente', [
                    'pago_id' => $pago->id,
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo' => $nuevoEstado,
                    'transaction_status' => $responseData['transactionStatus'] ?? 'No disponible'
                ]);

                // Si el pago fue exitoso y aún no está registrado en Moodle
                if ($pago->estado === 'COMPLETADO' && !$pago->registrado_moodle) {
                    Log::channel('payphone')->info('PayPhone pago completado, pendiente registro Moodle', [
                        'pago_id' => $pago->id
                    ]);
                    // Aquí iría la lógica para registrar en Moodle
                    // $this->registrarEnMoodle($pago);
                }

                return response()->json(['success' => true]);
            } else {
                throw new \Exception('Error al confirmar con PayPhone: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::channel('payphone')->error('Error en PayPhone webhook', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'pago_id' => $pago->id,
                'transaction_id' => $transactionId,
                'trace' => $e->getTraceAsString()
            ]);

            // Registrar el error
            $pago->estado = 'FALLIDO';
            $pago->respuesta_proveedor = array_merge(
                $pago->respuesta_proveedor ?? [],
                [
                    'webhook_error' => $e->getMessage(),
                    'webhook_error_at' => now()->toDateTimeString()
                ]
            );
            $pago->save();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //         $response = Http::withHeaders([
    //             'Authorization' => $botonPago->token_boton_pago
    //         ])->get($botonPago->url_boton_pago . "api/button/V2/Confirm/{$transactionId}");

    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             // Actualizar el estado del pago según la respuesta
    //             $pago->estado = $responseData['transactionStatus'] === 'Approved' ? 'COMPLETADO' : 'FALLIDO';
    //             $pago->respuesta_proveedor = array_merge(
    //                 $pago->respuesta_proveedor ?? [],
    //                 ['confirmacion' => $responseData]
    //             );
    //             $pago->save();

    //             // Si el pago fue exitoso y aún no está registrado en Moodle
    //             if ($pago->estado === 'COMPLETADO' && !$pago->registrado_moodle) {
    //                 // Aquí iría la lógica para registrar en Moodle
    //                 // $this->registrarEnMoodle($pago);
    //             }

    //             return response()->json(['success' => true]);
    //         } else {
    //             throw new \Exception('Error al confirmar con PayPhone');
    //         }

    //     } catch (\Exception $e) {
    //         // Registrar el error
    //         $pago->estado = 'FALLIDO';
    //         $pago->respuesta_proveedor = array_merge(
    //             $pago->respuesta_proveedor ?? [],
    //             ['error_confirmacion' => $e->getMessage()]
    //         );
    //         $pago->save();

    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    protected function validarFirma(Request $request)
    {
        // Implementar la validación de la firma según la documentación de PayPhone
        // Esta es una implementación básica, ajustar según los requerimientos de seguridad
        return true;
    }
}

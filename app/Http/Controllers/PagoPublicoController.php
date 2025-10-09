<?php

namespace App\Http\Controllers;

use App\Models\LandingCursosDetalles;
use App\Models\PagosEfectuados;
use App\Models\BotonPago;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http; // Añadimos esta línea


class PagoPublicoController extends Controller
{
    /**
     * Muestra el formulario de pago inicial
     */
    public function iniciarPago($cursoId)
    {
        //dd($cursoId);
        // Aquí deberías obtener los datos del curso desde tu modelo de Curso
        $curso = LandingCursosDetalles::find($cursoId);

        if (!$curso) {
            return redirect()->back()->with('error', 'Curso no encontrado');
        }

        // Obtener métodos de pago activos
        $botonesPago = BotonPago::where('esta_activo', true)->get();

        return view('pagos.publico.iniciar', compact('botonesPago', 'curso'));
    }

    /**
     * Procesa el formulario de pago y redirecciona según el método seleccionado
     */
    public function procesarPago(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'identificacion' => 'nullable|string|max:20',
            'cliente' => 'required|string|max:255',
            'correo' => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'boton_pago_id' => 'required|exists:boton_pagos,id',
            'curso_id' => 'required|integer',
            'curso_nombre' => 'required|string',
            'valor' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $botonPago = BotonPago::findOrFail($request->boton_pago_id);

     $pago = PagosEfectuados::create([
        'identificacion' => $request->identificacion,
        'cliente' => $request->cliente,
        'correo' => $request->correo,
        'telefono' => $request->telefono,
        'boton_pago_id' => $request->boton_pago_id,
        'referencia' => $this->generarReferencia(),
        'fecha_pago' => Carbon::now(),
        'curso_id' => $request->curso_id,
        'curso_nombre' => $request->curso_nombre,
        'valor' => $request->valor,
        'estado' => 'PENDIENTE DE CARGA COMPROBANTE',
        'tipo_pago' => $botonPago->nombre_proveedor,
    
        // ✅ Nuevos campos con valores por defecto
        'ciudad' => $request->ciudad ?: 'Quito',
        'direccion' => $request->direccion ?: 'S/N'
    ]);
       // dd($botonPago);
        // Redireccionar según el método de pago
        switch ($botonPago->nombre_proveedor) {
            case 'TRANSFERENCIA':
                return $this->mostrarInstruccionesTransferencia($pago);

            case 'PAYPAL':
                return $this->iniciarPagoPaypal($pago);

            case 'PAYPHONE':
                return $this->iniciarPagoPayphone($pago);

            default:
                return redirect()->back()->with('error', 'Método de pago no soportado');
        }
    }

    /**
     * Muestra las instrucciones para transferencia bancaria
     */
    protected function mostrarInstruccionesTransferencia(PagosEfectuados $pago)
    {
        $datosBancarios = $pago->botonPago->configuracion_adicional;

        return view('pagos.publico.transferencia', compact('pago', 'datosBancarios'));
    }

    /**
     * Inicia el proceso de pago con PayPal
     */
     /*
    protected function iniciarPagoPaypal(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;

            $data = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $pago->referencia,
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($pago->valor, 2, '.', '')
                    ],
                    "description" => $pago->curso_nombre
                ]],
                "application_context" => [
                    "brand_name" => "Tu Empresa",
                    "landing_page" => "NO_PREFERENCE",
                    "user_action" => "PAY_NOW",
                    "return_url" => route('pagos.paypal.capture', $pago->id),
                    "cancel_url" => route('pagos.publico.error', $pago->id)
                ]
            ];

            // Obtener token de acceso
           /*
            $tokenResponse = Http::withBasicAuth(
                $botonPago->usuario_boton_pago, // Client ID
                $botonPago->clave_boton_pago    // Client Secret
            )->asForm()->post($botonPago->url_boton_pago . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

            if (!$tokenResponse->successful()) {
                throw new \Exception('Error al obtener token de PayPal');
            }
           
            $tokenResponse = Http::withBasicAuth(
            //$botonPago->usuario_boton_pago,
             'ARsY6UDgbYq3GzKWrfyndInEAWbHfW0uoHwOh6AOq_GlCF1iGeYVBMcJBph_nr9K7f6I0JckcI5IIj_F',
                //'sb-nwym4731761149@business.example.com',
                //$botonPago->clave_boton_pago
                'EHHItqxKGOhUMGMmraX_3x2R0WLkT3yCvQdNhXTErRZ_Cyk7wWko-iTdTPsQytn_g1MuKxTRfWZksX69'
               // 'k@OTA+0q'
            )->asForm()->post('https://api-m.sandbox.paypal.com' . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

            // Verificar si la solicitud fue exitosa
            $accessToken = $tokenResponse->json('access_token');

            // Crear orden
            $response = Http::withToken($accessToken)
                ->post('https://api-m.sandbox.paypal.com/v2/checkout/orders', $data);
           
            if ($response->successful()) {
                $result = $response->json();

                // Guardar ID de orden PayPal
                $pago->respuesta_proveedor = [
                    'paypal_order_id' => $result['id']
                ];
                $pago->save();

                // Encontrar el link de aprobación
                $approveLink = collect($result['links'])
                    ->firstWhere('rel', 'approve')['href'];

                return redirect($approveLink);
            }

            throw new \Exception($response);

        } catch (\Exception $e) {
            \Log::error('Error PayPal: ' . $e->getMessage());

            return redirect()
                ->route('pagos.publico.error', $pago)
                ->with('error', 'Error al iniciar el pago: ' . $e->getMessage());
        }
    }
    */
    protected function iniciarPagoPaypal(PagosEfectuados $pago)
{
    try {
        $botonPago = $pago->botonPago;

        $data = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $pago->referencia,
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($pago->valor, 2, '.', '')
                ],
                "description" => $pago->curso_nombre
            ]],
            "application_context" => [
                "brand_name" => "MontalvoEducacion",
                "landing_page" => "NO_PREFERENCE",
                "user_action" => "PAY_NOW",
                "return_url" => route('pagos.paypal.capture', $pago->id),
                "cancel_url" => route('pagos.publico.error', $pago->id)
            ]
        ];

        // Obtener token de acceso desde entorno de PRODUCCIÓN
        $tokenResponse = Http::withBasicAuth(
            'ARba2yCkGl5XmWIIy8lwDCQ0aBFsUPgRiNgBx8J4qYZ6O3XASsSiEg22zSI-6_ockBSA0WQWXk8-BZlR',     // Coloca aquí tu Client ID en .env
            'EKIRI5t3I9uuJmSZzvgpJwtuv00Kdaz_nmrUjB1-liuFECnGoWfL36Xp78ErV_nzik7jShCFRZdh5Tcd'         // Coloca aquí tu Secret en .env
        )->asForm()->post('https://api-m.paypal.com/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ]);

        if (!$tokenResponse->successful()) {
            throw new \Exception('Error al obtener token de PayPal');
        }

        $accessToken = $tokenResponse->json('access_token');

        // Crear orden de pago
        $response = Http::withToken($accessToken)
            ->post('https://api-m.paypal.com/v2/checkout/orders', $data);

        if ($response->successful()) {
            $result = $response->json();

            // Guardar ID de orden de PayPal
            $pago->respuesta_proveedor = [
                'paypal_order_id' => $result['id']
            ];
            $pago->save();

            // Redireccionar al link de aprobación
            $approveLink = collect($result['links'])->firstWhere('rel', 'approve')['href'];

            return redirect($approveLink);
        }

        throw new \Exception('Error al crear la orden de pago: ' . $response->body());

    } catch (\Exception $e) {
        \Log::error('Error PayPal Producción: ' . $e->getMessage());

        return redirect()
            ->route('pagos.publico.error', $pago)
            ->with('error', 'Error al iniciar el pago con PayPal: ' . $e->getMessage());
    }
}

/*
    public function capturePaypalPayment(Request $request, PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;
            $paypalOrderId = $request->token;

            // Obtener token de acceso
            $tokenResponse = Http::withBasicAuth(
                //$botonPago->usuario_boton_pago,
               // 'ARsY6UDgbYq3GzKWrfyndInEAWbHfW0uoHwOh6AOq_GlCF1iGeYVBMcJBph_nr9K7f6I0JckcI5IIj_F',
                'sb-nwym4731761149@business.example.com',
                //$botonPago->clave_boton_pago
                //'EHHItqxKGOhUMGMmraX_3x2R0WLkT3yCvQdNhXTErRZ_Cyk7wWko-iTdTPsQytn_g1MuKxTRfWZksX69'
                'k@OTA+0q'
            )->asForm()->post('https://sandbox.paypal.com' . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);
            //dd($tokenResponse);

            /*
            if (!$tokenResponse->successful()) {
                throw new \Exception('Error al obtener token de PayPal');
            }
            

            $accessToken = $tokenResponse->json()['access_token'];

            // Capturar el pago
            $response = Http::withToken($accessToken)
                ->post($botonPago->url_boton_pago . "/v2/checkout/orders/{$paypalOrderId}/capture");

            if ($response->successful()) {
                $result = $response->json();

                // Actualizar estado del pago
                $pago->estado = 'COMPLETADO';
                $pago->respuesta_proveedor = array_merge(
                    $pago->respuesta_proveedor ?? [],
                    ['paypal_capture_details' => $result]
                );
                $pago->fecha_pago = now();
                $pago->save();

                return redirect()->route('pagos.publico.estado', $pago);
            }

            throw new \Exception('Error al capturar pago en PayPal');

        } catch (\Exception $e) {
            \Log::error('Error PayPal Capture: ' . $e->getMessage());
            //dd($e->getMessage());
            return redirect()
                ->route('pagos.publico.error', $pago)
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }
    */
    public function capturePaypalPayment(Request $request, PagosEfectuados $pago)
{
    try {
        $botonPago = $pago->botonPago;
        $paypalOrderId = $request->token;

        // Variables de producción (ajusta esto con tus datos reales o desde .env)
        $clientId = 'ARba2yCkGl5XmWIIy8lwDCQ0aBFsUPgRiNgBx8J4qYZ6O3XASsSiEg22zSI-6_ockBSA0WQWXk8-BZlR'; // reemplaza por el tuyo
        $clientSecret = 'EKIRI5t3I9uuJmSZzvgpJwtuv00Kdaz_nmrUjB1-liuFECnGoWfL36Xp78ErV_nzik7jShCFRZdh5Tcd'; // reemplaza por el tuyo
        $baseUrl = 'https://api-m.paypal.com'; // endpoint producción

        // Obtener token de acceso
        $tokenResponse = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        if (!$tokenResponse->successful()) {
            throw new \Exception('Error al obtener token de PayPal: ' . $tokenResponse->body());
        }

        $accessToken = $tokenResponse->json()['access_token'];

        // Capturar el pago en producción
        $response = Http::withToken($accessToken)
            ->post("{$baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");

        if ($response->successful()) {
            $result = $response->json();

            // Actualizar estado del pago
            $pago->estado = 'COMPLETADO';
            $pago->respuesta_proveedor = array_merge(
                $pago->respuesta_proveedor ?? [],
                ['paypal_capture_details' => $result]
            );
            $pago->fecha_pago = now();
            $pago->save();

            return redirect()->route('pagos.publico.estado', $pago);
        }

        throw new \Exception('Error al capturar pago en PayPal: ' . $response->body());

    } catch (\Exception $e) {
        \Log::error('Error PayPal Capture: ' . $e->getMessage());

        return redirect()
            ->route('pagos.publico.error', $pago)
            ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
    }
}

    /**
     * Inicia el proceso de pago con PayPhone
     */
    protected function iniciarPagoPayphone(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;

            // Datos según documentación para la vista
            $data = [
                "amount" => intval($pago->valor * 100),
                "amountWithoutTax" => intval($pago->valor * 100),
                "amountWithTax" => 0,
                "tax" => 0,
                "clientTransactionId" => $pago->referencia,
                "currency" => "USD",
                "email" => $pago->correo,
                "documentId" => $pago->identificacion ?? '',
                "phoneNumber" => ltrim($pago->telefono ?? '0999999999', '0'),
                "reference" => $pago->referencia
            ];

            \Log::debug('Inicio Pago PayPhone:', [
                'pago' => $pago->toArray(),
                'data' => $data
            ]);

            return view('pagos.publico.payphone', compact('pago', 'data', 'botonPago'));
        } catch (\Exception $e) {
            \Log::error('Error PayPhone: ' . $e->getMessage());
            return redirect()->route('pagos.publico.error', $pago)
                ->with('error', 'Error al iniciar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el estado del pago al cliente
     */
    public function estadoPago(PagosEfectuados $pago)
    {
        return view('pagos.publico.estado', compact('pago'));
    }

    /**
     * Confirma un pago por transferencia (subir comprobante)
     */
    public function confirmarTransferencia(Request $request, PagosEfectuados $pago)
    {
        $validator = Validator::make($request->all(), [
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'comentario' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Guardar el comprobante
        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');

            $pago->respuesta_proveedor = [
                'comprobante_path' => $path,
                'comentario' => $request->comentario,
                'fecha_comprobante' => Carbon::now()->toDateTimeString()
            ];

            $pago->estado = 'PENDIENTE DE VERIFICACION'; // Pendiente de verificación
            $pago->save();
        }

        return redirect()
            ->route('pagos.publico.estado', $pago)
            ->with('success', 'Comprobante subido exitosamente. En breve verificaremos tu pago.');
    }

    /**
     * Genera una referencia única para el pago
     */
    protected function generarReferencia()
    {
        do {
            $referencia = strtoupper(Str::random(8));
        } while (PagosEfectuados::where('referencia', $referencia)->exists());

        return $referencia;
    }
    public function mostrarError(PagosEfectuados $pago)
    {
        return view('pagos.publico.error', [
            'pago' => $pago,
            'error' => session('error')
        ]);
    }
    /*
    public function generarLinkPago(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;

            $valor = intval($pago->valor * 100); // Convertir a centavos

            $paymentData = [
                "amount" => $valor,                            // Monto total en centavos
                "amountWithoutTax" => $valor,                 // Monto sin impuestos
                "amountWithTax" => 0,                         // Ponemos 0 ya que no hay impuestos
                "tax" => 0,                                   // Sin impuestos
                "service" => 1,                 // Debe ser string, no 0
                "currency" => "USD",
                "reference" => $pago->referencia,
                "clientTransactionId" => $pago->referencia,
                "email" => $pago->correo,
                "documentId" => $pago->identificacion ?? '',
                "phoneNumber" => ltrim($pago->telefono ?? '0999999999', '0'), // Quitar el 0 inicial
                "countryCode" => "593",
                "responseUrl" => route('pagos.publico.estado', $pago->id),
                "cancellationUrl" => route('pagos.publico.error', $pago->id),
            ];

            // Datos adicionales simplificados
            $additionalData = [
                "orderId" => strval($pago->id),        // Convertir a string
                "nombre" => $pago->cliente,
                "email" => $pago->correo,
                "curso" => $pago->curso_nombre,
                "valor" => number_format($pago->valor, 2)
            ];

            // Convertir a JSON y codificar en base64
            $jsonData = json_encode($additionalData, JSON_UNESCAPED_UNICODE);
            if (!$jsonData) {
                throw new \Exception('Error al codificar JSON: ' . json_last_error_msg());
            }

            $paymentData['data'] = base64_encode($jsonData);

            // Debug
            \Log::info('PayPhone Request Data:', [
                'paymentData' => $paymentData,
                'additionalData' => $additionalData,
                'jsonData' => $jsonData,
                'base64Data' => $paymentData['data']
            ]);

            // Cambiar el formato del header de autorización
            $response = Http::withHeaders([
                'Authorization' => 'Bearer Hi9H-xszTi_X2vmkInKY3v5iAJ6IRm5_Lx60zsosW4RqnvfbJbSpfNBxLiYy0Fjao2CIrwPal2gbHQzsO7UdwCBneKB7UeEaCjqyprzl2IHkQB8iAsfxrSx3BDjrTMABNwFt_EMInF8UxkAkDiHuA0pXBZPj9w6XVay1u_zovWs_x7aSHafFpEofPRGxXBZdddT2SsAigOjtjbMA89bEc2RcoZ0COOlBrNs-T8SE_g5ruuN-yRlT_bYFoE66FgsHBn6uUXcugU1itImRqlB29M_IG4xRGcuo-1mbJTh_fuYvQyk3hQVICrtteuKjSFSPNab1sQ' , // Añadido 'Bearer'
                'Content-Type' => 'application/json'
            ])->post('https://pay.payphonetodoesposible.com/api/v2/transaction/Create', $paymentData);

            \Log::info('PayPhone Response:', ['response' => $response->json()]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['transactionId'])) {
                    return response()->json([
                        'success' => true,
                        'payWithPayPhone' => "https://pay-test.payphonetodoesposible.com/payment/{$responseData['transactionId']}"
                    ]);
                }
            }

            return response()->json([
                'error' => 'Error al generar el link de pago',
                'details' => $response->json()
            ], 400);

        } catch (\Exception $e) {
            \Log::error('PayPhone Error:', [
                'error' => $e->getMessage(),
                'token' => $botonPago->token_boton_pago // Debug del token
            ]);
            return response()->json([
                'error' => 'Error al procesar la solicitud',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    */
    public function generarLinkPago(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;
            $phoneNumber = preg_replace('/[^0-9]/', '', $pago->telefono ?? '0999999999');
            $phoneNumber = ltrim($phoneNumber, '0'); // Remover el 0 inicial si existe
            $phoneNumber = '+593' . $phoneNumber; // Agregar el prefijo +593
            $paymentData = [
                "amount" => intval($pago->valor * 100),
                "amountWithoutTax" => intval($pago->valor * 100),
                "amountWithTax" => 0,
                "tax" => 0,
                "clientTransactionId" => $pago->referencia,
                "currency" => "USD",
                "reference" => $pago->referencia,
                "phoneNumber" => $phoneNumber,
                "countryCode" => "593",
                "email" => $pago->correo,
                "documentId" => $pago->identificacion ?? '',
                "responseUrl" => route('pagos.publico.estado', $pago->id),
                "cancellationUrl" => route('pagos.publico.error', $pago->id),
            ];

            \Log::info('PayPhone Request:', ['data' => $paymentData]);

            // Hacer la petición y obtener la respuesta completa
            $response = Http::withHeaders([
                'Authorization' => 'Bearer bFvDKse17zYywcT62hrlnthfDq8L1ZUfMr2yK5aj8sEWqlJ6xf2cJdpADWAjEedJ7Zu48TTukcd31EuDpc_DvB7mOQ_6dOgdnVFH4juHEq3UN7gAKoyNcCmbwb0E2y-g4NxA7eeXuV2RWbyd8gzWuTiCQMA1_qL4c9w8j55siJAcLh1b2LJ1ql814d0ItCCERjvqlm28nAhE5BS_RiKnsubP7HFMRJoQzp6o0QzVaWbmHsYHwkuq-3_nXL0V3j5ZoRK5EiV8CGxtv_HsSxV6qURDUgGK-VH6xrbNXCHZ8d_XzDujmbG14mrcseyZUM3_ZfzEHA' , // Añadido 'Bearer'
                'Content-Type' => 'application/json'
            ])->post('https://pay.payphonetodoesposible.com/api/button/Prepare', $paymentData);

            // Loguear toda la información de la respuesta
            \Log::info('PayPhone Response Info:', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
                'json' => $response->json(),
                'url' => 'https://pay.payphonetodoesposible.com/api/buttons/V2/Generate',
                'data_sent' => $paymentData
            ]);

            if ($response->status() === 200 && $response->json()) {
                $responseData = $response->json();
                \Log::info('Response Data:', ['data' => $responseData]);

                if (isset($responseData['payWithPayPhone'])) {
                    return response()->json([
                        'success' => true,
                        'payWithPayPhone' => $responseData['payWithPayPhone']
                    ]);
                }
            }

            // Devolver error con más detalles
            return response()->json([
                'error' => 'Error al generar el link de pago',
                'details' => [
                    'status_code' => $response->status(),
                    'response_body' => $response->body(),
                    'request_data' => $paymentData
                ]
            ], 400);

        } catch (\Exception $e) {
            \Log::error('PayPhone Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Error al procesar la solicitud',
                'message' => $e->getMessage(),
                'details' => $e->getTrace()
            ], 500);
        }
    }
// 'Authorization' => 'Bearer Hi9H-xszTi_X2vmkInKY3v5iAJ6IRm5_Lx60zsosW4RqnvfbJbSpfNBxLiYy0Fjao2CIrwPal2gbHQzsO7UdwCBneKB7UeEaCjqyprzl2IHkQB8iAsfxrSx3BDjrTMABNwFt_EMInF8UxkAkDiHuA0pXBZPj9w6XVay1u_zovWs_x7aSHafFpEofPRGxXBZdddT2SsAigOjtjbMA89bEc2RcoZ0COOlBrNs-T8SE_g5ruuN-yRlT_bYFoE66FgsHBn6uUXcugU1itImRqlB29M_IG4xRGcuo-1mbJTh_fuYvQyk3hQVICrtteuKjSFSPNab1sQ' , // Añadido 'Bearer'
    public function verificarEstado(PagosEfectuados $pago)
    {
        try {
            $botonPago = $pago->botonPago;

            // Hacer petición a PayPhone para verificar estado
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $botonPago->token_boton_pago,
                'Content-Type' => 'application/json'
            ])->get("https://pay.payphonetodoesposible.com/api/v2/transaction/{$pago->referencia}");

            if ($response->successful()) {
                $responseData = $response->json();

                // Actualizar estado en la base de datos
                $pago->estado = $responseData['status'] ?? 'PENDIENTE';
                $pago->save();

                return response()->json([
                    'status' => $pago->estado
                ]);
            }

            return response()->json([
                'status' => 'PENDIENTE'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error al verificar estado:', [
                'error' => $e->getMessage(),
                'pago_id' => $pago->id
            ]);

            return response()->json([
                'status' => 'PENDIENTE'
            ]);
        }
    }
}
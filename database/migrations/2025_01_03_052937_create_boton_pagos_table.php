<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('boton_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_proveedor'); // PayPal, PayPhone, etc.
            $table->string('boton_pago_detalle')->nullable();
            $table->string('usuario_boton_pago')->nullable();
            $table->string('clave_boton_pago')->nullable();
            $table->string('url_boton_pago')->nullable();
            $table->string('token_boton_pago')->nullable();
            $table->string('key_boton_pago')->nullable();
            $table->boolean('esta_activo')->default(true);
            $table->json('configuracion_adicional')->nullable(); // Para configs específicas de cada proveedor
            $table->timestamps();
            $table->softDeletes(); // Por si necesitas deshabilitar métodos de pago sin eliminarlos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boton_pagos');
    }
};

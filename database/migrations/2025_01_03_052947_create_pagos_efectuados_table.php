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
        Schema::create('pagos_efectuados', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion')->nullable(); // Cédula o documento de identidad
            $table->string('cliente');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->foreignId('boton_pago_id')->constrained()->onDelete('cascade');
            $table->string('referencia')->unique();
            $table->timestamp('fecha_pago');
            $table->integer('curso_id');
            $table->string('curso_nombre'); // Guardamos el nombre del curso para referencia
            $table->decimal('valor', 10, 2);
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['PENDIENTE', 'COMPLETADO', 'FALLIDO', 'REEMBOLSADO']);
            $table->json('respuesta_proveedor')->nullable();
            $table->enum('tipo_pago', ['TRANSFERENCIA', 'PAYPAL', 'PAYPHONE']);
            // Campos para integración con Moodle
            $table->boolean('registrado_moodle')->default(false);
            $table->string('moodle_user_id')->nullable();
            $table->timestamp('fecha_registro_moodle')->nullable();
            $table->json('datos_moodle')->nullable(); // Para almacenar información adicional de Moodle
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_efectuados');
    }
};

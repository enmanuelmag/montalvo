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
        Schema::create('landing_cursos_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->foreignId('categoria_id')->constrained('landing_cursos_categorias');
            $table->string('detalle')->nullable();
            $table->string('imagen')->nullable();
            $table->string('video')->nullable();
            $table->string('precio')->nullable();
            $table->string('duracion')->nullable();
            $table->string('fecha_inicio')->nullable();
            $table->string('fecha_fin')->nullable();
            $table->string('horario')->nullable();
            $table->string('lugar')->nullable();
            $table->string('requisitos')->nullable();
            $table->string('dirigido')->nullable();
            $table->string('metodologia')->nullable();
            $table->string('certificacion')->nullable();
            $table->string('calificacion');
            $table->text('resumen')->nullable();
            $table->string('unidad_duracion')->nullable();
            $table->integer('estado')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_cursos_detalles');
    }
};

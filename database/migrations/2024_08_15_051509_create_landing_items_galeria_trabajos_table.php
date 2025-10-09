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
        Schema::create('landing_items_galeria_trabajos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('detalle')->nullable();
            $table->string('imagen')->nullable();
            $table->foreignId('landing_categoria_trabajo_id')->constrained('landing_categorias_trabajos')->onDelete('cascade');
            $table->integer('estado')->default(1);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_items_galeria_trabajos');
    }
};

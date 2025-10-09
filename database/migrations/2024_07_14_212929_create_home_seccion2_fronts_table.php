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
        Schema::create('home_seccion2_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_2');
            $table->string('texto_2');
            $table->string('imagen_2');
            $table->string('texto_boton_2');
            $table->string('link_boton_2');
            $table->string('pie_imagen_2');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_seccion2_fronts');
    }
};

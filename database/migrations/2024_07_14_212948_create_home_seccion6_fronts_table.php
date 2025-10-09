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
        Schema::create('home_seccion6_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_6');
            $table->string('texto_6');
            $table->string('texto_boton_6');
            $table->string('link_boton_6');
            $table->string('imagen_6');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_seccion6_fronts');
    }
};

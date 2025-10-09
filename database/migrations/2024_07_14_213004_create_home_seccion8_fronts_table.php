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
        Schema::create('home_seccion8_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('imagen_8_1');
            $table->string('titulo_imagen_8_1');
            $table->string('link_8_1');
            $table->string('texto_8_1');
            $table->string('imagen_8_2');
            $table->string('titulo_imagen_8_2');
            $table->string('link_8_2');
            $table->string('texto_8_2');
            $table->string('imagen_8_3');
            $table->string('titulo_imagen_8_3');
            $table->string('link_8_3');
            $table->string('texto_8_3');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_seccion8_fronts');
    }
};

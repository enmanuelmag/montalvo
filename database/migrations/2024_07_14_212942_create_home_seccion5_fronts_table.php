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
        Schema::create('home_seccion5_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_5');
            $table->string('texto_5');
            $table->string('texto_boton_5');
            $table->string('link_boton_5');
            $table->string('imagen_5_1');
            $table->string('imagen_5_2');
            $table->string('link_5_1');
            $table->string('link_5_2');
            $table->string('link_5_3');
            $table->string('texto_link_5_1');
            $table->string('texto_link_5_2');
            $table->string('texto_link_5_3');
            $table->string('texto_adicional');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_seccion5_fronts');
    }
};

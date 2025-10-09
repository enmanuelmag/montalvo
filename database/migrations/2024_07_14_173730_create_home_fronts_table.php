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
        Schema::create('home_fronts', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('titulo_principal');
            $table->string('texto_principal');
            $table->string('imagen_principal');
            $table->string('texto_boton_principal');
            $table->string('link_boton_principal');
            $table->string('titulo_3');
            $table->string('footer_leyenda');
            $table->string('footer_link');
            $table->string('footer_link_creador');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_fronts');
    }
};

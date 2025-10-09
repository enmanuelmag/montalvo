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
        Schema::create('landing_services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default('Servicios');
            $table->string('description')->nullable()->default('Descripción de la sección');
            $table->string('boton_text')->nullable()->default('Ver más');
            $table->string('boton_link')->nullable()->default('#');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_services');
    }
};

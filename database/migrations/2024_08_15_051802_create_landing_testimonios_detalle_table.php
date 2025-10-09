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
        Schema::create('landing_testimonios_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('detalle')->nullable();
            $table->string('imagen')->nullable();
            $table->string('cargo')->nullable();
            $table->string('empresa')->nullable();
            $table->string('calificacion')->nullable();
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_testimonios_detalle');
    }
};

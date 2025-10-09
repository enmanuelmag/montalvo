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
        Schema::create('landing_blogs_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->text('detalle')->nullable();
            $table->string('imagen')->nullable();
            $table->string('fecha')->nullable();
            $table->string('autor')->nullable();
            $table->string('tipo')->nullable();
            $table->string('tags')->nullable();
            $table->integer('estado')->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_blogs_detalle');
    }
};

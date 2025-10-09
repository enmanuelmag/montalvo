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
        Schema::create('landing_general', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable()->default('We Are');
            $table->string('subtitulo')->nullable()->default('We are a team of professionals');
            $table->string('descripcion')->nullable()->default('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $table->string('imagen')->nullable()->default('8.jpg');
            $table->string('btn_text')->nullable()->default('Get a Quote');
            $table->string('btn_link')->nullable()->default('Services');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_general');
    }
};

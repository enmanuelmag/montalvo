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
        Schema::create('landing_about', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable()->default('About Us');
            $table->string('descripcion1')->nullable()->default('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $table->string('parrafo1')->nullable()->default('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $table->string('parrafo2')->nullable()->default('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
            $table->string('btn_text')->nullable()->default('Read More');
            $table->string('btn_link')->nullable()->default('Services');
            $table->string('imagen')->nullable()->default('8.jpg');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_about');
    }
};

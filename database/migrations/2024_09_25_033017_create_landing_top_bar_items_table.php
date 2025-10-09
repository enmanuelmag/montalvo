<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('landing_top_bar_items', function (Blueprint $table) {
            $table->id(); // Crea el campo id con big integer y auto increment.
            $table->string('name', 255)->nullable(); // Campo name con máximo de 255 caracteres.
            $table->string('url', 255)->nullable(); // Campo url con máximo de 255 caracteres.
            $table->string('icon', 255)->nullable(); // Campo icon con máximo de 255 caracteres.
            $table->integer('estado')->default(1); // Campo estado con valor por defecto 1.
            $table->timestamps(); // Crea los campos created_at y updated_at.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_top_bar_items');
    }
};

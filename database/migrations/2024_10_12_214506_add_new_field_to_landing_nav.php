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
        Schema::table('landing_nav', function (Blueprint $table) {
            //
             $table->integer('ordenamiento')->nullable(); // Añadir la nueva columna
            $table->string('detalle')->nullable(); // Añadir la nueva columna
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_nav', function (Blueprint $table) {
            //
        });
    }
};

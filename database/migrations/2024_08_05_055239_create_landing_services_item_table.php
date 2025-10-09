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
        Schema::create('landing_services_item', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->default('Servicio');
            $table->string('description')->nullable()->default('Descripción del servicio');
            $table->string('icon')->nullable()->default('fas fa-cog');
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_services_item');
    }
};

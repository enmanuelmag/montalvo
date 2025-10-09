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
        
        Schema::table('pagos_efectuados', function (Blueprint $table) {
            $table->boolean('matriculado_moodle')->default(false)->after('registrado_moodle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos_efectuados', function (Blueprint $table) {
            //
        });
    }
};

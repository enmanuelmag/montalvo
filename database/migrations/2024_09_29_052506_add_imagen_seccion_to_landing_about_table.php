<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('landing_about', function (Blueprint $table) {
            $table->text('imagen_seccion')->nullable()->after('imagen');
        });
    }

    public function down()
    {
        Schema::table('landing_about', function (Blueprint $table) {
            $table->dropColumn('imagen_seccion');
        });
    }
};

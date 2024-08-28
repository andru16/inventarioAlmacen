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
        Schema::create('servicios_tienen_colaboradores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_servicio')->references('id')->on('servicios_almacen')->onDelete('cascade');
            $table->foreignUuid('id_colaborador')->references('id')->on('colaboradores_almacen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios_tienen_colaboradores', function (Blueprint $table) {
            $table->dropForeign(['id_servicio']);
            $table->dropForeign(['id_colaborador']);
        });
        Schema::dropIfExists('servicios_tienen_colaboradores');
    }
};

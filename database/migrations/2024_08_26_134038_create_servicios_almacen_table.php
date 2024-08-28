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
        Schema::create('servicios_almacen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_factura')->references('id')->on('facturas')->onDelete('cascade');
            $table->string('descripcion');
            $table->decimal('valor', 17, 2);
            $table->dateTime('creado_en')->useCurrent();
            $table->dateTime('actualizado_en')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios_almacen', function (Blueprint $table) {
            $table->dropForeign(['id_factura']);
        });
        Schema::dropIfExists('servicios_almacen');
    }
};

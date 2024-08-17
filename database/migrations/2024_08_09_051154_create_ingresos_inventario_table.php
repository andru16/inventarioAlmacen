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
        Schema::create('ingresos_inventario', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_proveedor')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreignUuid('id_tipo_movimiento')
                ->constrained('tipo_movimientos_salidas_inventario')
                ->onDelete('cascade');
            $table->foreignUuid('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->string('numero_ingreso');
            $table->date('fecha_emision');
            $table->string('observaciones')->nullable();
            $table->dateTime('creado_en')->useCurrent();
            $table->dateTime('actualizado_en')->useCurrent();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos_inventario', function (Blueprint $table){
            $table->dropForeign(['id_proveedor']);
            $table->dropForeign(['id_tipo_movimiento']);
            $table->dropForeign(['id_almacen']);
        });
        Schema::dropIfExists('ingresos_inventario');
    }
};

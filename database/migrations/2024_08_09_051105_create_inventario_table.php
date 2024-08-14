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
        Schema::create('inventario', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->foreignUuid('id_marca')->references('id')->on('marcas')->onDelete('cascade');
            $table->foreignUuid('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->decimal('cantidad_disponible', 17, 2)->default(0);
            $table->decimal('cantidad_reservada', 17, 2)->default(0);
            $table->decimal('cantidad_total', 17, 2)->default(0);
            $table->decimal('costo_total', 17, 2)->default(0);
            $table->string('referencia_proveedor')->nullable();
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
        Schema::table('inventario', function (Blueprint $table){
            $table->dropForeign(['id_producto']);
            $table->dropForeign(['id_marca']);
            $table->dropForeign(['id_almacen']);
        });
        Schema::dropIfExists('inventario');
    }
};

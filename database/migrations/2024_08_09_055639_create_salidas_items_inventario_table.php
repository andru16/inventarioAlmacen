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
        Schema::create('salidas_items_inventario', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_item_inventario')->references('id')->on('inventario')->onDelete('cascade');
            $table->foreignUuid('id_salida_inventario')->references('id')->on('inventario')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('costo_unitario', 17, 2);
            $table->decimal('costo_total', 17, 2);
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
        Schema::table('salidas_items_inventario', function (Blueprint $table){
            $table->dropForeign(['id_item_inventario']);
            $table->dropForeign(['id_salida_inventario']);
        });

        Schema::dropIfExists('salidas_items_inventario');
    }
};

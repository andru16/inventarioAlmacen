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
        Schema::create('productos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nombre');
            $table->foreignUuid('id_categoria')->references('id')->on('categorias_productos')->onDelete('cascade');
            $table->foreignUuid('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->foreignUuid('id_marca')->references('id')->on('marcas')->onDelete('cascade');
            $table->string('referencia');
            $table->integer('stock_minimo');
            $table->string('segunda_referencia')->nullable();
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
        Schema::table('productos', function (Blueprint $table){
            $table->dropForeign(['id_categoria']);
            $table->dropForeign(['id_almacen']);
            $table->dropForeign(['id_marca']);
        });
        Schema::dropIfExists('productos');
    }
};

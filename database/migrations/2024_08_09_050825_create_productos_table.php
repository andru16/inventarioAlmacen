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
            $table->string('codigo');
            $table->integer('stock_minimo');
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
        });
        Schema::dropIfExists('productos');
    }
};

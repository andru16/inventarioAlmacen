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
        Schema::create('categorias_productos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nombre');
            $table->foreignUuid('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias_productos', function (Blueprint $table) {
            $table->dropForeign(['id_almacen']);
        });
        Schema::dropIfExists('categorias_productos');
    }
};

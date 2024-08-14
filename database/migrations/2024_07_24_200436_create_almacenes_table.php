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
        Schema::create('almacenes', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nombre');
            $table->string('logo')->nullable();
            $table->string('direccion')->nullable();
            $table->foreignId('id_ciudad')->nullable()->references('id')->on('ciudades')->onDelete('cascade');
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('whatsapp')->nullable();
            $table->enum('estado', [0,1])->default(1);
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
        Schema::table('almacenes', function (Blueprint $table){
            $table->dropForeign(['id_ciudad']);
        });
        Schema::dropIfExists('almacenes');
    }
};

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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('almacen_id')->nullable()->references('id')->on('almacenes')->onDelete('cascade');
            $table->string('nombre_completo');
            $table->string('correo_electronico')->unique();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->uuid('ip_usuario')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
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
        Schema::table('usuarios', function (Blueprint $table){
           $table->dropForeign(['almacen_id']);
        });
        Schema::dropIfExists('usuarios');
    }
};

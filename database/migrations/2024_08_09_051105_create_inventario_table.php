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
            $table->decimal('cantidad', 17, 2)->default(0);
            $table->decimal('cantidad_reservada', 17, 2)->default(0);
            $table->decimal('cantidad_disponible', 17, 2)->default(0);
            $table->decimal('costo', 17, 2)->default(0);
            $table->decimal('precio', 17, 2)->default(0);
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
        });
        Schema::dropIfExists('inventario');
    }
};

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
        Schema::create('salidas_inventario', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_tipo_movimiento')
                ->constrained('tipo_movimientos_salidas_inventario')
                ->onDelete('cascade');
            $table->integer('numero_salida');
            $table->date('fecha_salida');
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

        Schema::table('salidas_inventario', function (Blueprint $table) {
            $table->dropForeign(['id_tipo_movimiento']);
        });

        Schema::dropIfExists('salidas_inventario');
    }
};

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
        Schema::create('facturas', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_salida_inventario')->references('id')->on('salidas_inventario')->onDelete('cascade');
            $table->string('numero_factura');
            $table->date('fecha_emision');
            $table->string('nombre_cliente')->nullable();
            $table->string('telefono')->nullable();
            $table->decimal('valor_factura', 17, 2)->default(0);
            $table->decimal('descuento', 17, 2)->default(0);
            $table->decimal('servicio', 17, 2)->default(0);
            $table->date('fecha_vencimiento');
            $table->enum('estado_factura', ['Pendiente', 'Pagada', 'Cancelada'])->default('Pendiente');
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
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropForeign(['id_salida_inventario']);
        });
        Schema::dropIfExists('facturas');
    }
};

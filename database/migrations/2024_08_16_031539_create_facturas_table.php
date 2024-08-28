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
            $table->foreignUuid('id_cliente')->references('id')->on('clientes_almacen')->onDelete('cascade');
            $table->foreignUuid('id_venta')->references('id')->on('ventas')->onDelete('cascade');
            $table->string('numero_factura');
            $table->date('fecha_emision');
            $table->decimal('valor_factura', 17, 2)->default(0);
            $table->decimal('descuento', 17, 2)->default(0);
            $table->date('fecha_vencimiento');
            $table->enum('estado_factura', ['Pendiente', 'Cancelada'])->default('Pendiente');
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
            $table->dropForeign(['id_venta']);
            $table->dropForeign(['id_cliente']);
        });
        Schema::dropIfExists('facturas');
    }
};

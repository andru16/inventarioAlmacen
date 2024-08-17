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
        Schema::create('facturas_tienen_productos', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('id_factura')->references('id')->on('facturas')->onDelete('cascade');
            $table->foreignUuid('id_producto')->references('id')->on('productos')->onDelete('cascade');
            $table->decimal('cantidad');
            $table->decimal('precio_unitario', 17, 2);
            $table->decimal('total', 17, 2)->nullable();
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
        Schema::table('facturas_tienen_productos', function (Blueprint $table) {
            $table->dropForeign(['id_factura']);
            $table->dropForeign(['id_producto']);
        });
        Schema::dropIfExists('facturas_tienen_productos');
    }
};

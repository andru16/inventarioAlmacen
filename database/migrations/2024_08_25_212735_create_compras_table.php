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
        Schema::create('compras', function (Blueprint $table) {
            $table->uuid('id');

            $table->date('fecha');
            $table->string('medio_pago');
            $table->text('observaciones')->nullable();
            $table->string('consecutivo');
            $table->string('no_remision');
            $table->decimal('valor_compra', 15, 2);
            $table->foreignUuid('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->string('estado');

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
        Schema::dropIfExists('compras');
    }
};

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
        Schema::create('pagos_facturas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_factura')->references('id')->on('facturas')->onDelete('cascade');
            $table->decimal('valor_pago', 17, 2);
            $table->string('numero_pago');
            $table->date('fecha_pago');
            $table->dateTime('creado_en')->useCurrent();
            $table->dateTime('actualizado_en')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_facturas');
    }
};

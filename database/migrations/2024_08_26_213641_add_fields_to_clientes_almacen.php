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
        Schema::table('clientes_almacen', function (Blueprint $table) {
            $table->foreignUuid('id_almacen')->references('id')->on('almacenes')->onDelete('cascade');
            $table->enum('estado', [0,1])->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes_almacen', function (Blueprint $table) {
            $table->dropForeign(['id_almacen']);
            $table->dropColumn(['estado']);
            $table->dropColumn('id_almacen');
        });
    }
};

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
        Schema::table('colaboradores_almacen', function (Blueprint $table) {
            $table->enum('estado', [0, 1])->default(1)->after('cargo');
            $table->foreignUuid('id_almacen')->after('estado')->references('id')->on('almacenes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colaboradores_almacen', function (Blueprint $table) {
            $table->dropForeign(['id_almacen']);
            $table->dropColumn('id_almacen');
            $table->dropColumn('estado');
        });
    }
};

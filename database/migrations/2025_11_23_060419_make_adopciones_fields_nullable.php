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
        Schema::table('adopciones', function (Blueprint $table) {
            // Hacer nullable los campos opcionales
            $table->string('adoptante_telefono', 20)->nullable()->change();
            $table->text('adoptante_direccion')->nullable()->change();
            $table->text('motivo_adopcion')->nullable()->change();
            $table->date('fecha_adopcion')->nullable()->change();
            $table->text('observaciones')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adopciones', function (Blueprint $table) {
            // Revertir a not null (solo si es necesario)
            $table->string('adoptante_telefono', 20)->nullable(false)->change();
            $table->text('adoptante_direccion')->nullable(false)->change();
            $table->text('motivo_adopcion')->nullable(false)->change();
        });
    }
};

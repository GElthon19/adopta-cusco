<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('adopciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animales', 'id_animales')->onDelete('cascade'); // ✅ Especificar columna
            $table->string('adoptante_nombre', 100);
            $table->string('adoptante_email', 100);
            $table->string('adoptante_telefono', 20);
            $table->text('adoptante_direccion');
            $table->text('motivo_adopcion');
            $table->enum('estado', ['Pendiente', 'Aprobada', 'Rechazada', 'Completada'])->default('Pendiente');
            $table->date('fecha_solicitud');
            $table->date('fecha_adopcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adopciones');
    }
};

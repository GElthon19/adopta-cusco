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
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->string('donante_nombre', 100);
            $table->string('donante_email', 100);
            $table->string('donante_telefono', 20)->nullable();
            $table->decimal('monto', 8, 2);
            $table->enum('tipo_donacion', ['Efectivo', 'Alimentos', 'Medicinas', 'Otros']);
            $table->text('descripcion')->nullable();
            $table->date('fecha_donacion');
            $table->enum('estado', ['Pendiente', 'Recibida', 'Verificada'])->default('Pendiente');
            $table->text('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donaciones');
    }
};

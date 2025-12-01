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
        Schema::create('animales', function (Blueprint $table) {
            $table->id('id_animales');
            $table->string('nombre', 100);
            $table->enum('especie', ['Perro', 'Gato', 'Otro'])->default('Perro');
            $table->integer('edad')->nullable();
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['Disponible', 'Adoptado', 'En proceso'])->default('Disponible');
            $table->string('imagen', 255)->nullable();
            $table->date('fecha_ingreso')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};

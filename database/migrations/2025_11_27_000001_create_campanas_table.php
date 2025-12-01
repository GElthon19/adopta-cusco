<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campanas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('imagen')->nullable();
            $table->date('fecha_inicio');
            $table->integer('duracion_dias')->default(30); // duración en días
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['activa', 'finalizada', 'pausada'])->default('activa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campanas');
    }
};

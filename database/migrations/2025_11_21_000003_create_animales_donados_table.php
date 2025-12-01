<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('animales_donados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitud_donacion');
            
            // Datos del animal
            $table->string('nombre_animal', 100);
            $table->enum('tipo_animal', ['perro', 'gato', 'otro'])->default('perro');
            $table->string('raza', 100)->nullable();
            $table->string('edad_aproximada', 50)->nullable();
            $table->enum('sexo', ['macho', 'hembra'])->nullable();
            $table->string('color', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('foto', 255)->nullable();
            
            // Referencia al animal agregado al albergue (cuando se aprueba)
            $table->unsignedBigInteger('id_animal_agregado')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('id_solicitud_donacion')
                  ->references('id')
                  ->on('solicitudes_donacion_animales')
                  ->onDelete('cascade');
                  
            $table->foreign('id_animal_agregado')
                  ->references('id_animales')
                  ->on('animales')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('animales_donados');
    }
};

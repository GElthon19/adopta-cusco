<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('solicitudes_donacion_animales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario')->nullable();
            
            // Datos del donante
            $table->string('nombre_donante', 150);
            $table->string('email_donante', 150);
            $table->string('telefono_donante', 20)->nullable();
            $table->text('direccion_donante')->nullable();
            
            // Información general de la donación
            $table->integer('cantidad_animales')->default(1);
            $table->text('motivo_donacion')->nullable();
            
            // Tipo de registro y estado
            $table->enum('tipo_registro', ['online', 'presencial'])->default('online');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            
            // Admin que procesó
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('observaciones_admin')->nullable();
            $table->timestamp('procesado_at')->nullable();
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('id_usuario')->references('id')->on('users')->nullOnDelete();
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes_donacion_animales');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('estado');
            $table->text('respuesta_mensaje')->nullable()->after('observaciones');
            $table->timestamp('procesado_at')->nullable()->after('respuesta_mensaje');

            // Si no tienes tabla users, elimina la siguiente línea antes de migrar
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'respuesta_mensaje', 'procesado_at']);
        });
    }
};
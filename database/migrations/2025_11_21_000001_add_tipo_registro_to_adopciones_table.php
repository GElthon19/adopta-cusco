<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            if (!Schema::hasColumn('adopciones', 'tipo_registro')) {
                $table->enum('tipo_registro', ['online', 'presencial'])->default('online')->after('estado');
            }
            if (!Schema::hasColumn('adopciones', 'id_usuario')) {
                $table->unsignedBigInteger('id_usuario')->nullable()->after('id');
                $table->foreign('id_usuario')->references('id')->on('users')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            if (Schema::hasColumn('adopciones', 'tipo_registro')) {
                $table->dropColumn('tipo_registro');
            }
            if (Schema::hasColumn('adopciones', 'id_usuario')) {
                $table->dropForeign(['id_usuario']);
                $table->dropColumn('id_usuario');
            }
        });
    }
};

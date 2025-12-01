<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            if (!Schema::hasColumn('adopciones', 'id_animal')) {
                $table->unsignedBigInteger('id_animal')->nullable()->after('id');
            }
            if (!Schema::hasColumn('adopciones', 'nombre_persona')) {
                $table->string('nombre_persona', 150)->nullable()->after('id_animal');
            }
            if (!Schema::hasColumn('adopciones', 'telefono')) {
                $table->string('telefono', 20)->nullable()->after('nombre_persona');
            }
            if (!Schema::hasColumn('adopciones', 'correo')) {
                $table->string('correo', 150)->nullable()->after('telefono');
            }
            if (!Schema::hasColumn('adopciones', 'direccion')) {
                $table->text('direccion')->nullable()->after('correo');
            }
            if (!Schema::hasColumn('adopciones', 'motivo')) {
                $table->text('motivo')->nullable()->after('direccion');
            }
            if (!Schema::hasColumn('adopciones', 'fecha_solicitud')) {
                $table->timestamp('fecha_solicitud')->nullable()->after('motivo');
            }
            if (!Schema::hasColumn('adopciones', 'estado')) {
                $table->string('estado', 20)->default('Pendiente')->after('fecha_solicitud');
            }
            if (!Schema::hasColumn('adopciones', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('estado');
            }
        });
    }

    public function down()
    {
        Schema::table('adopciones', function (Blueprint $table) {
            $cols = [
                'id_animal','nombre_persona','telefono','correo',
                'direccion','motivo','fecha_solicitud','estado','observaciones'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('adopciones', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donaciones', function (Blueprint $table) {
            // Agregar campos para soportar donaciones presenciales y bienes físicos
            if (!Schema::hasColumn('donaciones', 'tipo_registro')) {
                $table->enum('tipo_registro', ['online', 'presencial'])->default('online')->after('id');
            }
            if (!Schema::hasColumn('donaciones', 'tipo_bien')) {
                $table->string('tipo_bien', 100)->nullable()->after('tipo_donacion');
            }
            if (!Schema::hasColumn('donaciones', 'valor_estimado')) {
                $table->decimal('valor_estimado', 10, 2)->nullable()->after('monto');
            }
            if (!Schema::hasColumn('donaciones', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('comentarios');
            }
        });
    }

    public function down()
    {
        Schema::table('donaciones', function (Blueprint $table) {
            $columns = ['tipo_registro', 'tipo_bien', 'valor_estimado', 'observaciones'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('donaciones', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

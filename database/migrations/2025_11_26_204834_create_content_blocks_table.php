<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Identificador único del bloque (ej: 'welcome_title', 'campaign_text')
            $table->string('label'); // Etiqueta descriptiva para el admin
            $table->text('content'); // Contenido editable
            $table->string('type')->default('text'); // Tipo: 'text', 'textarea', 'html'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};

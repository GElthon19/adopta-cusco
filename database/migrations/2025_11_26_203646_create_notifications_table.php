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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'adopcion' o 'donacion'
            $table->text('message');
            $table->foreignId('related_id')->nullable(); // ID de la adopción o donación
            $table->boolean('is_read')->default(false);
            $table->foreignId('user_id')->constrained('users'); // Admin que debe ver la notificación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

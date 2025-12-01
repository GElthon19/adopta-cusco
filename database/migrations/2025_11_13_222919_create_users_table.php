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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->string('name')->nullable();
            $table->string('email')->unique();

            // Autenticación tradicional
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // puede ser null si el usuario solo usa Google

            // Login con Google (Socialite)
            $table->string('google_id')->nullable()->unique();
            $table->string('avatar')->nullable();

            // Rol de la app
            $table->string('role')->default('user'); // 'admin' o 'user'

            // Remember me
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

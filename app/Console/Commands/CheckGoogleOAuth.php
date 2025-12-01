<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckGoogleOAuth extends Command
{
    protected $signature = 'google:check';
    protected $description = 'Verificar la configuración de Google OAuth';

    public function handle()
    {
        $this->info('🔍 Verificando configuración de Google OAuth...');
        $this->newLine();

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = config('services.google.redirect');

        // Verificar Client ID
        if (empty($clientId)) {
            $this->error('❌ GOOGLE_CLIENT_ID no está configurado en .env');
        } else {
            $this->info('✅ GOOGLE_CLIENT_ID: ' . substr($clientId, 0, 20) . '...');
        }

        // Verificar Client Secret
        if (empty($clientSecret)) {
            $this->error('❌ GOOGLE_CLIENT_SECRET no está configurado en .env');
        } else {
            $this->info('✅ GOOGLE_CLIENT_SECRET: ' . substr($clientSecret, 0, 15) . '...');
        }

        // Verificar Redirect URI
        if (empty($redirectUri)) {
            $this->error('❌ GOOGLE_REDIRECT_URI no está configurado en .env');
        } else {
            $this->info('✅ GOOGLE_REDIRECT_URI: ' . $redirectUri);
        }

        $this->newLine();

        // Resumen
        if (empty($clientId) || empty($clientSecret) || empty($redirectUri)) {
            $this->error('⚠️  Google OAuth NO está configurado correctamente.');
            $this->newLine();
            $this->warn('📖 Sigue la guía en: docs/CONFIGURAR_GOOGLE_OAUTH.md');
            $this->newLine();
            $this->info('Pasos rápidos:');
            $this->line('1. Ve a https://console.cloud.google.com/');
            $this->line('2. Crea un proyecto nuevo o selecciona uno existente');
            $this->line('3. Ve a "APIs y servicios" → "Credenciales"');
            $this->line('4. Crea "ID de cliente de OAuth 2.0"');
            $this->line('5. Agrega URI de redirección: http://localhost:8000/auth/google/callback');
            $this->line('6. Copia las credenciales al archivo .env');
            $this->line('7. Ejecuta: php artisan config:clear');
            return 1;
        } else {
            $this->info('✅ Google OAuth está configurado correctamente.');
            $this->newLine();
            $this->warn('⚠️  Recuerda agregar usuarios de prueba en Google Cloud Console:');
            $this->line('   OAuth consent screen → Test users → Add users');
            return 0;
        }
    }
}

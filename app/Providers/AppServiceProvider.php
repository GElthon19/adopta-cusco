<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Deshabilitar Vite en producción si el manifest no existe
        if (app()->environment('production')) {
            $manifestPath = public_path('build/manifest.json');
            
            if (!file_exists($manifestPath)) {
                // Registrar el problema en los logs
                \Log::warning('Vite manifest not found. Assets may not load correctly.', [
                    'expected_path' => $manifestPath,
                    'public_path' => public_path(),
                    'app_env' => app()->environment(),
                ]);
            }
        }
    }
}

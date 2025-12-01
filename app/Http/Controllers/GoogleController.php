<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // Verificar que las credenciales de Google estén configuradas
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => '❌ Google OAuth no está configurado. Contacta al administrador del sistema.'
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Verificar configuración antes de intentar autenticar
            if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
                return redirect()->route('login')->withErrors([
                    'email' => '❌ Google OAuth no está configurado correctamente.'
                ]);
            }

            $googleUser = Socialite::driver('google')->user();

            // Buscar usuario existente por email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Crear nuevo usuario con rol 'user' (NO admin)
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                    'role' => 'user' // Los usuarios de Google SIEMPRE son usuarios normales
                ]);
            } else {
                // Actualizar información de Google del usuario existente
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            // Iniciar sesión
            Auth::login($user, true);

            // Redirigir según el rol
            if ($user->role === 'admin') {
                return redirect()->route('home'); // Admin dashboard
            } else {
                return redirect()->route('usuario.index'); // Vista de usuario normal
            }
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // Si hay error de estado, reintentar la autenticación automáticamente
            return Socialite::driver('google')->redirect();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->route('login')->withErrors([
                'email' => '❌ Error de autenticación con Google. Verifica tu configuración OAuth en Google Cloud Console.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => '❌ Error al autenticar con Google: ' . $e->getMessage()
            ]);
        }
    }
}

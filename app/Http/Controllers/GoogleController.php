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
                // Determinar rol: admin si es alexcutipajara@gmail.com, sino user
                $role = ($googleUser->getEmail() === 'alexcutipajara@gmail.com') ? 'admin' : 'user';
                
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                    'role' => $role
                ]);
            } else {
                // Actualizar información de Google y verificar si debe ser admin
                $role = ($googleUser->getEmail() === 'alexcutipajara@gmail.com') ? 'admin' : $user->role;
                
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => $role
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

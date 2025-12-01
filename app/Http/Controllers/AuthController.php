<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ELIMINA COMPLETAMENTE EL MÉTODO showLoginForm
    // Ya no lo necesitamos porque la ruta maneja directamente la vista

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->filled('remember');

        $user = User::where('email', $credentials['email'])->first();

        if ($user && is_null($user->password)) {
            return back()->withErrors([
                'email' => 'Esta cuenta fue creada con Google. Inicia sesión con "Continuar con Google".'
            ])->onlyInput('email');
        }

        if (!$user) {
            return back()->withErrors([
                'email' => 'No existe una cuenta con este correo electrónico.'
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // ✅ Redirección condicional según rol
            if ($user->isAdmin()) {
                return redirect()->route('home'); // Vista de admin
            } else {
                return redirect()->route('usuario.index'); // Vista de usuario normal
            }
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar si ya existe el usuario
        $existingUser = User::where('email', 'alexcutipajara@gmail.com')->first();
        
        if ($existingUser) {
            // Si existe, actualizar rol a admin
            $existingUser->update(['role' => 'admin']);
            echo "✅ Usuario admin actualizado!\n";
            echo "📧 Email: alexcutipajara@gmail.com\n";
            echo "👑 Rol: admin\n";
            return;
        }
        
        // Si no existe, crear nuevo
        $user = User::create([
            'name' => 'Alex Cutipa',
            'email' => 'alexcutipajara@gmail.com',
            'password' => Hash::make('Juanalex4'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        if ($user) {
            echo "✅ Usuario admin creado exitosamente!\n";
            echo "📧 Email: alexcutipajara@gmail.com\n";
            echo "🔑 Contraseña: Juanalex4\n";
            echo "👑 Rol: admin\n";
        } else {
            echo "❌ Error al crear usuario admin\n";
        }
    }
}

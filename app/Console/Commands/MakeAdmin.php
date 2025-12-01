<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Convierte un usuario en administrador';

    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }
        
        $user->role = 'admin';
        $user->save();
        
        $this->info("✅ Usuario {$user->name} ({$email}) es ahora ADMIN");
        $this->info("Rol actual: {$user->role}");
        
        return 0;
    }
}

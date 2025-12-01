<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function createAnimal()
    {
        return view('usuario.animal.create'); // Esta vista debe existir
    }
    
    public function storeAnimal(Request $request)
    {
        return redirect()->route('animales.index')->with('ok', 'Animal registrado para adopción. Será revisado pronto.');
    }
}
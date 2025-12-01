<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalesAdoptadosController extends Controller
{
    public function index(Request $request)
    {
        $orden = $request->get('orden', 'recientes'); // 'recientes' o 'antiguos'

        $query = Animal::where('estado', 'Adoptado');

        if ($orden === 'antiguos') {
            $animales = $query->orderBy('updated_at', 'asc')->paginate(12);
        } else {
            $animales = $query->orderBy('updated_at', 'desc')->paginate(12);
        }

        return view('animales_adoptados.index', compact('animales', 'orden'));
    }
}

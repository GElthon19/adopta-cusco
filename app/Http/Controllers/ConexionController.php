<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conexion;

class ConexionController extends Controller
{
    public function index()
    {
        $items = Conexion::query()->latest()->paginate(20);
        return view('conexion.index', compact('items'));
    }

    public function show($id)
    {
        $item = Conexion::findOrFail($id);
        return view('conexion.show', compact('item'));
    }
}

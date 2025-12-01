<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalesController extends Controller
{
    // LISTAR TODOS LOS ANIMALES
    public function index()
    {
        $items = Animal::orderByDesc('id_animales')->paginate(10);
        return view('animales.index', compact('items'));
    }

    // MOSTRAR FORMULARIO DE CREACIÓN
    public function create()
    {
        $animal = new Animal();
        return view('animales.create', compact('animal'));
    }

    // GUARDAR NUEVO ANIMAL (con foto)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'imagen'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // 2MB
        ]);

        if ($request->hasFile('imagen')) {
            // Guarda en storage/app/public/animales
            $data['imagen'] = $request->file('imagen')->store('animales', 'public');
        }

        Animal::create($data);

        return redirect()->route('animales.index')->with('ok', '🐾 Animal registrado correctamente.');
    }

    // MOSTRAR UN ANIMAL
    public function show(Animal $animal)
    {
        return view('animales.show', compact('animal'));
    }

    // EDITAR ANIMAL
    public function edit(Animal $animal)
    {
        return view('animales.edit', compact('animal'));
    }

    // ACTUALIZAR ANIMAL (con reemplazo de foto)
    public function update(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'imagen'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            // borrar foto anterior si existe
            if (!empty($animal->imagen) && Storage::disk('public')->exists($animal->imagen)) {
                Storage::disk('public')->delete($animal->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('animales', 'public');
        }

        $animal->update($data);

        return redirect()->route('animales.index')->with('ok', '✅ Animal actualizado correctamente.');
    }

    // ELIMINAR ANIMAL (y su imagen)
    public function destroy(Animal $animal)
    {
        if (!empty($animal->imagen) && Storage::disk('public')->exists($animal->imagen)) {
            Storage::disk('public')->delete($animal->imagen);
        }
        $animal->delete();

        return redirect()->route('animales.index')->with('ok', '❌ Animal eliminado.');
    }
}

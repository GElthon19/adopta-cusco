<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampanaController extends Controller
{
    public function index()
    {
        $campanas = Campana::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.campanas.index', compact('campanas'));
    }

    public function create()
    {
        return view('admin.campanas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fecha_inicio' => 'required|date',
            'duracion_dias' => 'required|integer|min:1',
            'estado' => 'required|in:activa,finalizada,pausada'
        ]);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('img/campanas'), $nombreImagen);
            $validated['imagen'] = 'img/campanas/' . $nombreImagen;
        }

        Campana::create($validated);

        return redirect()->route('admin.campanas.index')
            ->with('ok', 'Campaña creada exitosamente');
    }

    public function edit(Campana $campana)
    {
        return view('admin.campanas.edit', compact('campana'));
    }

    public function update(Request $request, Campana $campana)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fecha_inicio' => 'required|date',
            'duracion_dias' => 'required|integer|min:1',
            'estado' => 'required|in:activa,finalizada,pausada'
        ]);

        if ($request->hasFile('imagen')) {
            // Eliminar imagen antigua
            if ($campana->imagen && file_exists(public_path($campana->imagen))) {
                unlink(public_path($campana->imagen));
            }

            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('img/campanas'), $nombreImagen);
            $validated['imagen'] = 'img/campanas/' . $nombreImagen;
        }

        $campana->update($validated);

        return redirect()->route('admin.campanas.index')
            ->with('ok', 'Campaña actualizada exitosamente');
    }

    public function destroy(Campana $campana)
    {
        // Eliminar imagen si existe
        if ($campana->imagen && file_exists(public_path($campana->imagen))) {
            unlink(public_path($campana->imagen));
        }

        $campana->delete();

        return redirect()->route('admin.campanas.index')
            ->with('ok', 'Campaña eliminada exitosamente');
    }
}

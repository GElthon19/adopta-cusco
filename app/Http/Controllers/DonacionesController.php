<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use Illuminate\Http\Request;

class DonacionesController extends Controller
{
    public function index()
    {
        $items = Donacion::orderByDesc('id')->paginate(10);
        return view('donaciones.index', compact('items'));
    }

    public function create()
    {
        $donacion = new Donacion();
        $metodos = ['Yape', 'Plin', 'Transferencia', 'Otro'];
        return view('donaciones.create', compact('donacion', 'metodos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_donante' => ['required', 'string', 'max:150'],
            'correo'         => ['nullable', 'email', 'max:150'],
            'monto'          => ['required', 'numeric', 'min:0'],
            'mensaje'        => ['nullable', 'string'],
            'metodo_pago'    => ['nullable', 'in:Yape,Plin,Transferencia,Otro'],
            'fecha_donacion' => ['nullable', 'date'],
        ]);

        if (empty($data['fecha_donacion'])) {
            $data['fecha_donacion'] = now();
        }

        Donacion::create($data);

        return redirect()->route('donaciones.index')
            ->with('ok', 'Donación registrada correctamente.');
    }

    public function edit(Donacion $donacion)
    {
        $metodos = ['Yape', 'Plin', 'Transferencia', 'Otro'];
        return view('donaciones.edit', compact('donacion', 'metodos'));
    }

    public function update(Request $request, Donacion $donacion)
    {
        $data = $request->validate([
            'nombre_donante' => ['required', 'string', 'max:150'],
            'correo'         => ['nullable', 'email', 'max:150'],
            'monto'          => ['required', 'numeric', 'min:0'],
            'mensaje'        => ['nullable', 'string'],
            'metodo_pago'    => ['nullable', 'in:Yape,Plin,Transferencia,Otro'],
            'fecha_donacion' => ['nullable', 'date'],
        ]);

        $donacion->update($data);

        return redirect()->route('donaciones.index')
            ->with('ok', 'Donación actualizada.');
    }

    public function destroy(Donacion $donacion)
    {
        $donacion->delete();
        return redirect()->route('donaciones.index')
            ->with('ok', 'Donación eliminada.');
    }
}

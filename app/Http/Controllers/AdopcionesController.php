<?php

namespace App\Http\Controllers;

use App\Models\Adopcion;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdopcionesController extends Controller
{
    /** LISTADO */
    public function index()
    {
        $items = Adopcion::with('animal')
            ->orderByDesc('id')     // PK real
            ->paginate(10);

        return view('adopciones.index', compact('items'));
    }

    /** FORM CREAR */
    public function create()
    {
        // para el select: id_animales y nombre vienen de la tabla animales
        $animales = Animal::orderBy('nombre')->get(['id_animales', 'nombre']);
        $adopcion = new Adopcion();
        
        if (auth()->user()->isAdmin()) {
            // Vista para administradores
            return view('adopciones.create', compact('animales'));
        } else {
            // Vista para usuarios normales
            return view('adopciones.screate', compact('animales'));
        }
    }

    /** GUARDAR */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_animal'          => ['required', 'integer', 'exists:animales,id_animales'],
            'adoptante_nombre'   => ['required', 'string', 'max:100'],
            'adoptante_telefono' => ['nullable', 'string', 'max:20'],
            'adoptante_email'    => ['nullable', 'email', 'max:100'],
            'adoptante_direccion'=> ['nullable', 'string'],
            'motivo_adopcion'    => ['nullable', 'string'],
            'fecha_solicitud'    => ['nullable', 'date'],
            'estado'             => ['nullable', 'in:Pendiente,Aprobada,Rechazada'],
        ]);

        // si no envían fecha, usa ahora
        if (empty($data['fecha_solicitud'])) {
            $data['fecha_solicitud'] = now();
        }
        // si no envían estado, por defecto Pendiente
        if (empty($data['estado'])) {
            $data['estado'] = 'Pendiente';
        }

        Adopcion::create($data);

        return redirect()->route('adopciones.index')->with('ok', 'Solicitud registrada.');
    }

    /** MOSTRAR (revisión por admin) */
    public function show(Adopcion $adopcion)
    {
        $adopcion->load('animal', 'admin');
        return view('adopciones.show', compact('adopcion'));
    }

    /** FORM EDITAR */
    public function edit(Adopcion $adopcion)
    {
        $animales = Animal::orderBy('nombre')->get(['id_animales', 'nombre']);
        return view('adopciones.edit', compact('adopcion', 'animales'));
    }

    /** ACTUALIZAR */
    public function update(Request $request, Adopcion $adopcion)
    {
        $data = $request->validate([
            'id_animal'          => ['required', 'integer', 'exists:animales,id_animales'],
            'adoptante_nombre'   => ['required', 'string', 'max:100'],
            'adoptante_telefono' => ['nullable', 'string', 'max:20'],
            'adoptante_email'    => ['nullable', 'email', 'max:100'],
            'adoptante_direccion'=> ['nullable', 'string'],
            'motivo_adopcion'    => ['nullable', 'string'],
            'fecha_solicitud'    => ['nullable', 'date'],
            'estado'             => ['nullable', 'in:Pendiente,Aprobada,Rechazada'],
            'respuesta_mensaje'  => ['nullable', 'string'],
        ]);

        // set admin info when processing
        $data['admin_id'] = Auth::id();
        $data['procesado_at'] = now();

        $adopcion->update($data);

        return redirect()->route('adopciones.index')->with('ok', 'Solicitud actualizada y procesada.');
    }

    /** ELIMINAR */
    public function destroy(Adopcion $adopcion)
    {
        $adopcion->delete();
        return redirect()->route('adopciones.index')->with('ok', 'Solicitud eliminada.');
    }
}
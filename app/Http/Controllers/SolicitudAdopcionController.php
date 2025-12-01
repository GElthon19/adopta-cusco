<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adopcion;
use App\Models\Animal;
use App\Helpers\NotificationHelper;

// ...existing code...
class SolicitudAdopcionController extends Controller
{
    // { changed code }
        public function create(Request $request)
    {
        $animal_id = (int) $request->input('animal_id'); // lee ?animal_id=...
        $selected_animal = null;

        if ($animal_id) {
            // usar where sobre la columna real id_animales para evitar depender del primaryKey del modelo
            $selected_animal = Animal::where('id_animales', $animal_id)->first();
        }

        if ($animal_id && !$selected_animal) {
            return redirect()->route('usuario.index')->with('error', 'El animal seleccionado no existe.');
        }

        $animales = $selected_animal
            ? collect([$selected_animal])
            : Animal::orderBy('nombre')->get(['id_animales', 'nombre']);

        return view('solicitudes_adopcion.create', compact('animales', 'selected_animal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_animal'       => ['required', 'integer', 'exists:animales,id_animales'],
            'telefono'        => ['nullable', 'string', 'max:20'],
            'direccion'       => ['nullable', 'string'],
            'motivo'          => ['nullable', 'string'],
        ]);

        // Cambiar estado del animal a "En proceso"
        $animal = Animal::where('id_animales', $data['id_animal'])->first();
        if ($animal && $animal->estado === 'Disponible') {
            $animal->update(['estado' => 'En proceso']);
        }

        // Crear solicitud de adopción online
        $adopcion = Adopcion::create([
            'id_usuario'         => auth()->id(),
            'animal_id'          => $data['id_animal'],
            'adoptante_nombre'   => auth()->user()->name,
            'adoptante_email'    => auth()->user()->email,
            'adoptante_telefono' => $data['telefono'],
            'adoptante_direccion'=> $data['direccion'],
            'motivo_adopcion'    => $data['motivo'],
            'tipo_registro'      => 'online',
            'estado'             => 'Pendiente',
            'fecha_solicitud'    => now(),
        ]);

        // Crear notificación para administradores
        NotificationHelper::newAdoptionRequest($adopcion);

        return redirect()->route('usuario.index')->with('modal_success', [
            'title' => '¡Solicitud Enviada!',
            'message' => 'Tu solicitud de adopción ha sido enviada exitosamente. Pronto nos pondremos en contacto contigo para continuar con el proceso.',
            'icon' => 'bi-check-circle-fill'
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adopcion;
use App\Models\Animal;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdopcionesController extends Controller
{
    /**
     * Lista de todas las solicitudes de adopción
     */
    public function index()
    {
        $solicitudes = Adopcion::with(['animal', 'usuario', 'admin'])
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.adopciones.index', compact('solicitudes'));
    }

    /**
     * Ver detalle de una solicitud online
     */
    public function show($id)
    {
        $solicitud = Adopcion::with(['animal', 'usuario', 'admin'])->findOrFail($id);
        return view('admin.adopciones.show', compact('solicitud'));
    }

    /**
     * Formulario para registrar adopción presencial
     */
    public function createPresencial()
    {
        $animales = Animal::where('estado', 'Disponible')
            ->orderBy('nombre')
            ->get(['id_animales', 'nombre', 'especie', 'edad']);

        return view('admin.adopciones.presencial', compact('animales'));
    }

    /**
     * Guardar adopción presencial (ya aprobada)
     */
    public function storePresencial(Request $request)
    {
        $data = $request->validate([
            'email_usuario'   => ['required', 'email', 'ends_with:gmail.com,@googlemail.com,@outlook.com,@hotmail.com,@yahoo.com'],
            'nombre_usuario'  => ['required', 'string', 'max:150'],
            'id_animal'       => ['required', 'integer', 'exists:animales,id_animales'],
            'telefono'        => ['nullable', 'string', 'max:20'],
            'direccion'       => ['nullable', 'string'],
            'motivo'          => ['nullable', 'string'],
            'observaciones'   => ['nullable', 'string'],
        ]);

        // Buscar o crear usuario temporal
        $usuario = User::firstOrCreate(
            ['email' => $data['email_usuario']],
            [
                'name' => $data['nombre_usuario'],
                'password' => bcrypt(str()->random(16)),
                'role' => 'user',
            ]
        );

        // Crear adopción presencial (ya aprobada)
        $adopcion = Adopcion::create([
            'id_usuario'         => $usuario->id,
            'animal_id'          => $data['id_animal'],
            'adoptante_nombre'   => $usuario->name,
            'adoptante_email'    => $usuario->email,
            'adoptante_telefono' => $data['telefono'],
            'adoptante_direccion'=> $data['direccion'],
            'motivo_adopcion'    => $data['motivo'],
            'tipo_registro'      => 'presencial',
            'estado'             => 'Aprobada',
            'fecha_solicitud'    => now(),
            'admin_id'           => Auth::id(),
            'observaciones'      => $data['observaciones'],
            'procesado_at'       => now(),
        ]);

        // Actualizar estado del animal a Adoptado
        $animal = Animal::where('id_animales', $data['id_animal'])->first();
        if ($animal) {
            $animal->update(['estado' => 'Adoptado']);
        }

        return redirect()->route('admin.adopciones.index')
            ->with('ok', 'Adopción presencial registrada exitosamente.');
    }

    /**
     * Aprobar solicitud online
     */
    public function aprobar(Request $request, $id)
    {
        $solicitud = Adopcion::findOrFail($id);

        // Actualizar estado del animal PRIMERO
        $animal = Animal::where('id_animales', $solicitud->animal_id)->first();
        if ($animal) {
            $animal->update(['estado' => 'Adoptado']);
            $animalNombre = $animal->nombre;
        } else {
            $animalNombre = 'el animal';
        }

        $solicitud->update([
            'estado'            => 'Aprobada',
            'admin_id'          => Auth::id(),
            'respuesta_mensaje' => $request->input('respuesta_mensaje'),
            'procesado_at'      => now(),
        ]);

        // Enviar notificación al usuario solicitante
        if ($solicitud->id_usuario) {
            Notification::create([
                'type' => 'adopcion',
                'message' => "¡Tu solicitud de adopción de {$animalNombre} ha sido APROBADA! 🎉",
                'related_id' => $solicitud->id,
                'user_id' => $solicitud->id_usuario,
                'is_read' => false,
            ]);
        }

        // Responder con JSON si es una petición AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Solicitud aprobada exitosamente']);
        }

        return redirect()->route('admin.adopciones.index')
            ->with('ok', 'Solicitud aprobada exitosamente.');
    }

    /**
     * Rechazar solicitud online
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = Adopcion::findOrFail($id);

        $solicitud->update([
            'estado'            => 'Rechazada',
            'admin_id'          => Auth::id(),
            'respuesta_mensaje' => $request->input('respuesta_mensaje'),
            'procesado_at'      => now(),
        ]);

        // Regresar el animal a estado "Disponible"
        $animal = Animal::where('id_animales', $solicitud->animal_id)->first();
        if ($animal && $animal->estado === 'En Proceso') {
            $animal->update(['estado' => 'Disponible']);
        }

        // Enviar notificación al usuario solicitante
        if ($solicitud->id_usuario) {
            $animalNombre = $animal ? $animal->nombre : 'el animal';
            
            Notification::create([
                'type' => 'adopcion',
                'message' => "Tu solicitud de adopción de {$animalNombre} no ha sido aprobada. Motivo: " . ($request->input('respuesta_mensaje') ?? 'No especificado'),
                'related_id' => $solicitud->id,
                'user_id' => $solicitud->id_usuario,
                'is_read' => false,
            ]);
        }

        // Responder con JSON si es una petición AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Solicitud rechazada']);
        }

        return redirect()->route('admin.adopciones.index')
            ->with('ok', 'Solicitud rechazada.');
    }

    /**
     * Eliminar/Cancelar adopción
     */
    public function destroy($id)
    {
        $adopcion = Adopcion::findOrFail($id);
        
        // Si la adopción estaba aprobada, devolver el animal a disponible
        if ($adopcion->estado == 'Aprobada' && $adopcion->animal_id) {
            $animal = Animal::where('id_animales', $adopcion->animal_id)->first();
            if ($animal && $animal->estado == 'Adoptado') {
                $animal->update(['estado' => 'Disponible']);
            }
        }

        $adopcion->delete();

        return redirect()->route('admin.adopciones.index')
            ->with('ok', 'Adopción eliminada exitosamente.');
    }
}

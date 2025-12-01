<?php

namespace App\Http\Controllers;

use App\Models\SolicitudDonacionAnimal;
use App\Models\AnimalDonado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\NotificationHelper;

class SolicitudDonacionAnimalController extends Controller
{
    /**
     * Mostrar formulario para donar animales
     */
    public function create()
    {
        return view('solicitudes_donacion_animal.create');
    }

    /**
     * Guardar solicitud de donación de animales (online)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'telefono'      => ['nullable', 'string', 'max:20'],
            'direccion'     => ['nullable', 'string'],
            'motivo'        => ['nullable', 'string'],
            
            // Animales (array de animales)
            'animales'                  => ['required', 'array', 'min:1'],
            'animales.*.nombre'         => ['required', 'string', 'max:100'],
            'animales.*.tipo'           => ['required', 'in:perro,gato,otro'],
            'animales.*.raza'           => ['nullable', 'string', 'max:100'],
            'animales.*.edad'           => ['nullable', 'string', 'max:50'],
            'animales.*.sexo'           => ['nullable', 'in:macho,hembra'],
            'animales.*.color'          => ['nullable', 'string', 'max:100'],
            'animales.*.descripcion'    => ['nullable', 'string'],
            'animales.*.foto'           => ['nullable', 'image', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            // Crear solicitud de donación online (pendiente)
            $solicitud = SolicitudDonacionAnimal::create([
                'id_usuario'         => Auth::id(),
                'nombre_donante'     => Auth::user()->name,
                'email_donante'      => Auth::user()->email,
                'telefono_donante'   => $data['telefono'],
                'direccion_donante'  => $data['direccion'],
                'cantidad_animales'  => count($data['animales']),
                'motivo_donacion'    => $data['motivo'],
                'tipo_registro'      => 'online',
                'estado'             => 'pendiente',
            ]);

            // Agregar cada animal a la tabla de animales donados
            foreach ($data['animales'] as $animalData) {
                // Guardar foto si existe
                $fotoPath = null;
                if (isset($animalData['foto'])) {
                    $fotoPath = $animalData['foto']->store('animales_donados', 'public');
                }

                AnimalDonado::create([
                    'id_solicitud_donacion' => $solicitud->id,
                    'nombre_animal'         => $animalData['nombre'],
                    'tipo_animal'           => $animalData['tipo'],
                    'raza'                  => $animalData['raza'],
                    'edad_aproximada'       => $animalData['edad'],
                    'sexo'                  => $animalData['sexo'],
                    'color'                 => $animalData['color'],
                    'descripcion'           => $animalData['descripcion'],
                    'foto'                  => $fotoPath,
                ]);
            }

            DB::commit();

            // Crear notificación para administradores
            NotificationHelper::newAnimalDonationRequest($solicitud);

            return redirect()->route('usuario.index')
                ->with('ok', '¡Solicitud de donación enviada! Será revisada en máximo 48 horas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al enviar solicitud: ' . $e->getMessage());
        }
    }
}

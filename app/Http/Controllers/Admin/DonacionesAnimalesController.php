<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudDonacionAnimal;
use App\Models\AnimalDonado;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonacionesAnimalesController extends Controller
{
    /**
     * Lista de todas las solicitudes de donación de animales
     */
    public function index()
    {
        $solicitudes = SolicitudDonacionAnimal::with(['usuario', 'admin', 'animales'])
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.donaciones_animales.index', compact('solicitudes'));
    }

    /**
     * Ver detalle de una solicitud online
     */
    public function show($id)
    {
        $solicitud = SolicitudDonacionAnimal::with(['usuario', 'admin', 'animales'])
            ->findOrFail($id);
        
        return view('admin.donaciones_animales.show', compact('solicitud'));
    }

    /**
     * Formulario para registrar donación presencial de animales
     */
    public function createPresencial()
    {
        return view('admin.donaciones_animales.presencial');
    }

    /**
     * Guardar donación presencial (ya aprobada)
     */
    public function storePresencial(Request $request)
    {
        $data = $request->validate([
            'email_donante'     => ['required', 'email'],
            'nombre_donante'    => ['required', 'string', 'max:150'],
            'telefono_donante'  => ['nullable', 'string', 'max:20'],
            'direccion_donante' => ['nullable', 'string'],
            'motivo_donacion'   => ['nullable', 'string'],
            'observaciones'     => ['nullable', 'string'],
            
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

        // Reindexar array de animales para evitar índices faltantes
        $data['animales'] = array_values($data['animales']);

        // Buscar o crear usuario temporal
        $usuario = User::firstOrCreate(
            ['email' => $data['email_donante']],
            [
                'name' => $data['nombre_donante'],
                'password' => bcrypt(str()->random(16)),
                'role' => 'user',
            ]
        );

        DB::beginTransaction();
        try {
            // Crear solicitud de donación presencial (ya aprobada)
            $solicitud = SolicitudDonacionAnimal::create([
                'id_usuario'         => $usuario->id,
                'nombre_donante'     => $usuario->name,
                'email_donante'      => $usuario->email,
                'telefono_donante'   => $data['telefono_donante'],
                'direccion_donante'  => $data['direccion_donante'],
                'cantidad_animales'  => count($data['animales']),
                'motivo_donacion'    => $data['motivo_donacion'],
                'tipo_registro'      => 'presencial',
                'estado'             => 'aprobado',
                'admin_id'           => Auth::id(),
                'observaciones_admin'=> $data['observaciones'],
                'procesado_at'       => now(),
            ]);

            // Agregar cada animal
            foreach ($data['animales'] as $animalData) {
                // Guardar foto si existe
                $fotoPath = null;
                if (isset($animalData['foto'])) {
                    $fotoPath = $animalData['foto']->store('animales', 'public');
                }

                // Agregar animal al albergue
                $nuevoAnimal = Animal::create([
                    'nombre'        => $animalData['nombre'],
                    'especie'       => ucfirst($animalData['tipo']),
                    'edad'          => $animalData['edad'] ?? null,
                    'descripcion'   => $animalData['descripcion'] ?? '',
                    'estado'        => 'Disponible',
                    'imagen'        => $fotoPath,
                    'fecha_ingreso' => now(),
                ]);

                // Registrar en animales_donados
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
                    'id_animal_agregado'    => $nuevoAnimal->id_animales,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.donaciones-animales.index')
                ->with('ok', 'Donación presencial registrada y animales agregados al albergue.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al registrar donación: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar solicitud online
     */
    public function aprobar(Request $request, $id)
    {
        $solicitud = SolicitudDonacionAnimal::with('animales')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Aprobar solicitud
            $solicitud->update([
                'estado'             => 'aprobado',
                'admin_id'           => Auth::id(),
                'observaciones_admin'=> $request->input('observaciones'),
                'procesado_at'       => now(),
            ]);

            // Agregar cada animal donado al albergue
            foreach ($solicitud->animales as $animalDonado) {
                $nuevoAnimal = Animal::create([
                    'nombre'        => $animalDonado->nombre_animal,
                    'especie'       => ucfirst($animalDonado->tipo_animal),
                    'edad'          => $animalDonado->edad_aproximada,
                    'descripcion'   => $animalDonado->descripcion ?? '',
                    'estado'        => 'Disponible',
                    'imagen'        => $animalDonado->foto,
                    'fecha_ingreso' => now(),
                ]);

                // Actualizar referencia
                $animalDonado->update([
                    'id_animal_agregado' => $nuevoAnimal->id_animales,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.donaciones-animales.index')
                ->with('ok', 'Solicitud aprobada y animales agregados al albergue.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al aprobar: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar solicitud online
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = SolicitudDonacionAnimal::findOrFail($id);

        $solicitud->update([
            'estado'             => 'rechazado',
            'admin_id'           => Auth::id(),
            'observaciones_admin'=> $request->input('observaciones'),
            'procesado_at'       => now(),
        ]);

        return redirect()->route('admin.donaciones-animales.index')
            ->with('ok', 'Solicitud rechazada.');
    }
}

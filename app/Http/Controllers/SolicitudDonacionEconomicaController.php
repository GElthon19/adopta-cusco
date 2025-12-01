<?php

namespace App\Http\Controllers;

use App\Models\Donaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class SolicitudDonacionEconomicaController extends Controller
{
    /**
     * Mostrar formulario para donar dinero o bienes
     */
    public function create()
    {
        return view('solicitudes_donacion_economica.create');
    }

    /**
     * Guardar donación económica (online)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'monto'    => ['required', 'numeric', 'min:1'],
            'telefono' => ['nullable', 'string', 'max:20'],
        ]);

        $donacion = Donaciones::create([
            'tipo_registro'    => 'online',
            'donante_nombre'   => Auth::user()->name,
            'donante_email'    => Auth::user()->email,
            'donante_telefono' => $data['telefono'],
            'tipo_donacion'    => 'Efectivo',
            'monto'            => $data['monto'],
            'valor_estimado'   => $data['monto'],
            'tipo_bien'        => null,
            'descripcion'      => 'Donación en efectivo realizada en línea',
            'estado'           => 'Pendiente',
            'fecha_donacion'   => now(),
        ]);

        // Crear notificación para administradores
        NotificationHelper::newDonation($donacion);

        return redirect()->route('usuario.index')->with('modal_success', [
            'title' => '¡Gracias por tu Donación!',
            'message' => 'Tu donación de S/. ' . number_format($data['monto'], 2) . ' ha sido registrada exitosamente. Será verificada en máximo 24 horas.',
            'icon' => 'bi-cash-coin'
        ]);
    }
}

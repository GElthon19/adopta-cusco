<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    /**
     * Crear notificación para todos los administradores
     */
    public static function notifyAdmins($type, $message, $relatedId = null)
    {
        // Obtener todos los usuarios con rol admin
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'type' => $type,
                'message' => $message,
                'related_id' => $relatedId,
                'user_id' => $admin->id,
                'is_read' => false,
            ]);
        }
    }

    /**
     * Crear notificación de nueva solicitud de adopción
     */
    public static function newAdoptionRequest($adopcion)
    {
        $animalNombre = $adopcion->animal->nombre ?? 'Animal';
        $adoptante = $adopcion->adoptante_nombre;
        
        self::notifyAdmins(
            'adopcion',
            "Nueva solicitud de adopción de {$adoptante} para {$animalNombre}",
            $adopcion->id
        );
    }

    /**
     * Crear notificación de nueva donación
     */
    public static function newDonation($donacion)
    {
        $donante = $donacion->donante_nombre;
        $tipo = $donacion->tipo_donacion;
        
        $mensaje = "Nueva donación de {$donante}";
        if ($tipo === 'economica') {
            $mensaje .= " - Monto: $" . $donacion->monto;
        } elseif ($tipo === 'bien') {
            $mensaje .= " - Bien: " . $donacion->tipo_bien;
        }
        
        self::notifyAdmins(
            'donacion',
            $mensaje,
            $donacion->id
        );
    }

    /**
     * Crear notificación de nueva solicitud de donación de animal
     */
    public static function newAnimalDonationRequest($solicitud)
    {
        $donante = $solicitud->donante_nombre;
        $tipo = $solicitud->tipo_animal;
        
        self::notifyAdmins(
            'donacion',
            "Nueva solicitud de donación de animal ({$tipo}) por {$donante}",
            $solicitud->id
        );
    }
}

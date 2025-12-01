<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudDonacionAnimal extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_donacion_animales';

    protected $fillable = [
        'id_usuario',
        'nombre_donante',
        'email_donante',
        'telefono_donante',
        'direccion_donante',
        'cantidad_animales',
        'motivo_donacion',
        'tipo_registro',
        'estado',
        'admin_id',
        'observaciones_admin',
        'procesado_at',
    ];

    protected $casts = [
        'procesado_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function animales()
    {
        return $this->hasMany(AnimalDonado::class, 'id_solicitud_donacion');
    }
}

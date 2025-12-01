<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;
use App\Models\User;

class Adopcion extends Model
{
    use HasFactory;

    protected $table = 'adopciones';

    protected $fillable = [
        'id_usuario',
        'animal_id',
        'adoptante_nombre',
        'adoptante_email',
        'adoptante_telefono',
        'adoptante_direccion',
        'motivo_adopcion',
        'fecha_solicitud',
        'fecha_adopcion',
        'tipo_registro',
        'estado',
        'observaciones',
        'admin_id',
        'respuesta_mensaje',
        'procesado_at',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'procesado_at'    => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'id_animales');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
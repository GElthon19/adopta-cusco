<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donaciones extends Model
{
    use HasFactory;

    protected $table = 'donaciones';

    protected $fillable = [
        'tipo_registro',
        'donante_nombre',
        'donante_email',
        'donante_telefono',
        'monto',
        'valor_estimado',
        'tipo_donacion',
        'tipo_bien',
        'descripcion',
        'fecha_donacion',
        'estado',
        'comentarios',
        'observaciones',
    ];

    public $timestamps = true;
}

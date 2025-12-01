<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'animales';
    protected $primaryKey = 'id_animales';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'especie',
        'raza',
        'edad',
        'sexo',
        'tamano',
        'estado',
        'imagen',
        'foto',
        'tipo',
        'color',
        'peso',
        'fecha_rescate',
        'historia',
        'necesidades_especiales',
        'vacunas',
        'esterilizado'
    ];
}

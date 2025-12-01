<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalDonado extends Model
{
    use HasFactory;

    protected $table = 'animales_donados';

    protected $fillable = [
        'id_solicitud_donacion',
        'nombre_animal',
        'tipo_animal',
        'raza',
        'edad_aproximada',
        'sexo',
        'color',
        'descripcion',
        'foto',
        'id_animal_agregado',
    ];

    // Relaciones
    public function solicitud()
    {
        return $this->belongsTo(SolicitudDonacionAnimal::class, 'id_solicitud_donacion');
    }

    public function animalAgregado()
    {
        return $this->belongsTo(Animal::class, 'id_animal_agregado', 'id_animales');
    }
}

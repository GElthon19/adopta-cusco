<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campana extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'fecha_inicio',
        'duracion_dias',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'duracion_dias' => 'integer'
    ];

    // Calcular fecha_fin automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($campana) {
            if ($campana->fecha_inicio && $campana->duracion_dias) {
                $campana->fecha_fin = Carbon::parse($campana->fecha_inicio)
                    ->addDays($campana->duracion_dias);
            }
        });

        static::updating(function ($campana) {
            if ($campana->isDirty(['fecha_inicio', 'duracion_dias'])) {
                $campana->fecha_fin = Carbon::parse($campana->fecha_inicio)
                    ->addDays($campana->duracion_dias);
            }
        });
    }

    // Verificar si la campaña está activa
    public function getEstaActivaAttribute()
    {
        if ($this->estado !== 'activa') {
            return false;
        }

        $hoy = Carbon::now();
        return $hoy->between($this->fecha_inicio, $this->fecha_fin);
    }

    // Obtener días restantes
    public function getDiasRestantesAttribute()
    {
        if (!$this->fecha_fin) {
            return 0;
        }

        $hoy = Carbon::now();
        if ($hoy->gt($this->fecha_fin)) {
            return 0;
        }

        return $hoy->diffInDays($this->fecha_fin);
    }

    // Scope para campañas activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa')
                     ->where('fecha_inicio', '<=', Carbon::now())
                     ->where('fecha_fin', '>=', Carbon::now());
    }
}

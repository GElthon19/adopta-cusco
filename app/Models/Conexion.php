<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conexion extends Model
{
    protected $table = 'conexion';   // o 'conexiones' si así se llama
    protected $primaryKey = 'id';    // ajusta si tu PK es otra
    public $timestamps = false;

    // pon aquí las columnas que vas a asignar masivamente
    protected $fillable = [
        // 'campo1','campo2', ...
    ];
}

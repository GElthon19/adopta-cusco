<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animales extends Model {
    use HasFactory;
    protected $table = 'animales';
    protected $fillable = ["id_animales"];
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalesDonados extends Model {
    use HasFactory;
    protected $table = 'animales_donados';
    protected $fillable = ["id_animales_donados"];
}

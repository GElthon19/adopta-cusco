<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'content',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtener el contenido de un bloque por su key
     */
    public static function getContent($key, $default = '')
    {
        $block = self::where('key', $key)->where('is_active', true)->first();
        return $block ? $block->content : $default;
    }
}

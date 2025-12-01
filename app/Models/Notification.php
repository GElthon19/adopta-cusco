<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'related_id',
        'is_read',
        'user_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // Relación con el usuario (admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para marcar como leída
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Scope para notificaciones no leídas
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}

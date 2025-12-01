<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Obtener todas las notificaciones del admin autenticado
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    // Obtener notificaciones no leídas (para el contador)
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    // Marcar una notificación como leída
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    // Marcar todas como leídas
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }

    /**
     * Obtener notificaciones para el dropdown con información adicional
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDropdownNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $isAdmin = Auth::user()->role === 'admin';

        $formattedNotifications = $notifications->map(function ($notification) use ($isAdmin) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'message' => $notification->message,
                'is_read' => $notification->is_read,
                'time_ago' => $notification->created_at->diffForHumans(),
                'related_id' => $notification->related_id,
                'can_action' => $isAdmin && !$notification->is_read && $notification->related_id,
                'can_approve' => $isAdmin && !$notification->is_read && $notification->type === 'adopcion',
                'view_url' => $this->getViewUrl($notification),
            ];
        });

        $unreadCount = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $formattedNotifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Obtener la URL para ver una notificación
     * @param Notification $notification
     * @return string
     */
    private function getViewUrl($notification)
    {
        if ($notification->type === 'adopcion' && $notification->related_id) {
            return route('admin.adopciones.show', $notification->related_id);
        } elseif ($notification->type === 'donacion' && $notification->related_id) {
            // Para donaciones económicas
            return route('admin.donaciones.show', $notification->related_id);
        } elseif ($notification->type === 'donacion_animal' && $notification->related_id) {
            // Para donaciones de animales
            return route('admin.donaciones-animales.show', $notification->related_id);
        }
        
        return route('notifications.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Adopcion;
use App\Models\Donaciones;
use App\Models\SolicitudDonacionAnimal;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener fechas del request o usar valores por defecto
        $fechaInicio = $request->get('fecha_inicio', now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        // Estadísticas generales con filtro de fecha
        $stats = [
            'total_animales' => Animal::whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'animales_adoptados' => Animal::where('estado', 'Adoptado')
                ->whereBetween('updated_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'animales_disponibles' => Animal::where('estado', 'Disponible')->count(),
            'animales_en_proceso' => Animal::where('estado', 'En proceso')->count(),
            'total_adopciones' => Adopcion::whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'adopciones_pendientes' => Adopcion::where('estado', 'Pendiente')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'adopciones_aprobadas' => Adopcion::where('estado', 'Aprobada')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'adopciones_rechazadas' => Adopcion::where('estado', 'Rechazada')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'solicitudes_respondidas' => Adopcion::whereIn('estado', ['Aprobada', 'Rechazada'])
                ->whereBetween('procesado_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'total_donaciones' => Donaciones::whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'monto_total_donaciones' => Donaciones::whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->sum('monto'),
            'donaciones_pendientes' => Donaciones::where('estado', 'Pendiente')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'donaciones_verificadas' => Donaciones::where('estado', 'Verificada')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
            'solicitudes_animales_pendientes' => SolicitudDonacionAnimal::where('estado', 'pendiente')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])->count(),
        ];

        // Datos para gráficos con filtro de fecha
        $adopcionesPorMes = Adopcion::selectRaw('DATE(created_at) as fecha, COUNT(*) as total')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $donacionesPorMes = Donaciones::selectRaw('DATE(created_at) as fecha, SUM(monto) as total')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $animalesPorTipo = Animal::selectRaw('especie, COUNT(*) as total')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin . ' 23:59:59'])
            ->groupBy('especie')
            ->get();

        // Actividad reciente
        $recentActivities = collect([
            (object)[
                'icon' => 'house-heart-fill',
                'action' => 'Adopción aprobada',
                'details' => 'Aprobaste la solicitud de adopción',
                'time' => Adopcion::where('estado', 'Aprobada')->latest('updated_at')->first()?->updated_at ?? now()
            ],
            (object)[
                'icon' => 'heart-fill',
                'action' => 'Animal registrado',
                'details' => 'Agregaste un nuevo animal al sistema',
                'time' => Animal::latest()->first()?->created_at ?? now()
            ],
            (object)[
                'icon' => 'cash-coin',
                'action' => 'Donación registrada',
                'details' => 'Registraste una donación económica',
                'time' => Donaciones::latest()->first()?->created_at ?? now()
            ],
        ])->sortByDesc('time')->take(5);

        return view('layouts.admin.dashboard', compact(
            'stats', 
            'adopcionesPorMes', 
            'donacionesPorMes', 
            'animalesPorTipo',
            'recentActivities',
            'fechaInicio',
            'fechaFin'
        ));
    }
}

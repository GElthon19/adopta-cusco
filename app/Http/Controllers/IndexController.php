<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Adopcion;
use App\Models\Donaciones;
use App\Models\SolicitudDonacionAnimal;
use App\Models\Campana;

class IndexController extends Controller
{
    public function index()
    {
        // Verificar si el usuario es admin
        if (auth()->user()->isAdmin()) {
            // Redirigir al dashboard con gráficos
            return redirect()->route('admin.dashboard');
        }

        // Obtener estadísticas básicas con manejo de errores
        try {
            $totalAnimales = Animal::count();
        } catch (\Exception $e) {
            $totalAnimales = 0;
        }

        try {
            $totalAdopciones = Adopcion::count();
        } catch (\Exception $e) {
            $totalAdopciones = 0;
        }

        try {
            $totalDonaciones = Donaciones::count();
        } catch (\Exception $e) {
            $totalDonaciones = 0;
        }

        try {
            $totalSolicitudesDonacion = SolicitudDonacionAnimal::count();
        } catch (\Exception $e) {
            $totalSolicitudesDonacion = 0;
        }

        // Obtener últimos animales registrados
        try {
            $latest = Animal::latest()->take(3)->get();
        } catch (\Exception $e) {
            $latest = collect(); // Colección vacía
        }

        // Obtener últimas solicitudes de adopción
        try {
            $latestSolicitudes = Adopcion::with(['animal', 'usuario'])
                ->latest()
                ->take(3)
                ->get();
        } catch (\Exception $e) {
            $latestSolicitudes = collect();
        }

        // Obtener últimas donaciones
        try {
            $latestDon = Donaciones::latest()->take(3)->get();
        } catch (\Exception $e) {
            $latestDon = collect(); // Colección vacía
        }

        // Obtener campañas activas
        try {
            $campanasActivas = Campana::activas()->take(3)->get();
        } catch (\Exception $e) {
            $campanasActivas = collect();
        }

        return view('home', compact(
            'totalAnimales',
            'totalAdopciones',
            'totalDonaciones',
            'totalSolicitudesDonacion',
            'latest',
            'latestSolicitudes',
            'latestDon',
            'campanasActivas'
        ));
    }

    public function usuario(Request $request)
    {
        try {
            $totalAnimales = Animal::count();
        } catch (\Exception $e) {
            $totalAnimales = 0;
        }

        try {
            $totalAdopciones = Adopcion::count();
        } catch (\Exception $e) {
            $totalAdopciones = 0;
        }

        try {
            $totalDonaciones = Donaciones::count();
        } catch (\Exception $e) {
            $totalDonaciones = 0;
        }

        $query = Animal::query();

        // Solo mostrar animales disponibles para adopción
        $query->where('estado', 'Disponible');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('nombre', 'like', "%{$searchTerm}%");
        }

        $animales = $query->orderBy('nombre')->paginate(12); // <- Cambiado de get() a paginate()

        return view('usuario.user', compact(
            'totalAnimales',
            'totalAdopciones',
            'totalDonaciones',
            'animales'
        ));
    }

    public function show($id)
    {
        // Método para mostrar un elemento específico si es necesario
        return view('home');
    }
}
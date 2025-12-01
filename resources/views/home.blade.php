@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Inicio - Administrador')

@section('content')

{{-- CONTENEDOR PRINCIPAL CON FONDO --}}
<div class="contenedor-principal">
    <div class="envoltorio-contenido">
        <div class="container-fluid">
            
            {{-- FILA PRINCIPAL SIN ASIDES --}}
            <div class="row justify-content-center">
                {{-- Contenido central - 100% width --}}
                <div class="col-12">
                    {{-- BLOQUE PRINCIPAL --}}
                    <div class="p-4 p-md-5 mb-4 bg-white border rounded-3 shadow-sm">
                        <div class="container py-3 text-center">
                            <h1 class="display-5 fw-bold mb-2"><i class="bi bi-speedometer2"></i> Panel de Administración</h1>
                            <p class="lead mb-4">Gestiona las solicitudes de adopción y donaciones del sistema</p>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('animales.index') }}" class="btn btn-primary">Ver animales</a>
                                <a href="{{ route('admin.adopciones.index') }}" class="btn btn-outline-secondary">Ver Solicitudes de Adopción</a>
                                <a href="{{ route('admin.donaciones-animales.index') }}" class="btn btn-outline-secondary">Ver Solicitudes de Donación de Animales</a>
                                <a href="{{ route('admin.donaciones.index') }}" class="btn btn-outline-secondary">Ver Donaciones</a>
                            </div>
                        </div>
                    </div>

                    {{-- ESTADÍSTICAS --}}
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">Animales registrados</h5>
                                    <p class="display-6 mb-0 fw-bold">{{ $totalAnimales }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">Solicitudes de Adopción</h5>
                                    <p class="display-6 mb-0 fw-bold">{{ $totalAdopciones }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">Solicitudes de Donación</h5>
                                    <p class="display-6 mb-0 fw-bold">{{ $totalSolicitudesDonacion ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">Donaciones</h5>
                                    <p class="display-6 mb-0 fw-bold">{{ $totalDonaciones }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Últimos animales registrados --}}
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">Últimos animales registrados</h2>
                            <a href="{{ route('animales.index') }}" class="btn btn-outline-primary btn-sm">Ver todos</a>
                        </div>

                        @if($latest->count())
                        <div class="row g-3">
                            @foreach($latest as $a)
                            <div class="col-12 col-md-4 col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1">{{ $a->nombre ?? 'Sin nombre' }}</h5>
                                        <p class="text-muted small mb-3">{{ Str::limit($a->descripcion ?? 'Sin descripción.', 90) }}</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('animales.edit', $a->id_animales) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                                            <a href="{{ route('animales.show', $a->id_animales) }}" class="btn btn-link btn-sm">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted">Aún no hay registros de animales.</p>
                        @endif
                    </div>

                    {{-- Últimas solicitudes de adopción --}}
                    @if(isset($latestSolicitudes) && $latestSolicitudes->count())
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">Últimas Solicitudes de Adopción</h2>
                            <a href="{{ route('admin.adopciones.index') }}" class="btn btn-outline-primary btn-sm">Ver todas</a>
                        </div>
                        <div class="row g-3">
                            @foreach($latestSolicitudes as $solicitud)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-1">{{ $solicitud->usuario->name ?? 'Usuario' }}</h6>
                                        <p class="text-muted small mb-1">Animal: {{ $solicitud->animal->nombre ?? 'N/A' }}</p>
                                        <p class="text-muted small mb-1">Estado: 
                                            <span class="badge bg-{{ $solicitud->estado == 'aprobado' ? 'success' : ($solicitud->estado == 'rechazado' ? 'danger' : 'warning') }}">
                                                {{ $solicitud->estado }}
                                            </span>
                                        </p>
                                        <p class="text-muted small mb-0">Fecha: {{ $solicitud->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Últimas donaciones --}}
                    @if(isset($latestDon) && $latestDon->count())
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0">Últimas Donaciones</h2>
                            <a href="{{ route('admin.donaciones.index') }}" class="btn btn-outline-primary btn-sm">Ver todas</a>
                        </div>
                        <div class="row g-3">
                            @foreach($latestDon as $d)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-1">{{ $d->donante ?? 'Anónimo' }}</h6>
                                        <p class="text-muted small mb-1">Monto: S/ {{ number_format($d->monto, 2) }}</p>
                                        <p class="text-muted small mb-1">Fecha: {{ $d->created_at->format('d/m/Y') }}</p>
                                        <p class="text-muted small mb-0">{{ Str::limit($d->mensaje ?? '', 80) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Campañas Activas --}}
                    @if(isset($campanasActivas) && $campanasActivas->count() > 0)
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 mb-0"><i class="bi bi-megaphone-fill"></i> Campañas Activas</h2>
                            @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline-primary btn-sm">Gestionar</a>
                            @endif
                        </div>
                        <div class="row g-3">
                            @foreach($campanasActivas as $campana)
                            <div class="col-12 col-md-4">
                                <div class="card shadow-sm h-100">
                                    @if($campana->imagen)
                                    <img src="{{ asset($campana->imagen) }}" class="card-img-top" alt="{{ $campana->titulo }}" 
                                         style="height: 200px; object-fit: cover;">
                                    @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="bi bi-megaphone" style="font-size: 3em;"></i>
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $campana->titulo }}</h5>
                                        <p class="card-text text-muted small">{{ Str::limit($campana->descripcion, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="badge bg-success">
                                                <i class="bi bi-calendar-check"></i> {{ $campana->dias_restantes }} días restantes
                                            </span>
                                            <small class="text-muted">Hasta {{ $campana->fecha_fin->format('d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Acciones rápidas --}}
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm">
                        <h2 class="h5 mb-3">Acciones Rápidas</h2>
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">➕ Nuevo Animal</h6>
                                        <a href="{{ route('animales.create') }}" class="btn btn-primary btn-sm w-100">Registrar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title"><i class="bi bi-clipboard-check"></i> Gestionar Adopciones</h6>
                                        <a href="{{ route('admin.adopciones.index') }}" class="btn btn-warning btn-sm w-100">Revisar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title"><i class="bi bi-gift-fill"></i> Solicitudes Donación</h6>
                                        <a href="{{ route('admin.donaciones-animales.index') }}" class="btn btn-info btn-sm w-100">Ver</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">
                                        <h6 class="card-title"><i class="bi bi-cash-coin"></i> Donaciones</h6>
                                        <a href="{{ route('admin.donaciones.index') }}" class="btn btn-success btn-sm w-100">Administrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
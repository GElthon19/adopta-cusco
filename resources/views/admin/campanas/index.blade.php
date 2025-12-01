@extends('layouts.app')
@section('title', 'Gestión de Campañas - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Volver al Dashboard
            </a>
            <h1 class="h3 mb-0"><i class="bi bi-megaphone-fill"></i> Gestión de Campañas</h1>
        </div>
        <a href="{{ route('admin.campanas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Campaña
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Título</th>
                            <th>Fecha Inicio</th>
                            <th>Duración</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campanas as $campana)
                        <tr>
                            <td>
                                @if($campana->imagen)
                                    <img src="{{ asset($campana->imagen) }}" alt="{{ $campana->titulo }}" 
                                         style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 60px; border-radius: 8px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $campana->titulo }}</strong><br>
                                <small class="text-muted">{{ Str::limit($campana->descripcion, 50) }}</small>
                            </td>
                            <td>{{ $campana->fecha_inicio->format('d/m/Y') }}</td>
                            <td>{{ $campana->duracion_dias }} días</td>
                            <td>{{ $campana->fecha_fin ? $campana->fecha_fin->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($campana->estado == 'activa' && $campana->esta_activa)
                                    <span class="badge bg-success">Activa</span>
                                    <br><small class="text-muted">{{ $campana->dias_restantes }} días restantes</small>
                                @elseif($campana->estado == 'pausada')
                                    <span class="badge bg-warning text-dark">Pausada</span>
                                @else
                                    <span class="badge bg-secondary">Finalizada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.campanas.edit', $campana) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.campanas.destroy', $campana) }}" method="POST" 
                                      style="display: inline;" 
                                      onsubmit="return confirm('¿Estás seguro de eliminar esta campaña?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3em; opacity: 0.3;"></i>
                                <p class="mt-2">No hay campañas registradas</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($campanas->hasPages())
            <div class="mt-3">
                {{ $campanas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

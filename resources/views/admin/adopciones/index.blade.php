@extends('layouts.app')
@section('title', 'Gestión de Adopciones - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <h1 class="h3 mb-0"><i class="bi bi-clipboard-check"></i> Solicitudes de Adopción</h1>
        </div>
        <a href="{{ route('admin.adopciones.presencial.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Adopción Presencial
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Aprobada" {{ request('estado') == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="Rechazada" {{ request('estado') == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="online" {{ request('tipo') == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="presencial" {{ request('tipo') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="buscar" class="form-control" placeholder="Nombre o email" value="{{ request('buscar') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de solicitudes -->
    @if($solicitudes->count())
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Animal</th>
                            <th>Solicitante</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr>
                            <td><strong>#{{ $solicitud->id }}</strong></td>
                            <td>
                                @if($solicitud->animal)
                                    <i class="bi bi-circle-fill"></i> {{ $solicitud->animal->nombre }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $solicitud->adoptante_nombre }}</td>
                            <td>{{ $solicitud->adoptante_email }}</td>
                            <td>
                                @if($solicitud->tipo_registro == 'presencial')
                                    <span class="badge bg-info">🏢 Presencial</span>
                                @else
                                    <span class="badge bg-secondary">🌐 Online</span>
                                @endif
                            </td>
                            <td>
                                @if($solicitud->estado == 'Pendiente')
                                    <span class="badge bg-warning text-dark">⏳ Pendiente</span>
                                @elseif($solicitud->estado == 'Aprobada')
                                    <span class="badge bg-success">✅ Aprobada</span>
                                @else
                                    <span class="badge bg-danger">❌ Rechazada</span>
                                @endif
                            </td>
                            <td>{{ $solicitud->fecha_solicitud ? $solicitud->fecha_solicitud->format('d/m/Y') : '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.adopciones.show', $solicitud->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Ver Detalle
                                </a>
                                <form action="{{ route('admin.adopciones.destroy', $solicitud->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta adopción? Si está aprobada, el animal volverá a estar disponible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $solicitudes->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        No hay solicitudes registradas.
    </div>
    @endif
</div>
@endsection

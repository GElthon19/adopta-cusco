@extends('layouts.app')
@section('title', 'Gestión de Donaciones de Animales - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <h1 class="h3 mb-0"><i class="bi bi-gift-fill"></i> Solicitudes de Donación de Animales</h1>
        </div>
        <a href="{{ route('admin.donaciones-animales.presencial.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Donación Presencial
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
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
                        <option value="pendiente">Pendiente</option>
                        <option value="aprobado">Aprobado</option>
                        <option value="rechazado">Rechazado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="online">Online</option>
                        <option value="presencial">Presencial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="buscar" class="form-control" placeholder="Nombre o email">
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
                            <th>Donante</th>
                            <th>Email</th>
                            <th>Cantidad Animales</th>
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
                            <td>{{ $solicitud->nombre_donante }}</td>
                            <td>{{ $solicitud->email_donante }}</td>
                            <td>
                                <span class="badge bg-info">{{ $solicitud->cantidad_animales }} animal(es)</span>
                            </td>
                            <td>
                                @if($solicitud->tipo_registro == 'presencial')
                                    <span class="badge bg-info">🏢 Presencial</span>
                                @else
                                    <span class="badge bg-secondary">🌐 Online</span>
                                @endif
                            </td>
                            <td>
                                @if($solicitud->estado == 'pendiente')
                                    <span class="badge bg-warning text-dark">⏳ Pendiente</span>
                                @elseif($solicitud->estado == 'aprobado')
                                    <span class="badge bg-success">✅ Aprobado</span>
                                @else
                                    <span class="badge bg-danger">❌ Rechazado</span>
                                @endif
                            </td>
                            <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.donaciones-animales.show', $solicitud->id) }}" class="btn btn-sm btn-outline-primary">
                                    Ver Detalle
                                </a>
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
        No hay solicitudes de donación registradas.
    </div>
    @endif
</div>
@endsection

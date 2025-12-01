@extends('layouts.app')
@section('title', 'Gestión de Donaciones - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <h1 class="h3 mb-0"><i class="bi bi-cash-coin"></i> Donaciones Económicas y Bienes</h1>
        </div>
        <a href="{{ route('admin.donaciones.presencial.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Registrar Donación Presencial
        </a>
    </div>

    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" style="margin-top: 10px;">
            {{ session('ok') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total en Efectivo</h5>
                    <h2>S/. {{ number_format($totalMonto, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total de Donaciones</h5>
                    <h2>{{ $donaciones->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Este Mes</h5>
                    <h2>{{ $donaciones->where('created_at', '>=', now()->startOfMonth())->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select">
                        <option value="">Todos</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Alimentos">Alimentos</option>
                        <option value="Medicinas">Medicinas</option>
                        <option value="Otros">Otros</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Registro</label>
                    <select name="registro" class="form-select">
                        <option value="">Todos</option>
                        <option value="online">Online</option>
                        <option value="presencial">Presencial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" name="buscar" class="form-control" placeholder="Nombre del donante">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de donaciones -->
    @if($donaciones->count())
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Donante</th>
                            <th>Tipo</th>
                            <th>Monto/Valor</th>
                            <th>Descripción</th>
                            <th>Registro</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donaciones as $donacion)
                        <tr>
                            <td><strong>#{{ $donacion->id }}</strong></td>
                            <td>{{ $donacion->donante_nombre ?? $donacion->donante ?? 'Anónimo' }}</td>
                            <td>
                                @if($donacion->tipo_donacion == 'Efectivo')
                                    <span class="badge bg-success"><i class="bi bi-cash"></i> Efectivo</span>
                                @elseif($donacion->tipo_donacion == 'Alimentos')
                                    <span class="badge bg-warning text-dark"><i class="bi bi-basket-fill"></i> Alimentos</span>
                                @elseif($donacion->tipo_donacion == 'Medicinas')
                                    <span class="badge bg-danger"><i class="bi bi-capsule"></i> Medicinas</span>
                                @else
                                    <span class="badge bg-info">📦 Otros</span>
                                @endif
                            </td>
                            <td>
                                @if($donacion->tipo_donacion == 'Efectivo')
                                    <strong class="text-success">S/. {{ number_format($donacion->monto, 2) }}</strong>
                                @else
                                    {{ $donacion->valor_estimado ? 'S/. ' . number_format($donacion->valor_estimado, 2) : 'No valorado' }}
                                @endif
                            </td>
                            <td>{{ Str::limit($donacion->descripcion ?? $donacion->comentarios ?? '—', 30) }}</td>
                            <td>
                                @if($donacion->tipo_registro == 'presencial')
                                    <span class="badge bg-info">🏢 Presencial</span>
                                @else
                                    <span class="badge bg-secondary">🌐 Online</span>
                                @endif
                            </td>
                            <td>{{ $donacion->fecha_donacion ? \Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y') : $donacion->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($donacion->estado == 'Recibida')
                                    <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Recibida</span>
                                @elseif($donacion->estado == 'Verificada')
                                    <span class="badge bg-primary">✔️ Verificada</span>
                                @else
                                    <span class="badge bg-warning text-dark">⏳ Pendiente</span>
                                @endif
                            </td>
                            <td>
                                @if($donacion->estado == 'Pendiente')
                                    <form action="{{ route('admin.donaciones.verificar', $donacion->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Marcar como verificada">
                                            <i class="bi bi-check-circle"></i> Verificar
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.donaciones.show', $donacion->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $donaciones->links() }}
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        No hay donaciones registradas.
    </div>
    @endif
</div>
@endsection

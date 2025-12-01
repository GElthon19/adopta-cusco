@extends('layouts.app')
@section('title', 'Detalle de Donación - Admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.donaciones.index') }}" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Volver a Donaciones
        </a>
        <h1 class="h3"><i class="bi bi-cash-coin"></i> Detalle de Donación</h1>
    </div>

    <div class="row">
        <!-- Información de la Donación -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información de la Donación</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>ID de Donación:</strong>
                            <p class="text-muted">#{{ $donacion->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo de Donación:</strong>
                            <p>
                                @if($donacion->tipo_donacion == 'Efectivo')
                                    <span class="badge bg-success">
                                        <i class="bi bi-cash"></i> Efectivo
                                    </span>
                                @elseif($donacion->tipo_donacion == 'Alimentos')
                                    <span class="badge bg-info">
                                        <i class="bi bi-basket"></i> Alimentos
                                    </span>
                                @elseif($donacion->tipo_donacion == 'Medicinas')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-capsule"></i> Medicinas
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-box"></i> {{ $donacion->tipo_donacion }}
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <p>
                                @if($donacion->estado == 'Verificada')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Verificada
                                    </span>
                                @elseif($donacion->estado == 'Pendiente')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-clock"></i> Pendiente
                                    </span>
                                @else
                                    <span class="badge bg-secondary">{{ $donacion->estado }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo de Registro:</strong>
                            <p>
                                @if($donacion->tipo_registro == 'online')
                                    <span class="badge bg-primary">
                                        <i class="bi bi-globe"></i> En Línea
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="bi bi-building"></i> Presencial
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        @if($donacion->tipo_donacion == 'Efectivo')
                        <div class="col-md-6">
                            <strong>Monto:</strong>
                            <p class="text-success fs-4">S/. {{ number_format($donacion->monto, 2) }}</p>
                        </div>
                        @else
                        <div class="col-md-6">
                            <strong>Valor Estimado:</strong>
                            <p class="text-success fs-5">S/. {{ number_format($donacion->valor_estimado ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo de Bien:</strong>
                            <p class="text-muted">{{ $donacion->tipo_bien ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>

                    @if($donacion->descripcion)
                    <div class="mb-3">
                        <strong>Descripción:</strong>
                        <p class="text-muted">{{ $donacion->descripcion }}</p>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Fecha de Donación:</strong>
                            <p class="text-muted">
                                <i class="bi bi-calendar"></i> 
                                {{ $donacion->fecha_donacion ? \Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Registrado:</strong>
                            <p class="text-muted">
                                <i class="bi bi-clock"></i> 
                                {{ $donacion->created_at ? $donacion->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Donante -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Información del Donante</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Nombre:</strong>
                        <p class="text-muted">{{ $donacion->donante_nombre ?? 'No especificado' }}</p>
                    </div>

                    @if($donacion->donante_email)
                    <div class="mb-3">
                        <strong>Email:</strong>
                        <p class="text-muted">
                            <i class="bi bi-envelope"></i> {{ $donacion->donante_email }}
                        </p>
                    </div>
                    @endif

                    @if($donacion->donante_telefono)
                    <div class="mb-3">
                        <strong>Teléfono:</strong>
                        <p class="text-muted">
                            <i class="bi bi-telephone"></i> {{ $donacion->donante_telefono }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            @if($donacion->estado == 'Pendiente')
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-gear"></i> Acciones</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.donaciones.verificar', $donacion->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Verificar Donación
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

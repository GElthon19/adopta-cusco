@extends('layouts.app')
@section('title', 'Detalle de Donación de Animales')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.donaciones-animales.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a la lista
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="bi bi-gift-fill"></i> Solicitud de Donación de Animales #{{ $solicitud->id }}</h4>
        </div>
        <div class="card-body">
            <!-- Estado actual -->
            <div class="alert alert-{{ $solicitud->estado == 'pendiente' ? 'warning' : ($solicitud->estado == 'aprobado' ? 'success' : 'danger') }}">
                <strong>Estado:</strong>
                @if($solicitud->estado == 'pendiente')
                    ⏳ Pendiente de revisión
                @elseif($solicitud->estado == 'aprobado')
                    <i class="bi bi-check-circle-fill"></i> Aprobado - Animales agregados al albergue
                @else
                    <i class="bi bi-x-circle-fill"></i> Rechazado
                @endif
            </div>

            <div class="row">
                <!-- Donante -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-person-fill"></i> Datos del Donante</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{ $solicitud->nombre_donante }}</p>
                            <p><strong>Email:</strong> {{ $solicitud->email_donante }}</p>
                            <p><strong>Teléfono:</strong> {{ $solicitud->telefono_donante ?? 'No proporcionado' }}</p>
                            <p><strong>Dirección:</strong> {{ $solicitud->direccion_donante ?? 'No proporcionada' }}</p>
                            <p><strong>Tipo de registro:</strong> 
                                @if($solicitud->tipo_registro == 'presencial')
                                    <span class="badge bg-info">🏢 Presencial</span>
                                @else
                                    <span class="badge bg-secondary">🌐 Online</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Información general -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> Información de la Donación</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Cantidad de animales:</strong> {{ $solicitud->cantidad_animales }}</p>
                            <p><strong>Fecha de solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                            
                            @if($solicitud->procesado_at)
                                <p><strong>Procesado el:</strong> {{ $solicitud->procesado_at->format('d/m/Y H:i') }}</p>
                                @if($solicitud->admin)
                                    <p><strong>Procesado por:</strong> {{ $solicitud->admin->name }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motivo -->
            @if($solicitud->motivo_donacion)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💭 Motivo de Donación</h5>
                </div>
                <div class="card-body">
                    <p>{{ $solicitud->motivo_donacion }}</p>
                </div>
            </div>
            @endif

            <!-- Animales donados -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-list-ul"></i> Animales Donados ({{ $solicitud->animales->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($solicitud->animales as $animal)
                        <div class="col-md-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $animal->nombre_animal }}</h6>
                                    <p class="mb-1"><strong>Tipo:</strong> {{ ucfirst($animal->tipo_animal) }}</p>
                                    @if($animal->raza)
                                        <p class="mb-1"><strong>Raza:</strong> {{ $animal->raza }}</p>
                                    @endif
                                    @if($animal->edad_aproximada)
                                        <p class="mb-1"><strong>Edad:</strong> {{ $animal->edad_aproximada }}</p>
                                    @endif
                                    @if($animal->sexo)
                                        <p class="mb-1"><strong>Sexo:</strong> {{ ucfirst($animal->sexo) }}</p>
                                    @endif
                                    @if($animal->color)
                                        <p class="mb-1"><strong>Color:</strong> {{ $animal->color }}</p>
                                    @endif
                                    @if($animal->descripcion)
                                        <p class="mb-1"><strong>Descripción:</strong> {{ $animal->descripcion }}</p>
                                    @endif
                                    
                                    @if($animal->foto)
                                        <img src="{{ asset('storage/' . $animal->foto) }}" alt="{{ $animal->nombre_animal }}" class="img-fluid rounded mt-2" style="max-height: 150px;">
                                    @endif

                                    @if($animal->id_animal_agregado)
                                        <div class="alert alert-success mt-2 mb-0">
                                            <small><i class="bi bi-check-circle-fill"></i> Agregado al albergue (ID: #{{ $animal->id_animal_agregado }})</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Observaciones del admin -->
            @if($solicitud->observaciones_admin)
            <div class="alert alert-secondary">
                <strong>Observaciones del administrador:</strong><br>
                {{ $solicitud->observaciones_admin }}
            </div>
            @endif

            <!-- Acciones (solo si está pendiente) -->
            @if($solicitud->estado == 'pendiente')
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">⚡ Acciones</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.donaciones-animales.aprobar', $solicitud->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Observaciones (opcional)</label>
                            <textarea name="observaciones" class="form-control" rows="3" placeholder="Animales verificados, en buen estado..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('¿Aprobar esta donación y agregar los animales al albergue?')">
                            <i class="bi bi-check-circle-fill"></i> Aprobar y Agregar al Albergue
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('admin.donaciones-animales.rechazar', $solicitud->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Motivo del rechazo</label>
                            <textarea name="observaciones" class="form-control" rows="3" placeholder="Razones del rechazo..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Rechazar esta donación?')">
                            <i class="bi bi-x-circle-fill"></i> Rechazar Donación
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

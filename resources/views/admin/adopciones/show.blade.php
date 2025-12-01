@extends('layouts.app')
@section('title', 'Detalle de Solicitud de Adopción')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.adopciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a la lista
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-clipboard-check"></i> Solicitud de Adopción #{{ $solicitud->id }}</h4>
        </div>
        <div class="card-body">
            <!-- Estado actual -->
            <div class="alert alert-{{ $solicitud->estado == 'Pendiente' ? 'warning' : ($solicitud->estado == 'Aprobada' ? 'success' : 'danger') }}">
                <strong>Estado:</strong>
                @if($solicitud->estado == 'Pendiente')
                    ⏳ Pendiente de revisión
                @elseif($solicitud->estado == 'Aprobada')
                    ✅ Aprobada
                @else
                    ❌ Rechazada
                @endif
            </div>

            <div class="row">
                <!-- Animal -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-circle-fill"></i> Animal Solicitado</h5>
                        </div>
                        <div class="card-body">
                            @if($solicitud->animal)
                                <p><strong>Nombre:</strong> {{ $solicitud->animal->nombre }}</p>
                                <p><strong>Especie:</strong> {{ $solicitud->animal->especie }}</p>
                                <p><strong>Edad:</strong> {{ $solicitud->animal->edad ?? 'No especificada' }}</p>
                                <p><strong>Estado:</strong> 
                                    <span class="badge bg-{{ $solicitud->animal->estado == 'Disponible' ? 'success' : 'secondary' }}">
                                        {{ $solicitud->animal->estado }}
                                    </span>
                                </p>
                                @if($solicitud->animal->imagen)
                                    <img src="{{ asset('img/' . $solicitud->animal->imagen) }}" 
                                         alt="{{ $solicitud->animal->nombre }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px; object-fit: cover;"
                                         onerror="this.src='{{ asset('img/default-pet.webp') }}'">
                                @else
                                    <img src="{{ asset('img/default-pet.webp') }}" 
                                         alt="Sin imagen" 
                                         class="img-fluid rounded" 
                                         style="max-height: 200px; object-fit: cover;">
                                @endif
                            @else
                                <p class="text-muted">Animal no disponible</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Solicitante -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-person-fill"></i> Datos del Solicitante</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{ $solicitud->adoptante_nombre }}</p>
                            <p><strong>Email:</strong> {{ $solicitud->adoptante_email ?? 'No proporcionado' }}</p>
                            <p><strong>Teléfono:</strong> {{ $solicitud->adoptante_telefono ?? 'No proporcionado' }}</p>
                            <p><strong>Dirección:</strong> {{ $solicitud->adoptante_direccion ?? 'No proporcionada' }}</p>
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
            </div>

            <!-- Motivo -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">💭 Motivo de Adopción</h5>
                </div>
                <div class="card-body">
                    <p>{{ $solicitud->motivo_adopcion ?? 'No especificado' }}</p>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📅 Información Adicional</h5>
                </div>
                <div class="card-body">
                    <p><strong>Fecha de solicitud:</strong> {{ $solicitud->fecha_solicitud ? $solicitud->fecha_solicitud->format('d/m/Y H:i') : 'No registrada' }}</p>
                    
                    @if($solicitud->procesado_at)
                        <p><strong>Procesado el:</strong> {{ $solicitud->procesado_at->format('d/m/Y H:i') }}</p>
                        @if($solicitud->admin)
                            <p><strong>Procesado por:</strong> {{ $solicitud->admin->name }}</p>
                        @endif
                    @endif

                    @if($solicitud->respuesta_mensaje)
                        <div class="alert alert-info mt-3">
                            <strong>Respuesta del admin:</strong><br>
                            {{ $solicitud->respuesta_mensaje }}
                        </div>
                    @endif

                    @if($solicitud->observaciones)
                        <div class="alert alert-secondary mt-3">
                            <strong>Observaciones:</strong><br>
                            {{ $solicitud->observaciones }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones (solo si está pendiente) -->
            @if($solicitud->estado == 'Pendiente')
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">⚡ Acciones</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.adopciones.aprobar', $solicitud->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Mensaje para el solicitante (opcional)</label>
                            <textarea name="respuesta_mensaje" class="form-control" rows="3" placeholder="Felicidades, tu solicitud ha sido aprobada..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('¿Aprobar esta adopción?')">
                            ✅ Aprobar Adopción
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('admin.adopciones.rechazar', $solicitud->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Motivo del rechazo (opcional)</label>
                            <textarea name="respuesta_mensaje" class="form-control" rows="3" placeholder="Lamentablemente..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Rechazar esta solicitud?')">
                            ❌ Rechazar Solicitud
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Botón para eliminar adopción (disponible en cualquier estado) -->
            <div class="mt-3">
                <form action="{{ route('admin.adopciones.destroy', $solicitud->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar esta adopción? Si está aprobada, el animal {{ $solicitud->animal->nombre ?? '' }} volverá a estar disponible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> Eliminar Adopción
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

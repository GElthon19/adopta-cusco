@extends('layouts.app')
@section('title', 'Nueva Adopción Presencial')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.adopciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🏢 Nueva Adopción Presencial</h4>
            <small>Registra una adopción realizada directamente en el albergue</small>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.adopciones.presencial.store') }}" method="POST">
                @csrf

                <!-- Paso 1: Datos del Adoptante -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">1️⃣ Datos del Adoptante</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_usuario" class="form-control" required 
                                       placeholder="Juan Pérez" value="{{ old('nombre_usuario') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email_usuario" class="form-control" required 
                                       placeholder="ejemplo@gmail.com" value="{{ old('email_usuario') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Seleccionar Animal -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">2️⃣ Seleccionar Animal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Animal a adoptar <span class="text-danger">*</span></label>
                                <select name="id_animal" class="form-select" required>
                                    <option value="">-- Seleccione un animal --</option>
                                    @foreach($animales as $animal)
                                        <option value="{{ $animal->id_animales }}" {{ old('id_animal') == $animal->id_animales ? 'selected' : '' }}>
                                            {{ $animal->nombre }} - {{ $animal->especie }} ({{ $animal->edad ?? 'Edad desconocida' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Datos Adicionales -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">3️⃣ Datos Adicionales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" 
                                       placeholder="987654321" value="{{ old('telefono') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" 
                                       placeholder="Jr. Los Incas 234, Cusco" value="{{ old('direccion') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Motivo de adopción (opcional)</label>
                            <textarea name="motivo" class="form-control" rows="2" 
                                      placeholder="Breve motivo si lo mencionó...">{{ old('motivo') }}</textarea>
                            <small class="text-muted">Campo opcional, solo si el adoptante proporcionó información.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Observaciones (opcional)</label>
                            <textarea name="observaciones" class="form-control" rows="2" 
                                      placeholder="Notas adicionales...">{{ old('observaciones') }}</textarea>
                            <small class="form-text text-muted">
                                Notas internas opcionales. No es necesario documentación extensa para adopciones presenciales.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Estado automático -->
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> <strong>Esta adopción será aprobada automáticamente</strong> ya que se realizó presencialmente en el albergue. No es necesaria documentación extensa.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Registrar Adopción Presencial
                    </button>
                    <a href="{{ route('admin.adopciones.index') }}" class="btn btn-outline-secondary btn-lg">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

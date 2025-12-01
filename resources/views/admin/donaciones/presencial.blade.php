@extends('layouts.app')
@section('title', 'Nueva Donación Presencial')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.donaciones.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">🏢 Registrar Donación Presencial</h4>
            <small>Registra donaciones de efectivo o bienes físicos recibidos en el albergue</small>
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

            <form action="{{ route('admin.donaciones.presencial.store') }}" method="POST">
                @csrf

                <!-- Tipo de donación -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">1️⃣ Tipo de Donación</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">¿Qué tipo de donación es? <span class="text-danger">*</span></label>
                            <select name="tipo_donacion" id="tipo_donacion" class="form-select" required onchange="toggleCampos()">
                                <option value="">-- Seleccione --</option>
                                <option value="Efectivo"><i class="bi bi-cash"></i> Dinero en Efectivo</option>
                                <option value="Alimentos"><i class="bi bi-basket-fill"></i> Alimentos (Croquetas, comida)</option>
                                <option value="Medicinas"><i class="bi bi-capsule"></i> Medicinas</option>
                                <option value="Otros">📦 Otros (Accesorios, juguetes, etc.)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Datos del donante -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">2️⃣ Datos del Donante</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check_anonimo" onchange="toggleAnonimo()">
                                <label class="form-check-label" for="check_anonimo">
                                    Donación anónima (sin datos del donante)
                                </label>
                            </div>
                        </div>

                        <div id="datos-donante">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre_donante" id="nombre_donante" class="form-control" required placeholder="Juan Pérez" value="{{ old('nombre_donante') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email (opcional, si está registrado)</label>
                                    <input type="email" name="email_donante" class="form-control" placeholder="juan@gmail.com" value="{{ old('email_donante') }}">
                                    <small class="form-text text-muted">Si tiene cuenta, ingrese su email para enviarle un certificado.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="telefono" class="form-control" placeholder="987654321" value="{{ old('telefono') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalles de la donación -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">3️⃣ Detalles de la Donación</h5>
                    </div>
                    <div class="card-body">
                        <!-- Campo Monto (solo para efectivo) -->
                        <div class="mb-3" id="campo-monto" style="display: none;">
                            <label class="form-label">Monto en efectivo <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="monto" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('monto') }}">
                            </div>
                        </div>

                        <!-- Campos para bienes físicos -->
                        <div id="campos-bienes" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Descripción del bien <span class="text-danger">*</span></label>
                                <input type="text" name="tipo_bien" class="form-control" placeholder="Ej: 20 kg de croquetas marca Ricocan" value="{{ old('tipo_bien') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Valor estimado (opcional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/.</span>
                                    <input type="number" name="valor_estimado" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ old('valor_estimado') }}">
                                </div>
                                <small class="form-text text-muted">Valor aproximado del bien donado</small>
                            </div>
                        </div>

                        <!-- Descripción adicional -->
                        <div class="mb-3">
                            <label class="form-label">Descripción adicional</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles adicionales sobre la donación...">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Observaciones del admin -->
                        <div class="mb-3">
                            <label class="form-label">Observaciones del administrador</label>
                            <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas internas...">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Esta donación se registrará como <strong>Recibida</strong> automáticamente.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="bi bi-check-circle"></i> Registrar Donación
                    </button>
                    <a href="{{ route('admin.donaciones.index') }}" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleCampos() {
    const tipo = document.getElementById('tipo_donacion').value;
    const campoMonto = document.getElementById('campo-monto');
    const camposBienes = document.getElementById('campos-bienes');
    
    if (tipo === 'Efectivo') {
        campoMonto.style.display = 'block';
        camposBienes.style.display = 'none';
        document.querySelector('[name="monto"]').required = true;
        document.querySelector('[name="tipo_bien"]').required = false;
    } else if (tipo) {
        campoMonto.style.display = 'none';
        camposBienes.style.display = 'block';
        document.querySelector('[name="monto"]').required = false;
        document.querySelector('[name="tipo_bien"]').required = true;
    } else {
        campoMonto.style.display = 'none';
        camposBienes.style.display = 'none';
    }
}

function toggleAnonimo() {
    const checked = document.getElementById('check_anonimo').checked;
    const datosdonante = document.getElementById('datos-donante');
    const nombreInput = document.getElementById('nombre_donante');
    
    if (checked) {
        datosdonante.style.display = 'none';
        nombreInput.required = false;
        nombreInput.value = 'Anónimo';
    } else {
        datosdonante.style.display = 'block';
        nombreInput.required = true;
        if (nombreInput.value === 'Anónimo') {
            nombreInput.value = '';
        }
    }
}
</script>
@endsection

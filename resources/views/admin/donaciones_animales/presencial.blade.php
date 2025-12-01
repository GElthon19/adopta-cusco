@extends('layouts.app')
@section('title', 'Nueva Donación Presencial de Animales')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.donaciones-animales.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">🏢 Nueva Donación Presencial de Animales</h4>
            <small>Registra animales que llegan directamente al albergue</small>
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

            <form action="{{ route('admin.donaciones-animales.presencial.store') }}" method="POST" enctype="multipart/form-data" id="form-donacion">
                @csrf

                <!-- Paso 1: Datos del Donante -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">1️⃣ Datos del Donante</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_donante" class="form-control" required placeholder="María García" value="{{ old('nombre_donante') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email (Gmail, Outlook, etc.) <span class="text-danger">*</span></label>
                                <input type="email" name="email_donante" class="form-control" required placeholder="ejemplo@gmail.com" value="{{ old('email_donante') }}">
                                <small class="form-text text-muted">Debe ser un email válido de Google, Outlook, Yahoo, etc.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono_donante" class="form-control" placeholder="987654321" value="{{ old('telefono_donante') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion_donante" class="form-control" placeholder="Av. La Cultura 456" value="{{ old('direccion_donante') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Motivo de donación</label>
                                <textarea name="motivo_donacion" class="form-control" rows="2" placeholder="Razones por las que dona los animales...">{{ old('motivo_donacion') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Animales -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">2️⃣ Animales Donados</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="agregarAnimal()">
                            <i class="bi bi-plus-circle"></i> Agregar Animal
                        </button>
                    </div>
                    <div class="card-body" id="contenedor-animales">
                        <!-- Los animales se agregarán aquí dinámicamente -->
                    </div>
                </div>

                <!-- Paso 3: Observaciones -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">3️⃣ Observaciones del Administrador</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Animales verificados, documentos revisados...">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> <strong>Esta donación será aprobada automáticamente</strong> y los animales se agregarán al albergue.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-circle"></i> Registrar Donación Presencial
                    </button>
                    <a href="{{ route('admin.donaciones-animales.index') }}" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let contadorAnimales = 0;

// Agregar primer animal al cargar
document.addEventListener('DOMContentLoaded', function() {
    agregarAnimal();
});

function agregarAnimal() {
    const contenedor = document.getElementById('contenedor-animales');
    const index = contadorAnimales++;
    
    const html = `
        <div class="card mb-3 animal-card" id="animal-${index}">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-circle-fill"></i> Animal #${index + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarAnimal(${index})">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" name="animales[${index}][nombre]" class="form-control" required placeholder="Firulais">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo <span class="text-danger">*</span></label>
                        <select name="animales[${index}][tipo]" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="perro">Perro</option>
                            <option value="gato">Gato</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Raza</label>
                        <input type="text" name="animales[${index}][raza]" class="form-control" placeholder="Labrador">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Edad aproximada</label>
                        <input type="text" name="animales[${index}][edad]" class="form-control" placeholder="2 años">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sexo</label>
                        <select name="animales[${index}][sexo]" class="form-select">
                            <option value="">-- Seleccione --</option>
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="animales[${index}][color]" class="form-control" placeholder="Dorado">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="animales[${index}][foto]" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="animales[${index}][descripcion]" class="form-control" rows="2" placeholder="Características, estado de salud, comportamiento..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    contenedor.insertAdjacentHTML('beforeend', html);
}

function eliminarAnimal(index) {
    if (document.querySelectorAll('.animal-card').length === 1) {
        alert('Debe haber al menos un animal en la donación.');
        return;
    }
    
    if (confirm('¿Eliminar este animal?')) {
        document.getElementById(`animal-${index}`).remove();
    }
}
</script>
@endsection

@extends('layouts.app')
@section('title', 'Donar Animales al Albergue')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Botón para regresar -->
            <div class="mb-4">
                <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al inicio
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="bi bi-gift-fill"></i> Donar Animales al Albergue</h3>
                    <p class="mb-0">Si tienes mascotas que ya no puedes cuidar, podemos ayudarte a encontrarles un nuevo hogar</p>
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
                            <h5>Por favor corrija los siguientes errores:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('solicitudes-donacion-animal.store') }}" method="POST" enctype="multipart/form-data" id="form-donacion">
                        @csrf

                        <!-- Información del solicitante -->
                        <div class="alert alert-info">
                            <strong><i class="bi bi-person-fill"></i> Tus datos:</strong><br>
                            Nombre: {{ Auth::user()->name }}<br>
                            Email: {{ Auth::user()->email }}
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tu teléfono de contacto</label>
                                <input type="text" name="telefono" class="form-control" placeholder="987654321" value="{{ old('telefono') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tu dirección</label>
                                <input type="text" name="direccion" class="form-control" placeholder="Jr. Los Incas 234, Cusco" value="{{ old('direccion') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">¿Por qué deseas donar tu(s) mascota(s)?</label>
                            <textarea name="motivo" class="form-control" rows="3" placeholder="Explícanos tu situación...">{{ old('motivo') }}</textarea>
                            <small class="form-text text-muted">Esto nos ayuda a entender mejor tu caso y brindarte el apoyo adecuado.</small>
                        </div>

                        <hr class="my-4">

                        <!-- Animales a donar -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Animales que deseas donar</h5>
                            <button type="button" class="btn btn-sm btn-success" onclick="agregarAnimal()">
                                <i class="bi bi-plus-circle"></i> Agregar Animal
                            </button>
                        </div>

                        <div id="contenedor-animales">
                            <!-- Los animales se agregarán aquí dinámicamente -->
                        </div>

                        <div class="alert alert-warning mt-4">
                            <strong>⏳ Tiempo de respuesta:</strong> Tu solicitud será revisada en un máximo de 48 horas. Te contactaremos para coordinar la recepción de los animales.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-send"></i> Enviar Solicitud de Donación
                            </button>
                            <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
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
        <div class="card mb-3 border-success animal-card" id="animal-${index}">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-circle-fill"></i> Animal #${index + 1}</h6>
                ${index > 0 ? `<button type="button" class="btn btn-sm btn-danger" onclick="eliminarAnimal(${index})">
                    <i class="bi bi-trash"></i> Eliminar
                </button>` : ''}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de tu mascota <span class="text-danger">*</span></label>
                        <input type="text" name="animales[${index}][nombre]" class="form-control" required placeholder="Firulais">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">¿Qué tipo de animal es? <span class="text-danger">*</span></label>
                        <select name="animales[${index}][tipo]" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="perro"><i class="bi bi-circle-fill"></i> Perro</option>
                            <option value="gato">🐱 Gato</option>
                            <option value="otro">🦜 Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Raza</label>
                        <input type="text" name="animales[${index}][raza]" class="form-control" placeholder="Labrador, Criollo, etc.">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Edad aproximada</label>
                        <input type="text" name="animales[${index}][edad]" class="form-control" placeholder="2 años, 6 meses, etc.">
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
                        <input type="text" name="animales[${index}][color]" class="form-control" placeholder="Marrón, Blanco, Negro, etc.">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Foto de tu mascota (opcional)</label>
                        <input type="file" name="animales[${index}][foto]" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cuéntanos sobre tu mascota</label>
                        <textarea name="animales[${index}][descripcion]" class="form-control" rows="3" placeholder="Personalidad, estado de salud, vacunas, si está esterilizado/a, si es cariñoso/a, etc."></textarea>
                        <small class="form-text text-muted">Mientras más información nos des, mejor podremos cuidarla y encontrarle un nuevo hogar.</small>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    contenedor.insertAdjacentHTML('beforeend', html);
}

function eliminarAnimal(index) {
    if (document.querySelectorAll('.animal-card').length === 1) {
        alert('Debe haber al menos un animal en la solicitud.');
        return;
    }
    
    if (confirm('¿Eliminar este animal de la solicitud?')) {
        document.getElementById(`animal-${index}`).remove();
    }
}
</script>
@endsection

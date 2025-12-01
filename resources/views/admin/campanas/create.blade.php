@extends('layouts.app')
@section('title', 'Nueva Campaña - Admin')

@section('content')
<div class="container">
    <div class="mb-4">
        <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Volver a Campañas
        </a>
        <h1 class="h3"><i class="bi bi-megaphone-fill"></i> Nueva Campaña</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.campanas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="titulo" class="form-label">Título de la Campaña *</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                               id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                        @error('titulo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="imagen" class="form-label">Imagen de la Campaña</label>
                        <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                               id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Formatos aceptados: JPG, PNG, GIF. Máximo 2MB</small>
                        @error('imagen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview-container" class="mt-2"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" name="descripcion" rows="5" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                               id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}" required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="duracion_dias" class="form-label">Duración (días) *</label>
                        <input type="number" class="form-control @error('duracion_dias') is-invalid @enderror" 
                               id="duracion_dias" name="duracion_dias" value="{{ old('duracion_dias', 30) }}" 
                               min="1" required>
                        @error('duracion_dias')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" 
                                id="estado" name="estado" required>
                            <option value="activa" {{ old('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="pausada" {{ old('estado') == 'pausada' ? 'selected' : '' }}>Pausada</option>
                            <option value="finalizada" {{ old('estado') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Crear Campaña
                    </button>
                    <a href="{{ route('admin.campanas.index') }}" class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const container = document.getElementById('preview-container');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `
                <img src="${e.target.result}" alt="Preview" 
                     style="max-width: 300px; max-height: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd;">
            `;
        };
        reader.readAsDataURL(file);
    } else {
        container.innerHTML = '';
    }
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Crear Bloque de Contenido')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Crear Nuevo Bloque de Contenido</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('content-blocks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="key" class="form-label">Clave única <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('key') is-invalid @enderror" 
                                   id="key" 
                                   name="key" 
                                   value="{{ old('key') }}"
                                   placeholder="Ej: welcome_title, campaign_description"
                                   required>
                            <small class="form-text text-muted">
                                Solo letras, números, guiones y guiones bajos. Sin espacios.
                            </small>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="label" class="form-label">Etiqueta descriptiva <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('label') is-invalid @enderror" 
                                   id="label" 
                                   name="label" 
                                   value="{{ old('label') }}"
                                   placeholder="Ej: Título de Bienvenida"
                                   required>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo de contenido <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Texto corto</option>
                                <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Texto largo</option>
                                <option value="html" {{ old('type') == 'html' ? 'selected' : '' }}>HTML</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="6"
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Activo (visible en el sitio)
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('content-blocks.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Bloque
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

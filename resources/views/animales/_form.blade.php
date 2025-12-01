@csrf

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $animal->nombre) }}" class="form-control" required>
    @error('nombre') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $animal->descripcion) }}</textarea>
    @error('descripcion') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

{{-- Campo de imagen --}}
<div class="mb-3">
    <label class="form-label">Foto principal</label>
    <input type="file" name="imagen" class="form-control" accept="image/*"> {{-- name="imagen" --}}
    <div class="form-text">Formatos: JPG, PNG, WEBP. Máx: 2 MB.</div>
    @error('imagen') <div class="text-danger small">{{ $message }}</div> @enderror

    @if(!empty($animal->imagen))
    <div class="mt-2">
        <p class="text-muted small mb-1">Foto actual:</p>
        <img src="{{ asset('img/'.$animal->imagen) }}" 
             alt="Foto actual" 
             style="max-height:140px; border-radius:8px; object-fit: cover;"
             onerror="this.src='{{ asset('img/default-pet.webp') }}'">
        <p class="text-muted small mt-1"><strong>{{ $animal->imagen }}</strong></p>
    </div>
    @endif
</div>
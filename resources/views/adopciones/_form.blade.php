@csrf
<div class="mb-3">
    <label class="form-label">Animal</label>
    <select name="id_animal" class="form-select" required>
        <option value="">Seleccione…</option>
        @foreach($animales as $ani)
        <option value="{{ $ani->id_animales }}"
            @selected(old('id_animal', $adopcion->animal_id) == $ani->id_animales)>
            {{ $ani->nombre }}
        </option>
        @endforeach
    </select>
    @error('id_animal') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nombre de la persona</label>
    <input type="text" name="adoptante_nombre" class="form-control"
        value="{{ old('adoptante_nombre', $adopcion->adoptante_nombre) }}" required>
    @error('adoptante_nombre') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="adoptante_telefono" class="form-control"
        value="{{ old('adoptante_telefono', $adopcion->adoptante_telefono) }}">
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="adoptante_email" class="form-control"
        value="{{ old('adoptante_email', $adopcion->adoptante_email) }}">
</div>

<div class="mb-3">
    <label class="form-label">Dirección</label>
    <textarea name="adoptante_direccion" rows="2" class="form-control">{{ old('adoptante_direccion', $adopcion->adoptante_direccion) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Motivo</label>
    <textarea name="motivo_adopcion" rows="3" class="form-control">{{ old('motivo_adopcion', $adopcion->motivo_adopcion) }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Fecha de solicitud</label>
    <input type="datetime-local" name="fecha_solicitud"
        value="{{ old('fecha_solicitud', optional($adopcion->fecha_solicitud)->format('Y-m-d\TH:i')) }}"
        class="form-control">
    @error('fecha_solicitud') <div class="text-danger small">{{ $message }}</div> @enderror
</div>


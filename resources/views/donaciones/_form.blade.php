@csrf
<div class="mb-3">
    <label class="form-label">Nombre del donante</label>
    <input type="text" name="nombre_donante" class="form-control"
        value="{{ old('nombre_donante', $donacion->nombre_donante) }}" required>
    @error('nombre_donante') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="correo" class="form-control"
        value="{{ old('correo', $donacion->correo) }}">
    @error('correo') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Monto (S/)</label>
    <input type="number" step="0.01" name="monto" class="form-control"
        value="{{ old('monto', $donacion->monto) }}" required>
    @error('monto') <div class="text-danger small">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Mensaje</label>
    <textarea name="mensaje" class="form-control" rows="3">{{ old('mensaje', $donacion->mensaje) }}</textarea>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label">Método de pago</label>
            <select name="metodo_pago" class="form-select" required>
                <option value="">Seleccione…</option>
                <option value="QR Yape" @selected(old('metodo_pago', $donacion->metodo_pago) === 'QR Yape')>QR Yape</option>
                <option value="QR Plin" @selected(old('metodo_pago', $donacion->metodo_pago) === 'QR Plin')>QR Plin</option>
            </select>
            @error('metodo_pago') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header">
                <h5 class="card-title mb-0">¿Quieres donar implementos?</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    ¡También aceptamos donaciones de:</p>
                <ul>
                    <li>Alimentos para perros y gatos</li>
                    <li>Medicinas</li>
                    <li>Ropa y mantas</li>
                    <li>Juguetes</li>
                    <li>Artículos de limpieza</li>
                </ul>
                <p class="card-text">
                    Puedes traerlos directamente a nuestras instalaciones o coordinar la recolección.
                </p>
                <p class="card-text">
                    <strong>¡Gracias por tu apoyo!</strong>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Fecha de solicitud</label>
    <div class="alert alert-info py-2" style="margin-top: 10px;">
        <small class="fw-bold">Generada automáticamente:</small><br>
        {{ now()->format('d/m/Y H:i') }}
    </div>
    @error('fecha_solicitud') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
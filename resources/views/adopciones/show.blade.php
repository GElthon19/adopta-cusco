@extends('layouts.app')
@section('title','Revisar solicitud')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Revisar solicitud</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Animal:</strong> {{ $adopcion->animal->nombre ?? '—' }}</p>
            <p><strong>Solicitante:</strong> {{ $adopcion->adoptante_nombre }}</p>
            <p><strong>Correo:</strong> {{ $adopcion->adoptante_email }}</p>
            <p><strong>Teléfono:</strong> {{ $adopcion->adoptante_telefono }}</p>
            <p><strong>Motivo:</strong> {{ $adopcion->motivo_adopcion }}</p>
            <p><strong>Fecha solicitud:</strong> {{ optional($adopcion->fecha_solicitud)->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('adopciones.update', $adopcion->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control">
                <option value="Pendiente" {{ $adopcion->estado=='Pendiente' ? 'selected':'' }}>Pendiente</option>
                <option value="Aprobada" {{ $adopcion->estado=='Aprobada' ? 'selected':'' }}>Aprobada</option>
                <option value="Rechazada" {{ $adopcion->estado=='Rechazada' ? 'selected':'' }}>Rechazada</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mensaje / Observaciones para el solicitante</label>
            <textarea name="respuesta_mensaje" class="form-control" rows="4">{{ old('respuesta_mensaje', $adopcion->respuesta_mensaje) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha para recogida (opcional)</label>
            <input type="date" name="fecha_adopcion" class="form-control" value="{{ optional($adopcion->fecha_adopcion)->format('Y-m-d') }}">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('adopciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
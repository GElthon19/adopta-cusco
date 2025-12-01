@extends('layouts.app')
@section('title','Adopciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Adopciones</h1>
    <a href="{{ route('adopciones.create') }}" class="btn btn-primary">Nueva solicitud</a>
</div>

@if($items->count())
<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $ad)
            <tr>
                <td>{{ $ad->id }}</td>
                <td>{{ $ad->animal->nombre ?? '—' }}</td>
                <td>{{ $ad->adoptante_nombre }}</td>
                <td>{{ $ad->adoptante_telefono ?? '—' }}</td>
                <td>{{ $ad->adoptante_email ?? '—' }}</td>
                <td>{{ $ad->estado }}</td>
                <td>{{ $ad->fecha_solicitud }}</td>
                <td class="text-end">
                    <a href="{{ route('adopciones.edit', $ad->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form action="{{ route('adopciones.destroy', $ad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar solicitud?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $items->links() }}
@else
<p class="text-muted">No hay solicitudes registradas.</p>
@endif
@endsection
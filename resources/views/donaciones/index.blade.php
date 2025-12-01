@extends('layouts.app')
@section('title','Donaciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Donaciones</h1>
    <a href="{{ route('donaciones.create') }}" class="btn btn-primary">Nueva donación</a>
</div>

@if($items->count())
<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donante</th>
                <th>Correo</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Fecha</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->nombre_donante }}</td>
                <td>{{ $d->correo ?? '—' }}</td>
                <td>S/ {{ number_format($d->monto, 2) }}</td>
                <td>{{ $d->metodo_pago ?? '—' }}</td>
                <td>{{ $d->fecha_donacion }}</td>
                <td class="text-end">
                    <a href="{{ route('donaciones.edit', $d->id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form action="{{ route('donaciones.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar donación?')">
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
<p class="text-muted">No hay donaciones registradas.</p>
@endif
@endsection
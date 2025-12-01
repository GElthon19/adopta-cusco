@extends('layouts.app')

@section('title', 'Detalle del Animal')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">{{ $animal->nombre }}</h2>
        <p class="card-text">{{ $animal->descripcion ?? 'Sin descripción.' }}</p>

        <a href="{{ route('animales.edit', $animal->id_animales) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('animales.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection
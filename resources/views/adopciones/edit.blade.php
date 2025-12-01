@extends('layouts.app')
@section('title','Editar adopción')

@section('content')
<h1 class="h4 mb-3">Editar solicitud</h1>
<form method="POST" action="{{ route('adopciones.update', $adopcion->id) }}">
    @method('PUT')
    @include('adopciones._form')
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('adopciones.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
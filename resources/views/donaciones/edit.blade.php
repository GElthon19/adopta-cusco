@extends('layouts.app')
@section('title','Editar donación')

@section('content')
<h1 class="h4 mb-3">Editar donación</h1>
<form method="POST" action="{{ route('donaciones.update', $donacion->id) }}">
    @method('PUT')
    @include('donaciones._form')
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('donaciones.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
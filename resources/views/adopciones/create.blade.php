@extends('layouts.app')
@section('title','Nueva adopción')

@section('content')
<h1 class="h4 mb-3">Registrar Adopción</h1>
<form method="POST" action="{{ route('adopciones.store') }}">
    @include('adopciones._form')
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('adopciones.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
@extends('layouts.app')
@section('title','Nueva donación')

@section('content')
<h1 class="h4 mb-3">Registrar donación</h1>
<form method="POST" action="{{ route('donaciones.store') }}">
    @include('donaciones._form')
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('donaciones.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
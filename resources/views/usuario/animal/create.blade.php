@extends('layouts.app')

@section('title', 'Dar en Adopción')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Registrar Animal para Adopción</h1>
    <p>Completa este formulario para registrar un animal que deseas poner en adopción.</p>

    <form method="POST" action="{{ route('usuario.animal.store') }}"> <!-- Asegúrate de tener la ruta store también -->
        @csrf
        <!-- Aquí van los campos del formulario -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Animal</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="especie" class="form-label">Especie</label>
            <select class="form-select" id="especie" name="especie" required>
                <option value="Perro">Perro</option>
                <option value="Gato">Gato</option>
                <option value="Otro">Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <!-- Agrega más campos según necesites -->
        <button type="submit" class="btn btn-primary">Registrar Animal</button>
        <a href="{{ route('animales.index') }}" class="btn btn-link">Cancelar</a>
    </form>
</div>
@endsection
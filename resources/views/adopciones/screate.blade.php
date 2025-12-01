@extends('layouts.app') {{-- Extiende el layout principal --}}
@section('title','Nueva adopción') {{-- Define el título de la página --}}

@section('content')
<div class="container mt-4"> {{-- Añadido contenedor para mejor espaciado --}}
    <h1 class="h4 mb-3 fw-bold">Registrar solicitud de adopción</h1> {{-- Título más destacado --}}
    <div class="card shadow-sm"> {{-- Tarjeta para envolver el formulario --}}
        <div class="card-body">
            <form method="POST" action="{{ route('adopciones.store') }}">
                @csrf {{-- Token CSRF para seguridad --}}
                @include('adopciones._sform') {{-- Incluye el fragmento del formulario mejorado --}}
                <div class="d-flex justify-content-between mt-4"> {{-- Botones alineados --}}
                    <a href="{{ route('adopciones.index') }}" class="btn btn-secondary">Cancelar</a> {{-- Botón de cancelar --}}
                    <button type="submit" class="btn btn-primary">Guardar Solicitud</button> {{-- Botón de guardar --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
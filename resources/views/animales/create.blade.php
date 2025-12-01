@extends('layouts.app')
@section('title','Nuevo animal')

@push('css')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 35px;
    }
    
    .form-header h1 {
        color: #2C7A7B;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .form-header p {
        color: #6c757d;
        font-size: 1rem;
    }
    
    .form-icon {
        font-size: 3.5rem;
        color: #69D1C4;
        margin-bottom: 15px;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #69D1C4 0%, #4EC3B4 100%);
        border: none;
        color: white;
        padding: 12px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(105, 209, 196, 0.4);
        color: white;
    }
    
    .btn-cancel {
        color: #6c757d;
        padding: 12px 30px;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        color: #495057;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="form-icon">🐾</div>
        <h1>Agregar Nuevo Animal</h1>
        <p>Completa los datos del animal que será agregado al albergue</p>
    </div>
    
    <form method="POST" action="{{ route('animales.store') }}" enctype="multipart/form-data">
        @include('animales._form')
        
        <div class="d-flex justify-content-center gap-3 mt-4">
            <button type="submit" class="btn btn-save">
                <i class="bi bi-check-circle"></i> Guardar Animal
            </button>
            <a href="{{ route('animales.index') }}" class="btn btn-cancel">
                <i class="bi bi-x-circle"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
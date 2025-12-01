@extends('layouts.app')

@section('title', 'Animales')

@push('css')
<style>
    .btn-add-animal {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #69D1C4 0%, #4EC3B4 100%);
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 5px 20px rgba(105, 209, 196, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-add-animal:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(105, 209, 196, 0.5);
        color: white;
        text-decoration: none;
    }
    
    .btn-add-animal i {
        font-size: 1.3rem;
        font-style: normal;
    }
</style>
@endpush

@section('content')
<div class="contenedor">
    <h2 class="seccion"><i class="bi bi-hearts"></i> Nuestros Animales en Busca de Hogar</h2>
    
    {{-- Botón para agregar nuevo animal --}}
    <div class="text-center mb-4">
        <a href="{{ route('animales.create') }}" class="btn-add-animal">
            <i class="bi bi-plus-circle-fill"></i> Agregar Nuevo Animal
        </a>
    </div>

    @if($items->count())
    <div class="galeria-animales">
        @foreach($items as $animal)
        <div class="tarjeta-solo-foto">
            <div class="contenedor-foto">
                @if($animal->imagen)
                    <img src="{{ asset('img/' . $animal->imagen) }}" alt="{{ $animal->nombre }}" 
                         onerror="this.src='{{ asset('img/default-pet.webp') }}'">
                @else
                    <img src="{{ asset('img/default-pet.webp') }}" alt="Imagen por defecto">
                @endif
                <span class="insignia-especie {{ strtolower($animal->especie) }}">
                    @if($animal->especie == 'Perro')
                        <i class="bi bi-circle-fill"></i>
                    @elseif($animal->especie == 'Gato')
                        <i class="bi bi-circle-fill"></i>
                    @else
                        <i class="bi bi-circle-fill"></i>
                    @endif
                </span>
            </div>
            
            <div class="info-minima">
                <div class="nombre-animal">{{ $animal->nombre }}</div>
                <small class="text-muted">{{ $animal->edad ?? '?' }} años • {{ $animal->estado ?? 'Disponible' }}</small>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        {{-- ADMIN: Diferenciar entre Adoptado y Disponible --}}
                        @if($animal->estado == 'Adoptado')
                            <div class="mt-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill"></i> Adoptado
                                </span>
                                <small class="d-block text-muted mt-1">Para liberar este animal, elimina su adopción desde el panel de adopciones</small>
                            </div>
                        @else
                            {{-- BOTONES ADMIN PARA ANIMALES DISPONIBLES --}}
                            <div class="acciones-admin mt-2">
                                <a href="{{ route('animales.edit', $animal->id_animales) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil-fill"></i> Editar
                                </a>
                                <form action="{{ route('animales.destroy', $animal->id_animales) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de eliminar a {{ $animal->nombre }}?')">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        {{-- BOTÓN ADOPTAR PARA USUARIOS (solo si está disponible) --}}
                        @if($animal->estado == 'Disponible')
                            <a href="{{ route('solicitudes_adopcion.create', ['animal_id' => $animal->id_animales]) }}" class="boton-adoptar-mini">
                                <i class="bi bi-heart-fill"></i> Adoptar
                            </a>
                        @else
                            <span class="badge bg-secondary mt-2">{{ $animal->estado }}</span>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
        @endforeach
    </div>

    {{-- PAGINACIÓN BONITA --}}
    <div class="paginacion-mejorada">
        <div class="info-paginacion">
            Mostrando {{ $items->firstItem() }} - {{ $items->lastItem() }} de {{ $items->total() }} animales
        </div>
        
        <div class="controles-paginacion">
            @if($items->onFirstPage())
                <span class="btn-pagina disabled">← Anterior</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="btn-pagina">← Anterior</a>
            @endif

            <span class="info-pagina">
                Página {{ $items->currentPage() }} de {{ $items->lastPage() }}
            </span>

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="btn-pagina">Siguiente →</a>
            @else
                <span class="btn-pagina disabled">Siguiente →</span>
            @endif
        </div>
    </div>
    @else
    <div class="text-center text-muted py-5">
        <p>No hay animales registrados aún.</p>
        <a href="{{ route('animales.create') }}" class="btn btn-primary">Agregar primer animal</a>
    </div>
    @endif
</div>
@endsection
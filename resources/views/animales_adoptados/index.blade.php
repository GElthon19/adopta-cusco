@extends('layouts.app')
@section('title', 'Animales Adoptados - Adopta Cusco')

@push('css')
<style>
    .header-adoptados {
        background: linear-gradient(135deg, #69D1C4, #4EC3B4);
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    .filtro-orden {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .animal-card-adoptado {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .animal-card-adoptado:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .animal-imagen-adoptado {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .animal-info-adoptado {
        padding: 20px;
    }

    .badge-adoptado {
        background: linear-gradient(135deg, #69D1C4, #4EC3B4);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9em;
    }

    .fecha-adopcion {
        color: #6c757d;
        font-size: 0.85em;
    }
</style>
@endpush

@section('content')
<div class="header-adoptados">
    <div class="container">
        <h1 class="display-4"><i class="bi bi-heart-fill"></i> Historias de Éxito</h1>
        <p class="lead">Conoce a nuestros animalitos que encontraron un hogar amoroso</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filtros -->
    <div class="filtro-orden">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-0"><i class="bi bi-funnel"></i> Filtrar por:</h4>
            <div class="btn-group" role="group">
                <a href="{{ route('animales-adoptados.index', ['orden' => 'recientes']) }}" 
                   class="btn {{ $orden === 'recientes' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock-history"></i> Más Recientes
                </a>
                <a href="{{ route('animales-adoptados.index', ['orden' => 'antiguos']) }}" 
                   class="btn {{ $orden === 'antiguos' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock"></i> Más Antiguos
                </a>
            </div>
        </div>
    </div>

    <!-- Grid de animales adoptados -->
    @if($animales->count() > 0)
    <div class="row g-4 mb-4">
        @foreach($animales as $animal)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="animal-card-adoptado">
                @if($animal->imagen && file_exists(public_path('img/' . $animal->imagen)))
                <img src="{{ asset('img/' . $animal->imagen) }}" alt="{{ $animal->nombre }}" class="animal-imagen-adoptado">
                @elseif($animal->foto && file_exists(public_path('img/' . $animal->foto)))
                <img src="{{ asset('img/' . $animal->foto) }}" alt="{{ $animal->nombre }}" class="animal-imagen-adoptado">
                @else
                <div class="animal-imagen-adoptado bg-gradient d-flex align-items-center justify-content-center text-white" 
                     style="background: linear-gradient(135deg, #69D1C4, #4EC3B4);">
                    <div class="text-center">
                        <i class="bi bi-heart-fill" style="font-size: 4em;"></i>
                        <p class="mt-2 mb-0">{{ $animal->nombre }}</p>
                    </div>
                </div>
                @endif

                <div class="animal-info-adoptado">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">{{ $animal->nombre }}</h5>
                        <span class="badge-adoptado">
                            <i class="bi bi-check-circle-fill"></i> Adoptado
                        </span>
                    </div>

                    <p class="text-muted mb-3">
                        <i class="bi bi-info-circle"></i> {{ Str::limit($animal->descripcion ?? 'Sin descripción', 100) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="d-block"><strong>Especie:</strong> {{ $animal->especie ?? 'N/A' }}</small>
                            <small class="d-block"><strong>Raza:</strong> {{ $animal->raza ?? 'N/A' }}</small>
                        </div>
                        <div class="text-end">
                            <span class="fecha-adopcion">
                                <i class="bi bi-calendar-check"></i><br>
                                @if($animal->updated_at)
                                    {{ \Carbon\Carbon::parse($animal->updated_at)->diffForHumans() }}
                                @else
                                    Recientemente
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $animales->links() }}
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 5em; opacity: 0.3; color: #6c757d;"></i>
        <h4 class="mt-3 text-muted">No hay animales adoptados aún</h4>
        <p class="text-muted">Pronto tendremos historias de éxito para compartir</p>
        <div class="mt-4">
            <p class="small text-muted">
                <strong>Estado actual:</strong><br>
                Total de animales: {{ \App\Models\Animal::count() }}<br>
                Animales con estado "Adoptado": {{ \App\Models\Animal::where('estado', 'Adoptado')->count() }}<br>
                Animales disponibles: {{ \App\Models\Animal::where('estado', 'Disponible')->count() }}<br>
                Animales en proceso: {{ \App\Models\Animal::where('estado', 'En proceso')->count() }}
            </p>
        </div>
    </div>
    @endif

    <!-- Botón volver -->
    <div class="text-center mt-4">
        <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
    </div>
</div>
@endsection

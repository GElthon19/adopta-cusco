@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Inicio')

@push('css')
<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
@endpush

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('success') }}');
    });
</script>
@endif

{{-- CONTENEDOR PRINCIPAL CON FONDO --}}
<div class="contenedor-principal">
    <div class="envoltorio-contenido">
        <div class="container-fluid">

            {{-- FILA CON ASIDE IZQ / CONTENIDO / ASIDE DER --}}
            <div class="row">
                {{-- Aside izquierdo: consejos --}}
                <div class="aside-izquierdo">
                    <h5 class="titulo-aside">💡 Consejos de Cuidado</h5>
                    <div class="contenedor-consejos">
                        <div class="consejo-item">
                            <div class="contenido-consejo">
                                <h6>
                                    <span class="icono-consejo">🥘</span>
                                    Alimentación Balanceada
                                </h6>
                                <p>Proporciona alimento de calidad según la edad y tamaño de tu mascota</p>
                            </div>
                        </div>
                        <div class="consejo-item">
                            <div class="contenido-consejo">
                                <h6>
                                    <span class="icono-consejo"><i class="bi bi-hospital"></i></span>
                                    Visitas al Veterinario
                                </h6>
                                <p>Revisiones periódicas mantienen a tu mascota saludable</p>
                            </div>
                        </div>
                        <div class="consejo-item">
                            <div class="contenido-consejo">
                                <h6>
                                    <span class="icono-consejo">🎾</span>
                                    Ejercicio Diario
                                </h6>
                                <p>Paseos y juego son esenciales para su bienestar</p>
                            </div>
                        </div>
                        <div class="consejo-item">
                            <div class="contenido-consejo">
                                <h6>
                                    <span class="icono-consejo">💧</span>
                                    Hidratación
                                </h6>
                                <p>Agua fresca y limpia siempre disponible</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Contenido central --}}
                <div class="col-lg-8">
                    {{-- BLOQUE GRIS: "Adopta Cusco" --}}
                    <div class="p-4 p-md-5 mb-4 bg-white border rounded-3 shadow-sm">
                        <div class="container py-3 text-center">
                            <h1 class="display-5 fw-bold mb-2"><i class="bi bi-hearts"></i> Adopta Cusco</h1>
                            <p class="lead mb-4">Encuentra a tu nuevo mejor amigo o apoya con una donación 💖</p>
                            
                            <!-- Botones de acción principales -->
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="#mascotas" class="btn btn-primary btn-lg">
                                    <i class="bi bi-heart"></i> Ver Mascotas Disponibles
                                </a>
                                <a href="{{ route('animales-adoptados.index') }}" class="btn btn-info btn-lg">
                                    <i class="bi bi-heart-fill"></i> Historias de Éxito
                                </a>
                                <a href="{{ route('solicitudes-donacion-animal.create') }}" class="btn btn-success btn-lg">
                                    <i class="bi bi-gift"></i> Donar un Animal
                                </a>
                                <a href="{{ route('solicitudes-donacion-economica.create') }}" class="btn btn-warning btn-lg text-dark">
                                    <i class="bi bi-cash-coin"></i> Donar Dinero
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Proceso de adopción --}}
                    <section id="proceso" class="contenedor bg-white p-4 rounded-3 shadow-sm mb-4"> <!-- Agregué mb-4 -->
                        <h2 class="seccion"><i class="bi bi-clipboard-check"></i> Nuestro Proceso de Adopción</h2>
                        <div class="pasos-proceso">
                            <div class="paso">
                                <div class="icono-paso">1</div>
                                <h4>Conoce al Animal</h4>
                                <p>Revisa los perfiles y elige a tu compañero ideal</p>
                            </div>
                            <div class="paso">
                                <div class="icono-paso">2</div>
                                <h4>Solicita la Adopción</h4>
                                <p>Completa el formulario con tus datos</p>
                            </div>
                            <div class="paso">
                                <div class="icono-paso">3</div>
                                <h4>Entrevista</h4>
                                <p>Coordinamos una entrevista para conocerte</p>
                            </div>
                            <div class="paso">
                                <div class="icono-paso">4</div>
                                <h4>Hogar Definitivo</h4>
                                <p>¡Lleva a tu nuevo amigo a casa!</p>
                            </div>
                        </div>
                    </section>

                    {{-- NUEVA SECCIÓN: Listado de Animales con Búsqueda --}}
                    <div class="contenido-central bg-white p-4 rounded-3 shadow-sm mb-4" id="mascotas">
                        <h2 class="h5 mb-3">🐶🐱 Mascotas en Busca de Hogar</h2>

                        <!-- Formulario de Búsqueda -->
                        <form method="GET" action="{{ route('usuario.index') }}" class="mb-3"> <!-- Asegúrate de que la ruta apunte a tu nuevo método o a animales.index si lo adaptas -->
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                            </div>
                        </form>
                        <!-- Fin Formulario de Búsqueda -->

                        @if($animales->count() > 0) <!-- Asumiendo que pasas una variable $animales desde el controlador -->
                            <div class="galeria-animales"> <!-- Reutilizamos estilos si existen, o creamos nuevos -->
                                @foreach($animales as $animal)
                                    <div class="tarjeta-solo-foto"> <!-- Reutilizamos estilos de la galería de animales -->
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
                                            <small class="text-muted">{{ $animal->edad ?? '?' }} años • 
                                                @if($animal->estado === 'En Proceso')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-hourglass-split"></i> En Proceso de Adopción
                                                    </span>
                                                @elseif($animal->estado === 'Adoptado')
                                                    <span class="badge bg-secondary">Adoptado</span>
                                                @else
                                                    <span class="badge bg-success">{{ $animal->estado ?? 'Disponible' }}</span>
                                                @endif
                                            </small>

                                            <!-- BOTÓN ADOPTAR -->
                                            @if($animal->estado === 'Disponible' || $animal->estado === null)
                                            <a href="{{ route('solicitudes_adopcion.create', ['animal_id' => $animal->id_animales]) }}" class="boton-adoptar-mini">
                                                <i class="bi bi-heart-fill"></i> Adoptar
                                            </a>
                                            @elseif($animal->estado === 'En Proceso')
                                            <button class="boton-adoptar-mini" disabled style="opacity: 0.6; cursor: not-allowed;">
                                                <i class="bi bi-hourglass-split"></i> En Evaluación
                                            </button>
                                            @else
                                            <button class="boton-adoptar-mini" disabled style="opacity: 0.6; cursor: not-allowed;">
                                                <i class="bi bi-check-circle"></i> No Disponible
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            {{-- PAGINACIÓN BONITA --}} 
                            <div class="paginacion-mejorada">
                                <div class="info-paginacion">
                                    Mostrando {{ $animales->firstItem() }} - {{ $animales->lastItem() }} de {{ $animales->total() }} animales
                                </div>
                                
                                <div class="controles-paginacion">
                                    @if($animales->onFirstPage())
                                        <span class="btn-pagina disabled">← Anterior</span>
                                    @else
                                        <a href="{{ $animales->previousPageUrl() }}" class="btn-pagina">← Anterior</a>
                                    @endif

                                    <span class="info-pagina">
                                        Página {{ $animales->currentPage() }} de {{ $animales->lastPage() }}
                                    </span>

                                    @if($animales->hasMorePages())
                                        <a href="{{ $animales->nextPageUrl() }}" class="btn-pagina">Siguiente →</a>
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
                    <!-- Fin Nueva Sección -->

                </div> <!-- Fin Contenido central -->

                {{-- Aside derecho: municipalidad --}}
                <div class="aside-derecho colaboracion-municipalidad">
                    <div class="cabecera-colaboracion">
                        <div class="contenedor-logos">
                            <img src="{{ asset('img/logo_cusco_adopta.webp') }}" alt="Cusco Adopta" class="logo-albergue" />
                            <div class="signo-mas">+</div>
                            <img src="{{ asset('img/municipio_san_jeronimo_logo.webp') }}" alt="Municipalidad San Jerónimo" class="logo-municipio" />
                        </div>
                        <h5 class="titulo-colaboracion">🤝 Colaboración Especial</h5>
                        <p class="subtitulo-colaboracion">Albergue Cusco Adopta & Municipalidad de San Jerónimo</p>
                    </div>

                    <!-- CAMPAÑAS DE ADOPCIÓN CONJUNTA -->
                    <div class="seccion-campanas">
                        <h6 class="titulo-campana"><i class="bi bi-calendar-event"></i> Campañas de Adopción</h6>
                        <div class="contenedor-campanas">
                            <div class="campana-item campana-adopcion">
                                <div class="badge-campana">NUEVO</div>
                                <div class="icono-campana">🐕</div>
                                <div class="contenido-campana">
                                    <h6>Adopción Masiva</h6>
                                    <p>¡Encuentra a tu compañero perfecto! Más de 30 animales buscando hogar</p>
                                    <div class="info-campana">
                                        <span class="fecha-campana">📅 29 Nov 2024</span>
                                        <span class="lugar-campana">🏛️ Plaza San Jerónimo</span>
                                    </div>
                                </div>
                            </div>
                            <div class="campana-item campana-adopcion">
                                <div class="icono-campana">🐈</div>
                                <div class="contenido-campana">
                                    <h6>Adopta un Amigo</h6>
                                    <p>Perros y gatos esterilizados, vacunados y desparasitados listos para hogar</p>
                                    <div class="info-campana">
                                        <span class="fecha-campana">📅 14 Dic 2024</span>
                                        <span class="lugar-campana">🏢 Mercado Municipal</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CAMPAÑAS DE ESTERILIZACIÓN -->
                    <div class="seccion-campanas">
                        <h6 class="titulo-campana">💉 Campañas de Esterilización</h6>
                        <div class="contenedor-campanas">
                            <div class="campana-item campana-esterilizacion">
                                <div class="icono-campana">🐩</div>
                                <div class="contenido-campana">
                                    <h6>Esterilización Canina</h6>
                                    <p>Campaña gratuita para perros de familias vulnerables</p>
                                    <div class="info-campana">
                                        <span class="fecha-campana">📅 Cada mes</span>
                                        <span class="lugar-campana"><i class="bi bi-hospital"></i> Clínica Municipal</span>
                                    </div>
                                </div>
                            </div>
                            <div class="campana-item campana-esterilizacion">
                                <div class="icono-campana">😺</div>
                                <div class="contenido-campana">
                                    <h6>Esterilización Felina</h6>
                                    <p>Control poblacional de gatos comunitarios</p>
                                    <div class="info-campana">
                                        <span class="fecha-campana">📅 Programa continuo</span>
                                        <span class="lugar-campana">🏛️ Centro de Salud</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INFORMACIÓN DE CONTACTO CONJUNTA -->
                    <div class="contacto-colaboracion">
                        <div class="item-contacto">
                            <i class="bi bi-telephone"></i>
                            <div>
                                <strong>Albergue Cusco Adopta</strong>
                                <small><i class="bi bi-telephone-fill"></i> +51 984 123 456</small>
                            </div>
                        </div>
                        <div class="item-contacto">
                            <i class="bi bi-building"></i>
                            <div>
                                <strong>Municipalidad</strong>
                                <small><i class="bi bi-telephone-fill"></i> (084) 123-456</small>
                            </div>
                        </div>
                        <div class="leyenda-colaboracion">
                            <small>✨ Juntos por el bienestar animal en Cusco</small>
                        </div>
                    </div>
                </div> <!-- Fin Aside derecho -->
            </div> <!-- Fin Row -->
        </div> <!-- Fin container-fluid -->
    </div> <!-- Fin envoltorio-contenido -->
</div> <!-- Fin contenedor-principal -->

{{-- Modal de confirmación exitosa --}}
@if(session('modal_success'))
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true" style="z-index: 9999 !important;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="modalSuccessLabel">
                    <i class="{{ session('modal_success.icon') }}"></i> {{ session('modal_success.title') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal()"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="{{ session('modal_success.icon') }} text-success" style="font-size: 4em;"></i>
                <p class="mt-3 fs-5">{{ session('modal_success.message') }}</p>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-success btn-lg px-4" data-bs-dismiss="modal" onclick="cerrarModal()">
                    <i class="bi bi-check-lg"></i> Entendido
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show" id="modalBackdrop" style="z-index: 9998 !important;"></div>

<style>
    #modalSuccess {
        display: block !important;
    }
    #modalBackdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }
    body.modal-open {
        overflow: hidden;
    }
</style>

<script>
    function cerrarModal() {
        const modal = document.getElementById('modalSuccess');
        const backdrop = document.getElementById('modalBackdrop');
        
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalSuccess');
        const backdrop = document.getElementById('modalBackdrop');
        
        if (modal) {
            // Agregar clase show para animación
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
            
            // Bloquear scroll del body
            document.body.classList.add('modal-open');
            
            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    cerrarModal();
                }
            });
            
            // Cerrar al hacer clic en el backdrop
            if (backdrop) {
                backdrop.addEventListener('click', cerrarModal);
            }
        }
    });
</script>
@endif
@endsection
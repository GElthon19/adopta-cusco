@extends('layouts.app')

@section('title', 'Solicitar Adopción')

@push('css')
<style>
    /* Modal completamente personalizado */
    #imageModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        z-index: 9999 !important;
        overflow: auto;
        padding: 20px;
    }
    
    #imageModal.show {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }
    
    #imageModal .modal-dialog {
        z-index: 10000 !important;
        position: relative;
        margin: auto;
        max-width: 900px;
        width: 100%;
    }
    
    #imageModal .modal-content {
        z-index: 10001 !important;
        position: relative;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }
    
    #imageModal .modal-header {
        z-index: 10002 !important;
        position: relative;
        padding: 20px 25px;
        border-bottom: 1px solid #dee2e6;
        background: linear-gradient(135deg, #69D1C4 0%, #4EC3B4 100%);
        color: white;
    }
    
    #imageModal .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    #imageModal .modal-body {
        z-index: 10002 !important;
        position: relative;
        padding: 0;
        background: #f8f9fa;
    }
    
    #imageModal .modal-body img {
        display: block;
        margin: 0 auto;
    }
    
    #imageModal .modal-footer {
        z-index: 10002 !important;
        position: relative;
        padding: 15px 25px;
        border-top: 1px solid #dee2e6;
        background: white;
    }
    
    #imageModal .btn-close {
        z-index: 10003 !important;
        background-color: white;
        opacity: 0.9;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        padding: 0;
    }
    
    #imageModal .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        #imageModal {
            padding: 10px;
        }
        
        #imageModal .modal-header {
            padding: 15px;
        }
        
        #imageModal .modal-title {
            font-size: 1.2rem;
        }
        
        #imageModal .modal-footer {
            padding: 12px 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Solicitar Adopción</h1>

    @if(session('ok'))
        <div class="alert alert-success" style="margin-top: 10px;">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($selected_animal)
        <p class="mb-4">
            Completa este formulario para solicitar la adopción de
            <strong>{{ optional($selected_animal)->nombre }}</strong>.
        </p>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        @if(!empty($selected_animal->imagen))
                            <div class="position-relative">
                                <img src="{{ asset('img/' . $selected_animal->imagen) }}" 
                                     alt="{{ $selected_animal->nombre }}" 
                                     class="img-fluid rounded" 
                                     style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                     onclick="openImageModal()">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <button type="button" class="btn btn-sm btn-light rounded-circle" onclick="openImageModal()" title="Ver imagen completa">
                                        <i class="bi bi-zoom-in"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="height:200px;">
                                <small class="text-muted">Sin imagen</small>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h5 class="mb-3">{{ optional($selected_animal)->nombre ?? '—' }}</h5>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2"><strong>Especie:</strong> {{ optional($selected_animal)->especie ?? '—' }}</p>
                                <p class="mb-2"><strong>Edad:</strong> {{ optional($selected_animal)->edad ?? '—' }} años</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-2"><strong>Estado:</strong> 
                                    <span class="badge bg-success">{{ optional($selected_animal)->estado ?? '—' }}</span>
                                </p>
                                <p class="mb-2"><strong>Ingreso:</strong> {{ optional($selected_animal)->fecha_ingreso ?? '—' }}</p>
                            </div>
                        </div>
                        @if(!empty($selected_animal->descripcion))
                            <p class="mb-0 text-muted small"><strong>Descripción:</strong> {{ $selected_animal->descripcion }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para ver imagen grande -->
        <div id="imageModal" onclick="closeImageModal(event)">
            <div class="modal-dialog modal-dialog-centered" onclick="event.stopPropagation()">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-image"></i> {{ $selected_animal->nombre }}
                        </h5>
                        <button type="button" class="btn-close" onclick="closeImageModal()" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        @if(!empty($selected_animal->imagen))
                            <img src="{{ asset('img/' . $selected_animal->imagen) }}" 
                                 alt="{{ $selected_animal->nombre }}" 
                                 class="img-fluid"
                                 style="max-height: 65vh; width: 100%; object-fit: contain;">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeImageModal()">
                            <i class="bi bi-x-circle"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function openImageModal() {
                document.getElementById('imageModal').classList.add('show');
                document.body.style.overflow = 'hidden';
            }
            
            function closeImageModal(event) {
                if (!event || event.target.id === 'imageModal') {
                    document.getElementById('imageModal').classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            }
            
            // Cerrar con tecla ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeImageModal();
                }
            });
        </script>

        <form method="POST" action="{{ route('solicitudes_adopcion.store') }}">
            @csrf
            <input type="hidden" name="id_animal" value="{{ $selected_animal->id_animales }}">

            <div class="alert alert-info mb-3">
                <strong><i class="bi bi-envelope-fill"></i> Solicitante:</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono de contacto <span class="text-danger">*</span></label>
                <input id="telefono" name="telefono" type="text" class="form-control" value="{{ old('telefono') }}" required placeholder="987654321">
                @error('telefono') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección completa <span class="text-danger">*</span></label>
                <input id="direccion" name="direccion" type="text" class="form-control" value="{{ old('direccion') }}" required placeholder="Av. La Cultura 456, Cusco">
                @error('direccion') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="motivo" class="form-label">¿Por qué deseas adoptar a {{ $selected_animal->nombre }}? <span class="text-danger">*</span></label>
                <textarea id="motivo" name="motivo" class="form-control" rows="4" required placeholder="Cuéntanos por qué quieres adoptar...">{{ old('motivo') }}</textarea>
                @error('motivo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <small class="text-muted">Explica tu experiencia con mascotas, condiciones de tu hogar, etc.</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="submitBtn">Enviar solicitud</button>
                <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    @else
        <div class="alert alert-warning">
            <h5>Animal no encontrado</h5>
            <p>El animal que intentas adoptar no existe o ya no está disponible.</p>
            <a href="{{ route('usuario.index') }}" class="btn btn-primary">Volver a la lista de animales</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Verificar que todos los campos requeridos estén llenos
                const requiredFields = form.querySelectorAll('[required]');
                let allFieldsFilled = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        allFieldsFilled = false;
                    }
                });
                
                if (!allFieldsFilled) {
                    alert('Por favor, completa todos los campos obligatorios.');
                    return;
                }
                
                // Mostrar confirmación
                if (confirm('¿Estás seguro de que deseas enviar esta solicitud de adopción?')) {
                    // Deshabilitar el botón para evitar envíos duplicados
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
                    
                    // Enviar el formulario
                    form.submit();
                }
            });
        }
    });
</script>
@endpush

@endsection
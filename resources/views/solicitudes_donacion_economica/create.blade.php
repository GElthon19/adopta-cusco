@extends('layouts.app')
@section('title', 'Donar al Albergue')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Botón para regresar -->
            <div class="mb-4">
                <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al inicio
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="bi bi-cash-coin"></i> Donar al Albergue</h3>
                    <p class="mb-0">Tu apoyo nos ayuda a cuidar mejor a nuestros animales</p>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5>Por favor corrija los siguientes errores:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('solicitudes-donacion-economica.store') }}" method="POST">
                        @csrf

                        <!-- Información del donante -->
                        <div class="alert alert-info" style="margin-top: 10px;">
                            <strong><i class="bi bi-person-fill"></i> Tus datos:</strong><br>
                            Nombre: {{ Auth::user()->name }}<br>
                            Email: {{ Auth::user()->email }}
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tu teléfono de contacto (opcional)</label>
                            <input type="text" name="telefono" class="form-control" placeholder="987654321" value="{{ old('telefono') }}">
                        </div>

                        <hr class="my-4">

                        <!-- Solo donación de dinero -->
                        <input type="hidden" name="tipo_donacion" value="Efectivo">
                        
                        <div class="alert alert-info">
                            <h5><i class="bi bi-info-circle"></i> Donaciones en línea</h5>
                            <p class="mb-0">Por ahora solo aceptamos donaciones de <strong>dinero en efectivo</strong> a través de la web.</p>
                            <p class="mb-0">Si deseas donar alimentos, medicinas u otros bienes, por favor visítanos directamente en el albergue.</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Monto a donar (S/.) <span class="text-danger">*</span></label>
                            <input type="number" name="monto" class="form-control" step="0.01" min="1" placeholder="50.00" value="{{ old('monto') }}" required>
                            <small class="text-muted">Monto en soles peruanos</small>
                        </div>

                        <!-- Información de pago -->
                        <div>
                            <div class="alert alert-success" style="margin-top: 10px;">
                                <h5><i class="bi bi-bank"></i> Información para transferencias:</h5>
                                <p class="mb-2"><strong>Banco:</strong> BCP</p>
                                <p class="mb-2"><strong>Cuenta Corriente:</strong> 191-12345678-0-00</p>
                                <p class="mb-2"><strong>CCI:</strong> 002-191-001234567800-00</p>
                                <p class="mb-2"><strong>Titular:</strong> Albergue Adopta Cusco</p>
                                <hr>
                                <h5><i class="bi bi-phone"></i> Billeteras digitales:</h5>
                                <p class="mb-2"><strong>Yape / Plin:</strong> 987 654 321</p>
                                <p class="mb-0"><small class="text-muted">Por favor envía el comprobante a nuestro WhatsApp después de realizar la transferencia</small></p>
                            </div>
                        </div>

                        <div class="alert alert-info" style="margin-top: 10px;">
                            <strong>⏳ Verificación:</strong> Tu donación será verificada en un máximo de 24 horas. Te contactaremos para confirmar la recepción.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-lg text-dark">
                                <i class="bi bi-heart-fill"></i> Confirmar Donación
                            </button>
                            <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Adopta Cusco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #69D1C4;
            --secondary-color: #4EC3B4;
            --dark-color: #2C7A7B;
            --light-bg: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, #e0f7f5 0%, #ffffff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            min-height: 100vh;
            position: fixed;
            width: 250px;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: #6c757d;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .info-panel {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .welcome-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .welcome-header h1 {
            font-size: 2.5em;
            margin: 0;
            font-weight: 300;
        }

        .welcome-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .activity-item {
            padding: 15px;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: #e0f7f5;
            transform: translateX(5px);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
        }

        .activity-time {
            color: #6c757d;
            font-size: 0.85em;
        }

        .badge-turquesa {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="p-3 text-center">
                    <h4><i class="bi bi-hearts"></i> Adopta Cusco</h4>
                    <p class="text-muted small">Panel Administrativo</p>
                </div>
                <nav class="nav flex-column">
                    <a href="{{ route('animales.index') }}" class="nav-link">
                        <i class="bi bi-heart"></i> Animales
                    </a>
                    <a href="{{ route('admin.adopciones.index') }}" class="nav-link">
                        <i class="bi bi-house"></i> Adopciones
                    </a>
                    <a href="{{ route('admin.donaciones.index') }}" class="nav-link">
                        <i class="bi bi-cash-coin"></i> Donaciones
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <i class="bi bi-info-circle"></i> Información
                    </a>
                    <hr>
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="bi bi-eye"></i> Ver Sitio
                    </a>
                    <div class="mt-3 p-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Welcome Header -->
                <div class="welcome-header">
                    <h1><i class="bi bi-info-circle"></i> Información del Administrador</h1>
                    <p>Detalles de tu cuenta y actividad reciente en el sistema</p>
                </div>

                <!-- Filtros de Fecha -->
                <div class="info-panel mb-4">
                    <h5 class="mb-3"><i class="bi bi-funnel"></i> Filtros de Fecha</h5>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                                   value="{{ $fechaInicio ?? now()->subMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" 
                                   value="{{ $fechaFin ?? now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border: none;">
                                <i class="bi bi-search"></i> Filtrar
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <!-- Información del Administrador -->
                    <div class="col-md-5">
                        <div class="info-panel">
                            <h4 class="mb-4" style="color: var(--dark-color);">
                                <i class="bi bi-person-circle"></i> Información del Administrador
                            </h4>
                            <div class="d-flex align-items-center mb-3">
                                <div class="activity-icon me-3">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <strong style="color: var(--dark-color);">{{ Auth::user()->name }}</strong>
                                    <div class="activity-time">Administrador Principal</div>
                                </div>
                            </div>
                            <ul class="list-unstyled mt-4">
                                <li class="mb-3">
                                    <i class="bi bi-envelope" style="color: var(--primary-color);"></i>
                                    <strong>Email:</strong> {{ Auth::user()->email }}
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-shield-check" style="color: var(--secondary-color);"></i>
                                    <strong>Rol:</strong> <span class="badge badge-turquesa">Administrador</span>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-calendar-check" style="color: var(--dark-color);"></i>
                                    <strong>Último acceso:</strong> {{ now()->format('d/m/Y H:i') }}
                                </li>
                            </ul>
                            <hr>
                            <div class="d-grid">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary" style="border-color: var(--primary-color); color: var(--dark-color);">
                                    <i class="bi bi-eye"></i> Ver Sitio Público
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Actividad Reciente -->
                    <div class="col-md-7">
                        <div class="info-panel">
                            <h4 class="mb-4" style="color: var(--dark-color);">
                                <i class="bi bi-clock-history"></i> Historial de Actividades
                            </h4>
                            <p class="text-muted small mb-4">
                                <i class="bi bi-info-circle"></i> Registro de las últimas acciones realizadas en el sistema
                            </p>
                            
                            @php
                                $recentActivities = collect([
                                    (object)[
                                        'icon' => 'house-heart-fill',
                                        'action' => 'Adopción aprobada',
                                        'details' => 'Aprobaste la solicitud de adopción',
                                        'time' => \App\Models\Adopcion::where('estado', 'Aprobada')->latest('updated_at')->first()?->updated_at ?? now()
                                    ],
                                    (object)[
                                        'icon' => 'heart-fill',
                                        'action' => 'Animal registrado',
                                        'details' => 'Agregaste un nuevo animal al sistema',
                                        'time' => \App\Models\Animal::latest()->first()?->created_at ?? now()
                                    ],
                                    (object)[
                                        'icon' => 'cash-coin',
                                        'action' => 'Donación registrada',
                                        'details' => 'Registraste una donación económica',
                                        'time' => \App\Models\Donaciones::latest()->first()?->created_at ?? now()
                                    ],
                                    (object)[
                                        'icon' => 'pencil-square',
                                        'action' => 'Animal actualizado',
                                        'details' => 'Modificaste la información de un animal',
                                        'time' => \App\Models\Animal::latest('updated_at')->first()?->updated_at ?? now()
                                    ],
                                    (object)[
                                        'icon' => 'x-circle',
                                        'action' => 'Adopción rechazada',
                                        'details' => 'Rechazaste una solicitud de adopción',
                                        'time' => \App\Models\Adopcion::where('estado', 'Rechazada')->latest('updated_at')->first()?->updated_at ?? now()
                                    ],
                                ])->sortByDesc('time')->take(5);
                            @endphp

                            @if($recentActivities->isNotEmpty())
                                @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="d-flex align-items-start">
                                        <div class="activity-icon me-3">
                                            <i class="bi bi-{{ $activity->icon }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong style="color: var(--dark-color);">{{ $activity->action }}</strong>
                                            <p class="mb-1 text-muted small">{{ $activity->details }}</p>
                                            <div class="activity-time">
                                                <i class="bi bi-clock"></i> 
                                                {{ $activity->time->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 3em; opacity: 0.3;"></i>
                                <p class="mt-2">No hay actividad registrada aún</p>
                                <small>Las acciones que realices aparecerán aquí</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Estadísticas y Gráficos -->
                @if(isset($stats))
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="mb-4" style="color: var(--dark-color);">
                            <i class="bi bi-bar-chart-fill"></i> Estadísticas del Sistema
                        </h4>
                    </div>

                    <!-- Tarjetas de estadísticas -->
                    <div class="col-md-3 mb-3">
                        <div class="info-panel text-center">
                            <i class="bi bi-heart-fill" style="font-size: 2em; color: var(--primary-color);"></i>
                            <h3 class="mt-2">{{ $stats['total_animales'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Animales Registrados</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="info-panel text-center">
                            <i class="bi bi-check-circle-fill" style="font-size: 2em; color: #28a745;"></i>
                            <h3 class="mt-2">{{ $stats['animales_adoptados'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Animales Adoptados</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="info-panel text-center">
                            <i class="bi bi-calendar-check" style="font-size: 2em; color: var(--secondary-color);"></i>
                            <h3 class="mt-2">{{ $stats['adopciones_pendientes'] ?? 0 }}</h3>
                            <p class="text-muted mb-0">Solicitudes Pendientes</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="info-panel text-center">
                            <i class="bi bi-cash-coin" style="font-size: 2em; color: #FFD700;"></i>
                            <h3 class="mt-2">S/. {{ number_format($stats['monto_total_donaciones'] ?? 0, 2) }}</h3>
                            <p class="text-muted mb-0">Total Donaciones</p>
                        </div>
                    </div>

                    <!-- Gráficos -->
                    <div class="col-md-6 mb-3">
                        <div class="info-panel">
                            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Adopciones en el Período</h5>
                            <div style="height: 250px; max-height: 250px;">
                                <canvas id="adopcionesChart"></canvas>
                            </div>
                            <div class="mt-3 text-center">
                                <span class="badge bg-success">Aprobadas: {{ $stats['adopciones_aprobadas'] ?? 0 }}</span>
                                <span class="badge bg-danger">Rechazadas: {{ $stats['adopciones_rechazadas'] ?? 0 }}</span>
                                <span class="badge bg-warning text-dark">Pendientes: {{ $stats['adopciones_pendientes'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-panel">
                            <h5 class="mb-3"><i class="bi bi-currency-dollar"></i> Donaciones en el Período</h5>
                            <div style="height: 250px; max-height: 250px;">
                                <canvas id="donacionesChart"></canvas>
                            </div>
                            <div class="mt-3 text-center">
                                <span class="badge badge-turquesa">Total: {{ $stats['total_donaciones'] ?? 0 }} donaciones</span>
                                <span class="badge bg-warning text-dark">Pendientes: {{ $stats['donaciones_pendientes'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico de animales por tipo -->
                    @if(isset($animalesPorTipo) && $animalesPorTipo->count() > 0)
                    <div class="col-md-6 mb-3">
                        <div class="info-panel">
                            <h5 class="mb-3"><i class="bi bi-pie-chart"></i> Animales por Tipo</h5>
                            <div style="height: 250px; max-height: 250px;">
                                <canvas id="animalesPorTipoChart"></canvas>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Gráfico de estado de adopciones -->
                    <div class="col-md-6 mb-3">
                        <div class="info-panel">
                            <h5 class="mb-3"><i class="bi bi-speedometer2"></i> Estado de Adopciones</h5>
                            <div style="height: 250px; max-height: 250px;">
                                <canvas id="estadoAdopcionesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Animales Adoptados Recientemente -->
                    <div class="col-12 mb-3">
                        <div class="info-panel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="bi bi-heart-fill text-danger"></i> Animales Adoptados Recientemente</h5>
                                <a href="{{ route('animales-adoptados.index') }}" class="btn btn-sm btn-outline-primary">
                                    Ver todos
                                </a>
                            </div>
                            
                            @php
                                $animalesAdoptados = \App\Models\Animal::where('estado', 'Adoptado')
                                    ->whereBetween('updated_at', [$fechaInicio ?? now()->subMonth(), ($fechaFin ?? now()) . ' 23:59:59'])
                                    ->orderBy('updated_at', 'desc')
                                    ->take(6)
                                    ->get();
                            @endphp
                            
                            @if($animalesAdoptados->count() > 0)
                            <div class="row g-3">
                                @foreach($animalesAdoptados as $animal)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card shadow-sm h-100">
                                        @if($animal->imagen)
                                        <img src="{{ asset('img/' . $animal->imagen) }}" class="card-img-top" alt="{{ $animal->nombre }}" 
                                             style="height: 200px; object-fit: cover;">
                                        @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="bi bi-image" style="font-size: 3em;"></i>
                                        </div>
                                        @endif
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="card-title mb-0">{{ $animal->nombre }}</h5>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Adoptado
                                                </span>
                                            </div>
                                            <p class="card-text text-muted small mb-2">
                                                <strong>Especie:</strong> {{ $animal->especie ?? 'N/A' }}<br>
                                                <strong>Raza:</strong> {{ $animal->raza ?? 'N/A' }}
                                            </p>
                                            <div class="text-muted small">
                                                <i class="bi bi-calendar-check"></i> {{ $animal->updated_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3em; opacity: 0.3;"></i>
                                <p class="mt-2 text-muted">No hay animales adoptados en este período</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    @if(isset($adopcionesPorMes) && isset($donacionesPorMes))
    <script>
    // Preparar datos de adopciones por fecha
    const adopcionesLabels = @json($adopcionesPorMes->pluck('fecha')->map(function($fecha) {
        return date('d/m', strtotime($fecha));
    }));
    const adopcionesValues = @json($adopcionesPorMes->pluck('total'));

    // Preparar datos de donaciones por fecha
    const donacionesLabels = @json($donacionesPorMes->pluck('fecha')->map(function($fecha) {
        return date('d/m', strtotime($fecha));
    }));
    const donacionesValues = @json($donacionesPorMes->pluck('total'));

    // Gráfico de adopciones
    const adopcionesCtx = document.getElementById('adopcionesChart').getContext('2d');
    new Chart(adopcionesCtx, {
        type: 'line',
        data: {
            labels: adopcionesLabels,
            datasets: [{
                label: 'Adopciones',
                data: adopcionesValues,
                backgroundColor: 'rgba(105, 209, 196, 0.2)',
                borderColor: '#69D1C4',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#69D1C4',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Gráfico de donaciones
    const donacionesCtx = document.getElementById('donacionesChart').getContext('2d');
    new Chart(donacionesCtx, {
        type: 'bar',
        data: {
            labels: donacionesLabels,
            datasets: [{
                label: 'Donaciones (S/.)',
                data: donacionesValues,
                backgroundColor: 'rgba(78, 195, 180, 0.7)',
                borderColor: '#4EC3B4',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'S/. ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'S/. ' + value;
                        }
                    }
                }
            }
        }
    });

    // Gráfico de animales por tipo
    @if(isset($animalesPorTipo) && $animalesPorTipo->count() > 0)
    const animalesPorTipoCtx = document.getElementById('animalesPorTipoChart').getContext('2d');
    new Chart(animalesPorTipoCtx, {
        type: 'doughnut',
        data: {
            labels: @json($animalesPorTipo->pluck('tipo')),
            datasets: [{
                data: @json($animalesPorTipo->pluck('total')),
                backgroundColor: [
                    'rgba(105, 209, 196, 0.8)',
                    'rgba(78, 195, 180, 0.8)',
                    'rgba(44, 122, 123, 0.8)',
                    'rgba(255, 215, 0, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12
                }
            }
        }
    });
    @endif

    // Gráfico de estado de adopciones
    const estadoAdopcionesCtx = document.getElementById('estadoAdopcionesChart').getContext('2d');
    new Chart(estadoAdopcionesCtx, {
        type: 'pie',
        data: {
            labels: ['Aprobadas', 'Rechazadas', 'Pendientes'],
            datasets: [{
                data: [
                    {{ $stats['adopciones_aprobadas'] ?? 0 }},
                    {{ $stats['adopciones_rechazadas'] ?? 0 }},
                    {{ $stats['adopciones_pendientes'] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12
                }
            }
        }
    });
    </script>
    @endif
</body>
</html>

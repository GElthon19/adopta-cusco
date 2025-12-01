<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Adopta Cusco')</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Vite Assets (incluye todos los CSS personalizados) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- CSRF Token para peticiones AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @stack('css')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <!-- CONTENEDOR DE PATITAS PARTICULAS -->
            <div id="patitas-particulas"></div>
            
            <a class="navbar-brand" href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('home') : route('usuario.index')) : route('login') }}">
                <img src="{{ asset('img/logo_cusco_adopta.webp') }}" alt="Logo" class="navbar-logo">
                <span class="d-none d-sm-inline">Cusco Adopta</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto align-items-center">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <!-- NAVBAR ADMIN -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house-door"></i> Inicio
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-heart"></i> Adopciones
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownAdopciones">
                                    <li><a class="dropdown-item" href="{{ route('admin.adopciones.index') }}">
                                        <i class="bi bi-list-ul"></i> Ver Solicitudes
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.adopciones.presencial.create') }}">
                                        <i class="bi bi-plus-circle"></i> Registrar Presencial
                                    </a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gift"></i> Donaciones
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownDonaciones">
                                    <li><h6 class="dropdown-header">Animales</h6></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.donaciones-animales.index') }}">
                                        <i class="bi bi-list-ul"></i> Ver Solicitudes
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.donaciones-animales.presencial.create') }}">
                                        <i class="bi bi-plus-circle"></i> Registrar Presencial
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Económicas/Bienes</h6></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.donaciones.index') }}">
                                        <i class="bi bi-list-ul"></i> Ver Donaciones
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.donaciones.presencial.create') }}">
                                        <i class="bi bi-plus-circle"></i> Registrar Presencial
                                    </a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('animales.index') }}">
                                    <i class="bi bi-grid"></i> Animales
                                </a>
                            </li>
                            <li class="nav-item position-relative">
                                <a class="nav-link position-relative" href="#" id="notification-icon">
                                    <i class="bi bi-bell"></i> Notificaciones
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge" style="display: none;">
                                        0
                                    </span>
                                </a>
                                
                                <!-- Dropdown de notificaciones -->
                                <div class="notifications-dropdown" id="notifications-dropdown">
                                    <div class="notifications-dropdown-header">
                                        <span><i class="bi bi-bell-fill"></i> Notificaciones</span>
                                        <a href="{{ route('notifications.index') }}" class="text-white text-decoration-none">
                                            <small>Ver todas</small>
                                        </a>
                                    </div>
                                    <div class="notifications-dropdown-body" id="notifications-container">
                                        <div class="notification-empty">
                                            <i class="bi bi-bell-slash"></i>
                                            <p>Cargando notificaciones...</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-bar-chart-fill"></i> Panel de Control
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('content-blocks.index') }}">
                                        <i class="bi bi-file-text"></i> Gestión de Contenido
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <!-- NAVBAR USUARIO -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuario.index') }}">
                                    <i class="bi bi-house-heart"></i> Inicio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuario.index') }}#mascotas">
                                    <i class="bi bi-search-heart"></i> Ver Mascotas
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-heart-fill"></i> Colaborar
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('solicitudes-donacion-animal.create') }}">
                                        <i class="bi bi-gift"></i> Donar un Animal
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes-donacion-economica.create') }}">
                                        <i class="bi bi-cash-coin"></i> Donar Dinero
                                    </a></li>
                                </ul>
                            </li>
                            <li class="nav-item position-relative">
                                <a class="nav-link position-relative" href="#" id="notification-icon">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge" style="display: none;">
                                        0
                                    </span>
                                </a>
                                
                                <!-- Dropdown de notificaciones para usuario -->
                                <div class="notifications-dropdown" id="notifications-dropdown">
                                    <div class="notifications-dropdown-header">
                                        <span><i class="bi bi-bell-fill"></i> Mis Notificaciones</span>
                                        <a href="{{ route('notifications.index') }}" class="text-white text-decoration-none">
                                            <small>Ver todas</small>
                                        </a>
                                    </div>
                                    <div class="notifications-dropdown-body" id="notifications-container">
                                        <div class="notification-empty">
                                            <i class="bi bi-bell-slash"></i>
                                            <p>Cargando notificaciones...</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><span class="dropdown-item-text small text-muted">{{ Auth::user()->email }}</span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <!-- NAVBAR NO AUTENTICADO -->
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="{{ route('login') }}">
                                <i class="bi bi-person-plus"></i> Crear Cuenta
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @if(session('ok'))
        <div class="alert alert-success" style="margin-top: 10px;">{{ session('ok') }}</div>
        @endif
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DEBUG: Asegurar que dropdowns funcionen -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // FORZAR QUE EL NAVBAR SE MUESTRE EN PANTALLAS GRANDES
        const navbarCollapse = document.getElementById('navbarContent');
        if (window.innerWidth >= 992) {
            navbarCollapse.classList.add('show');
        }
        
        // Mantener el navbar visible cuando se redimensiona la ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                navbarCollapse.classList.add('show');
            } else {
                navbarCollapse.classList.remove('show');
            }
        });
        
        // Verificar que Bootstrap está cargado
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap JS no está cargado!');
        } else {
            console.log('Bootstrap cargado correctamente, versión:', bootstrap.Dropdown.VERSION);
        }
        
        // Inicializar todos los dropdowns manualmente
        const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
        const dropdownList = [...dropdownElementList].map(dropdownToggleEl => {
            return new bootstrap.Dropdown(dropdownToggleEl, {
                autoClose: true,
                boundary: 'viewport'
            });
        });
        
        console.log('Dropdowns inicializados:', dropdownList.length);
    });
    </script>
    
    <!-- SCRIPT PATITAS PARTICULAS -->
    <script>
    function crearParticulaPatita() {
        const contenedor = document.getElementById('patitas-particulas');
        const patitas = ['🐾', '🐕', '🐈'];
        
        const particula = document.createElement('div');
        particula.className = 'patita-particula';
        particula.textContent = patitas[Math.floor(Math.random() * patitas.length)];
        
        const left = Math.random() * 100;
        const top = 20 + Math.random() * 60;
        
        particula.style.left = left + '%';
        particula.style.top = top + '%';
        
        const size = 15 + Math.random() * 25;
        particula.style.fontSize = size + 'px';
        
        const duration = 1.5 + Math.random() * 1;
        particula.style.animationDuration = duration + 's';
        
        contenedor.appendChild(particula);
        
        setTimeout(() => {
            if (particula.parentNode) {
                particula.parentNode.removeChild(particula);
            }
        }, duration * 1000);
    }

    setInterval(crearParticulaPatita, 500);

    for (let i = 0; i < 5; i++) {
        setTimeout(crearParticulaPatita, i * 200);
    }
    </script>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cusco Adopta - Dale un hogar, gana un amigo para siempre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Patitas cayendo en navbar y hero */
        #patitas-navbar, #patitas-hero {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .patita-cayendo {
            position: absolute;
            font-size: 30px;
            opacity: 0;
            animation-duration: 10s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-fill-mode: forwards;
        }

        @keyframes caer-derecha {
            0% {
                top: -50px;
                opacity: 0;
                transform: translateX(0px) rotate(0deg);
            }
            5% {
                opacity: 0.4;
            }
            50% {
                transform: translateX(150px) rotate(180deg);
            }
            95% {
                opacity: 0.4;
            }
            100% {
                top: 110%;
                transform: translateX(250px) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes caer-izquierda {
            0% {
                top: -50px;
                opacity: 0;
                transform: translateX(0px) rotate(0deg);
            }
            5% {
                opacity: 0.4;
            }
            50% {
                transform: translateX(-150px) rotate(-180deg);
            }
            95% {
                opacity: 0.4;
            }
            100% {
                top: 110%;
                transform: translateX(-250px) rotate(-360deg);
                opacity: 0;
            }
        }

        /* Navbar */
        .navbar-custom {
            position: relative;
            z-index: 1020;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #69D1C4, #4EC3B4, #3FB5A8);
            background-size: cover;
            background-position: center;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 20;
        }

        .hero-content p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 20;
        }

        .hero-btn {
            background: white;
            color: #2C7A7B;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            z-index: 20;
        }

        .hero-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: #2C7A7B;
        }

        /* Campañas Section */
        .campanas-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .campana-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .campana-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(105, 209, 196, 0.3);
            border-color: #69D1C4;
        }

        .campana-card img {
            width: 100%;
            height: 250px;
            object-fit: contain;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .campana-card h3 {
            color: #2C7A7B;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .campana-card p {
            color: #555;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .campana-badge {
            background: linear-gradient(135deg, #69D1C4, #4EC3B4);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        /* Logo municipalidad */
        .campana-card .logo-municipalidad {
            width: 200px !important;
            height: 200px !important;
            object-fit: contain;
            margin: 20px auto;
            display: block;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #2C7A7B, #1a5f60);
            color: white;
            padding: 60px 0 30px;
        }

        footer h5 {
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 1.3rem;
        }

        footer p, footer a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        footer a:hover {
            color: #69D1C4;
            text-decoration: underline;
        }

        .social-links a {
            color: white;
            font-size: 2rem;
            margin: 0 15px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: #69D1C4;
            transform: scale(1.2);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.2rem;
            }

            .campana-card {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <!-- Patitas cayendo en navbar -->
        <div id="patitas-navbar"></div>
        
        <div class="container-fluid" style="position: relative; z-index: 10;">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('img/logo_cusco_adopta.webp') }}" alt="Logo" class="navbar-logo" style="width: 60px; height: 60px; margin-right: 15px;">
                <span>Cusco Adopta</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-light" href="{{ route('login') }}" style="font-weight: 600; padding: 10px 30px; border-radius: 50px; border: 2px solid white;">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light" href="{{ route('login') }}" style="background: white; color: #2C7A7B; font-weight: 600; padding: 10px 30px; border-radius: 50px;">
                            <i class="bi bi-person-plus"></i> Crear Cuenta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Patitas cayendo en hero -->
        <div id="patitas-hero"></div>
        
        <div class="hero-content">
            <h1>🐾 Bienvenido a Cusco Adopta 🐾</h1>
            <p>Dale un hogar, gana un amigo para siempre</p>
            <a href="{{ route('login') }}" class="hero-btn">
                Comienza Ahora <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Campañas Section -->
    <section class="campanas-section">
        <div class="container">
            <div class="row">
                <!-- Campaña Plaza Túpac Amaru -->
                <div class="col-md-6 mb-4">
                    <div class="campana-card">
                        <img src="{{ asset('img/campTupac.webp') }}" alt="Campaña Plaza Túpac Amaru">
                        <h3><i class="bi bi-calendar-event"></i> Campaña de Adopción en Plaza Túpac Amaru</h3>
                        <p>
                            <strong>📍 Ubicación:</strong> Plaza Túpac Amaru, Cusco
                        </p>
                        <p>
                            <strong>📅 Frecuencia:</strong> Cada quince días (un sábado sí y un sábado no)
                        </p>
                        <p>
                            <strong>🕐 Horario:</strong> 10:00 a.m. a 2:00 p.m.
                        </p>
                        <p>
                            Ven a conocer a nuestros adorables animales en busca de un hogar. 
                            Realizamos eventos públicos donde puedes interactuar con ellos y comenzar el proceso de adopción.
                        </p>
                        <span class="campana-badge">
                            <i class="bi bi-heart-fill"></i> Próximo Evento
                        </span>
                    </div>
                </div>

                <!-- Campaña Municipalidad -->
                <div class="col-md-6 mb-4">
                    <div class="campana-card">
                        <img src="{{ asset('img/municipio_san_jeronimo_logo.webp') }}" alt="Municipalidad San Jerónimo" class="logo-municipalidad">
                        <h3><i class="bi bi-building"></i> Campañas con la Municipalidad de San Jerónimo</h3>
                        <p>
                            <strong>🤝 Trabajo conjunto:</strong> En alianza con la Municipalidad de San Jerónimo
                        </p>
                        <p>
                            <strong>🏥 Servicios:</strong> Adopción y Esterilización
                        </p>
                        <p>
                            <strong>📍 Cobertura:</strong> Diferentes zonas del distrito
                        </p>
                        <p>
                            Trabajamos de la mano con instituciones públicas para realizar campañas masivas de adopción 
                            y esterilización en diversas zonas de San Jerónimo, llegando a más comunidades y ayudando 
                            a más animales necesitados.
                        </p>
                        <span class="campana-badge">
                            <i class="bi bi-check-circle-fill"></i> Programa Activo
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Información del Albergue -->
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-house-heart"></i> Cusco Adopta</h5>
                    <p>
                        Somos un albergue dedicado al rescate, cuidado y adopción de animales en situación de calle. 
                        Nuestro compromiso es darles una segunda oportunidad.
                    </p>
                </div>

                <!-- Contacto -->
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-geo-alt"></i> Contacto</h5>
                    <p><i class="bi bi-pin-map"></i> Calle Pera #506 Int. 2<br>Cusco, Perú</p>
                    <p><i class="bi bi-telephone"></i> 910 231 260</p>
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-share"></i> Síguenos</h5>
                    <div class="social-links">
                        <a href="https://www.facebook.com/adopciondeperritosencusco" target="_blank" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.tiktok.com/@cuscoadoptaa" target="_blank" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="https://www.instagram.com/cuscoadopta" target="_blank" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                    <p class="mt-3">¡Síguenos para conocer historias de adopción y eventos!</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Cusco Adopta. Todos los derechos reservados.</p>
                <p>Hecho con <i class="bi bi-heart-fill" style="color: #ff6b6b;"></i> para los animales de Cusco</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Crear patitas cayendo en navbar y hero
        const navbarContainer = document.getElementById('patitas-navbar');
        const heroContainer = document.getElementById('patitas-hero');
        const patitasEmojis = ['🐾'];
        let direccion = 'derecha';

        function crearPatita(container) {
            const patita = document.createElement('div');
            patita.className = 'patita-cayendo';
            patita.textContent = patitasEmojis[0];
            
            patita.style.left = Math.random() * 100 + '%';
            patita.style.top = '-50px';
            
            if (direccion === 'derecha') {
                patita.style.animationName = 'caer-derecha';
            } else {
                patita.style.animationName = 'caer-izquierda';
            }
            
            patita.style.animationDuration = (8 + Math.random() * 4) + 's';
            patita.style.animationDelay = '0s';
            
            container.appendChild(patita);
            
            setTimeout(() => {
                patita.remove();
            }, 12000);
        }

        // Crear patitas para navbar
        setInterval(() => crearPatita(navbarContainer), 400);
        
        // Crear patitas para hero
        setInterval(() => crearPatita(heroContainer), 300);

        // Cambiar dirección cada 30 segundos
        setInterval(() => {
            direccion = direccion === 'derecha' ? 'izquierda' : 'derecha';
            
            const patitas = document.querySelectorAll('.patita-cayendo');
            patitas.forEach(patita => {
                if (direccion === 'derecha') {
                    patita.style.animationName = 'caer-derecha';
                } else {
                    patita.style.animationName = 'caer-izquierda';
                }
            });
        }, 30000);
    </script>
</body>
</html>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #69D1C4 0%, #4EC3B4 50%, #3FB5A8 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Contenedor de patitas cayendo */
        #patitas-lluvia {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        /* Animación de patita cayendo */
        .patita-cayendo {
            position: absolute;
            font-size: 40px;
            opacity: 0;
            animation-duration: 10s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-fill-mode: forwards;
        }

        /* Caída diagonal hacia la derecha */
        @keyframes caer-derecha {
            0% {
                top: -50px;
                opacity: 0;
                transform: translateX(0px) rotate(0deg);
            }
            5% {
                opacity: 0.6;
            }
            50% {
                transform: translateX(150px) rotate(180deg);
            }
            95% {
                opacity: 0.6;
            }
            100% {
                top: 110%;
                transform: translateX(250px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Caída diagonal hacia la izquierda */
        @keyframes caer-izquierda {
            0% {
                top: -50px;
                opacity: 0;
                transform: translateX(0px) rotate(0deg);
            }
            5% {
                opacity: 0.6;
            }
            50% {
                transform: translateX(-150px) rotate(-180deg);
            }
            95% {
                opacity: 0.6;
            }
            100% {
                top: 110%;
                transform: translateX(-250px) rotate(-360deg);
                opacity: 0;
            }
        }

        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
        }

        .login-card h4 {
            color: #2C7A7B;
            font-weight: 700;
        }

        .btn-primary {
            background: linear-gradient(135deg, #69D1C4, #4EC3B4);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(105, 209, 196, 0.4);
        }

        .alert-success {
            background: linear-gradient(135deg, #69D1C4, #4EC3B4);
            color: white;
            border: none;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Contenedor de patitas cayendo -->
    <div id="patitas-lluvia"></div>

    <div class="login-card">
        <h4 class="text-center mb-3">Iniciar sesión</h4>

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="mb-3 text-center">
            <a href="{{ route('google.redirect') }}" class="btn btn-danger w-100 mb-2">
                <i class="bi bi-google"></i> Iniciar sesión con Google
            </a>
        </div>

        <div class="text-center mb-3">o</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </div>

    <script>
        // Crear patitas cayendo como lluvia
        const container = document.getElementById('patitas-lluvia');
        const patitasEmojis = ['🐾', '🐾', '🐾']; // Solo patitas
        let direccion = 'derecha'; // Empezar hacia la derecha
        let tiempoTranscurrido = 0;

        function crearPatita() {
            const patita = document.createElement('div');
            patita.className = 'patita-cayendo';
            patita.textContent = patitasEmojis[Math.floor(Math.random() * patitasEmojis.length)];
            
            // Posición horizontal aleatoria
            patita.style.left = Math.random() * 100 + '%';
            
            // Posición vertical inicial (arriba de la pantalla, invisible)
            patita.style.top = '-50px';
            
            // Aplicar animación según dirección actual
            if (direccion === 'derecha') {
                patita.style.animationName = 'caer-derecha';
            } else {
                patita.style.animationName = 'caer-izquierda';
            }
            
            // Duración aleatoria entre 8-12 segundos
            patita.style.animationDuration = (8 + Math.random() * 4) + 's';
            
            // Sin delay para que empiece a caer inmediatamente
            patita.style.animationDelay = '0s';
            
            container.appendChild(patita);
            
            // Eliminar patita después de la animación
            setTimeout(() => {
                patita.remove();
            }, 12000);
        }

        // Crear patitas cada 300ms
        setInterval(crearPatita, 200);

        // Cambiar dirección cada 30 segundos con transición suave
        setInterval(() => {
            tiempoTranscurrido += 45;
            direccion = direccion === 'derecha' ? 'izquierda' : 'derecha';
            
            // Actualizar las patitas existentes con transición
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
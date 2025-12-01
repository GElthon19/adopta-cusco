# 🐾 Adopta Cusco

Sistema web para la gestión de adopciones de animales en Cusco, desarrollado con Laravel.

## 📋 Descripción

Plataforma web que facilita el proceso de adopción de animales, permitiendo a usuarios registrar animales disponibles, gestionar solicitudes de adopción y administrar campañas de adopción.

## ✨ Características

- 🐶 Gestión de animales disponibles para adopción
- 📝 Sistema de solicitudes de adopción
- 🎯 Campañas de adopción
- 👥 Sistema de usuarios con roles (admin/usuario)
- 🔔 Sistema de notificaciones
- 💰 Gestión de donaciones
- 📊 Panel administrativo

## 🚀 Deployment Rápido

**¡Tu proyecto está 100% listo para subir a producción!**

### Opción Recomendada: Railway.app (Gratis)

1. **Verifica que todo esté listo:**
   ```bash
   # En Windows:
   .\check-deployment.bat
   
   # En Linux/Mac:
   chmod +x check-deployment.sh
   ./check-deployment.sh
   ```

2. **Sube a GitHub:**
   ```bash
   git init
   git add .
   git commit -m "Ready for deployment"
   git remote add origin https://github.com/TU_USUARIO/adopta-cusco.git
   git push -u origin main
   ```

3. **Deploy en Railway:**
   - Ve a https://railway.app
   - Inicia sesión con GitHub
   - New Project → Deploy from GitHub
   - Selecciona `adopta-cusco`
   - Agrega PostgreSQL database
   - Configura variables de entorno
   - ¡Listo! 🎉

📖 **Guías completas:**
- [DEPLOY-QUICK.md](DEPLOY-QUICK.md) - Guía rápida (5 minutos)
- [DEPLOYMENT.md](DEPLOYMENT.md) - Guía completa detallada

## 💻 Instalación Local

### Requisitos

- PHP >= 8.2
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js & NPM (opcional, para assets)

### Pasos

1. **Clonar repositorio:**
   ```bash
   git clone https://github.com/TU_USUARIO/adopta-cusco.git
   cd adopta-cusco
   ```

2. **Instalar dependencias:**
   ```bash
   composer install
   ```

3. **Configurar entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos en `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=adopta_cusco
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Ejecutar migraciones:**
   ```bash
   php artisan migrate
   ```

6. **Crear usuario admin:**
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```

7. **Iniciar servidor:**
   ```bash
   php artisan serve
   ```

8. **Acceder:** http://localhost:8000

## 🔧 Tecnologías

- **Backend:** Laravel 11
- **Base de datos:** MySQL / PostgreSQL / SQLite
- **Frontend:** Blade Templates, CSS
- **Autenticación:** Laravel Auth

## 📁 Estructura del Proyecto

```
adopta-cusco/
├── app/
│   ├── Http/Controllers/    # Controladores
│   ├── Models/              # Modelos
│   └── Helpers/             # Helpers
├── database/
│   ├── migrations/          # Migraciones
│   └── seeders/            # Seeders
├── public/                 # Assets públicos
├── resources/
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php            # Rutas web
└── storage/               # Almacenamiento

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

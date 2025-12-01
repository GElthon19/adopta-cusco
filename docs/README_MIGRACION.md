
# Migración a Laravel - Adopta Cusco

Este paquete contiene **scaffolding** inicial para migrar tu proyecto PHP a Laravel:

- `database/migrations/`: migraciones generadas desde tu `adopta_cusco.sql` (4 tablas).
- `app/Models/`: modelos Eloquent básicos para cada tabla.
- `app/Http/Controllers/`: controladores _stub_ (uno por archivo PHP encontrado) para que mapees vistas/lógica.
- `routes/web.php`: rutas iniciales para acceder a cada sección inferida por nombre de archivo.

## Pasos

1. Crear proyecto Laravel
   ```bash
   composer create-project laravel/laravel adopta-cusco
   cd adopta-cusco
   ```

2. Configurar `.env` (MySQL):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=adopta_cusco
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password
   ```

3. Copiar los archivos generados de este paquete en tu proyecto:
   - `database/migrations/*` → `database/migrations`
   - `app/Models/*` → `app/Models`
   - `app/Http/Controllers/*` → `app/Http/Controllers`
   - `routes/web.php` → reemplazar/merge con el tuyo

4. Ejecutar migraciones:
   ```bash
   php artisan migrate
   ```

5. Crear vistas Blade en `resources/views/{seccion}/` según los controladores (por ejemplo `resources/views/usuarios/index.blade.php`).

6. Mover assets (CSS/JS/img) desde tu proyecto original a `public/` o `resources/` y, si usas Vite:
   ```bash
   npm install
   npm run dev
   ```

## Inventario rápido

- Archivos PHP: 2
- Assets: 31
- Otros archivos: 2
- Rutas inferidas: 2

## Notas
- Las migraciones son **best-effort**: revisa tipos/longitudes, claves compuestas y FKs complejas.
- Los controladores son _stubs_. Toca implementar validaciones (`FormRequest`), policies, etc.
- Si tu proyecto actual usa sesiones/login, te recomiendo instalar Breeze/Jetstream y mover la lógica a middlewares.

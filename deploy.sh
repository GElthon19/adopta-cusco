#!/bin/sh

echo "🚀 Iniciando deployment de Adopta Cusco..."

# Limpiar cache anterior
echo "🧹 Limpiando cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Ejecutar migraciones
echo "📦 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders (solo si es la primera vez)
# php artisan db:seed --force

# Crear enlace simbólico para storage
echo "🔗 Creando enlace de storage..."
php artisan storage:link

# Optimizar para producción
echo "⚡ Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "✅ Deployment completado exitosamente!"

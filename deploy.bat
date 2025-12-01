@echo off
echo 🚀 Iniciando deployment de Adopta Cusco...

echo 🧹 Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo 📦 Ejecutando migraciones...
php artisan migrate --force

echo 🔗 Creando enlace de storage...
php artisan storage:link

echo ⚡ Optimizando aplicación...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo ✅ Deployment completado exitosamente!
pause

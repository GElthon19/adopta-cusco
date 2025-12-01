# Script para ejecutar seeder de animales en Railway

Write-Host "=== EJECUTAR SEEDER DE ANIMALES EN RAILWAY ===" -ForegroundColor Cyan
Write-Host ""

Write-Host "OPCIÓN 1: Ejecutar desde Railway CLI" -ForegroundColor Yellow
Write-Host "railway run php artisan db:seed --class=AnimalesSeeder --force" -ForegroundColor White
Write-Host ""

Write-Host "OPCIÓN 2: Verificar animales en BD" -ForegroundColor Yellow
Write-Host "railway run php artisan tinker --execute='echo \App\Models\Animal::count();'" -ForegroundColor White
Write-Host ""

Write-Host "OPCIÓN 3: Conectar a Railway y ejecutar" -ForegroundColor Yellow
Write-Host "1. railway link (si no está linkeado)" -ForegroundColor White
Write-Host "2. railway run php artisan db:seed --class=AnimalesSeeder --force" -ForegroundColor White
Write-Host ""

Write-Host "Si no tienes Railway CLI instalado:" -ForegroundColor Red
Write-Host "npm install -g @railway/cli" -ForegroundColor White
Write-Host ""

Write-Host "=== FIN ===" -ForegroundColor Cyan

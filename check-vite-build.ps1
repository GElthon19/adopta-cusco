Write-Host "=== DIAGNÓSTICO DE DEPLOYMENT RAILWAY ===" -ForegroundColor Cyan
Write-Host ""

Write-Host "1. Verificando archivos de configuración..." -ForegroundColor Yellow
if (Test-Path "Procfile") { Write-Host "✓ Procfile existe" -ForegroundColor Green } else { Write-Host "✗ Procfile NO existe" -ForegroundColor Red }
if (Test-Path "nixpacks.toml") { Write-Host "✓ nixpacks.toml existe" -ForegroundColor Green } else { Write-Host "✗ nixpacks.toml NO existe" -ForegroundColor Red }
if (Test-Path "package.json") { Write-Host "✓ package.json existe" -ForegroundColor Green } else { Write-Host "✗ package.json NO existe" -ForegroundColor Red }
if (Test-Path "vite.config.js") { Write-Host "✓ vite.config.js existe" -ForegroundColor Green } else { Write-Host "✗ vite.config.js NO existe" -ForegroundColor Red }

Write-Host ""
Write-Host "2. Verificando que el build de Vite funciona localmente..." -ForegroundColor Yellow
npm run build

Write-Host ""
Write-Host "3. Verificando archivos generados..." -ForegroundColor Yellow
if (Test-Path "public/build/manifest.json") {
    Write-Host "✓ public/build/manifest.json existe" -ForegroundColor Green
    Write-Host "Contenido del manifest:" -ForegroundColor Cyan
    Get-Content "public/build/manifest.json" | ConvertFrom-Json | ConvertTo-Json -Depth 10
} else {
    Write-Host "✗ public/build/manifest.json NO existe" -ForegroundColor Red
}

Write-Host ""
Write-Host "4. Listando archivos en public/build/..." -ForegroundColor Yellow
if (Test-Path "public/build/") {
    Get-ChildItem "public/build/" -Recurse | Select-Object FullName, Length
} else {
    Write-Host "Directorio public/build/ no existe" -ForegroundColor Red
}

Write-Host ""
Write-Host "5. Variables de entorno necesarias en Railway:" -ForegroundColor Yellow
Write-Host "   APP_ENV=production" -ForegroundColor White
Write-Host "   APP_DEBUG=false" -ForegroundColor White
Write-Host "   ASSET_URL=https://web-production-9b482.up.railway.app" -ForegroundColor Magenta
Write-Host "   APP_URL=https://web-production-9b482.up.railway.app" -ForegroundColor Magenta

Write-Host ""
Write-Host "6. Verificando animales en base de datos local..." -ForegroundColor Yellow
php artisan tinker --execute="echo 'Total animales: ' . \App\Models\Animal::count() . PHP_EOL;"

Write-Host ""
Write-Host "=== FIN DIAGNÓSTICO ===" -ForegroundColor Cyan

# ==================================================
# DIAGNÓSTICO COMPLETO - RAILWAY NO MUESTRA CONTENIDO
# ==================================================

Write-Host "`n=== PASO 1: VERIFICAR SI RAILWAY CLI ESTÁ INSTALADO ===" -ForegroundColor Cyan
if (Get-Command railway -ErrorAction SilentlyContinue) {
    Write-Host "✓ Railway CLI instalado" -ForegroundColor Green
    
    Write-Host "`n=== PASO 2: VERIFICAR VARIABLES DE ENTORNO ===" -ForegroundColor Cyan
    Write-Host "Ejecutando: railway variables" -ForegroundColor Yellow
    railway variables
    
    Write-Host "`n=== PASO 3: VER LOGS DEL ÚLTIMO DEPLOY ===" -ForegroundColor Cyan
    Write-Host "Ejecutando: railway logs --lines 100" -ForegroundColor Yellow
    railway logs --lines 100
    
    Write-Host "`n=== PASO 4: VERIFICAR CUANTOS ANIMALES HAY ===" -ForegroundColor Cyan
    Write-Host "Ejecutando comando para contar animales..." -ForegroundColor Yellow
    railway run php artisan tinker --execute='echo App\Models\Animal::count();'
    
} else {
    Write-Host "X Railway CLI NO esta instalado" -ForegroundColor Red
    Write-Host "`nINSTALACIÓN:" -ForegroundColor Yellow
    Write-Host "npm install -g @railway/cli" -ForegroundColor White
    Write-Host "`nDESPUÉS DE INSTALAR:" -ForegroundColor Yellow
    Write-Host "railway login" -ForegroundColor White
    Write-Host "railway link (selecciona tu proyecto)" -ForegroundColor White
    Write-Host "`nY ejecuta este script nuevamente" -ForegroundColor White
}

Write-Host "`n=== SOLUCIONES RÁPIDAS ===" -ForegroundColor Cyan
Write-Host "`n1. Si NO aparece ASSET_URL en las variables:" -ForegroundColor Yellow
Write-Host "   Ve a Railway → Variables → Agregar:" -ForegroundColor White
Write-Host "   ASSET_URL=https://web-production-9b482.up.railway.app" -ForegroundColor Green

Write-Host "`n2. Si el conteo de animales es 0:" -ForegroundColor Yellow
Write-Host "   railway run php artisan db:seed --class=AnimalesSeeder --force" -ForegroundColor White

Write-Host "`n3. Limpiar caché:" -ForegroundColor Yellow
Write-Host "   railway run php artisan optimize:clear" -ForegroundColor White

Write-Host "`n4. Forzar redespliegue:" -ForegroundColor Yellow
Write-Host "   Railway → Settings → Redeploy" -ForegroundColor White

Write-Host "`n=== ALTERNATIVA SIN RAILWAY CLI ===" -ForegroundColor Cyan
Write-Host "Si no quieres instalar Railway CLI:" -ForegroundColor Yellow
Write-Host "1. Ve a https://railway.app" -ForegroundColor White
Write-Host "2. Abre tu proyecto" -ForegroundColor White
Write-Host "3. Click en 'Deployments' → Ver logs del último deploy" -ForegroundColor White
Write-Host "4. Busca 'Seeded: Database\Seeders\AnimalesSeeder'" -ForegroundColor White
Write-Host "5. Variables → Verifica que exista ASSET_URL" -ForegroundColor White

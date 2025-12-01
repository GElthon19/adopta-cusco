# INSTRUCCIONES PARA VER LOGS DE RAILWAY

Write-Host "=== VERIFICAR QUÉ ESTÁ PASANDO EN RAILWAY ===" -ForegroundColor Cyan
Write-Host ""

Write-Host "1. Ve a Railway Dashboard:" -ForegroundColor Yellow
Write-Host "   https://railway.app" -ForegroundColor White
Write-Host ""

Write-Host "2. Abre tu proyecto 'adopta-cusco'" -ForegroundColor Yellow
Write-Host ""

Write-Host "3. Click en 'Deployments' (panel izquierdo)" -ForegroundColor Yellow
Write-Host ""

Write-Host "4. Click en el deployment más reciente" -ForegroundColor Yellow
Write-Host ""

Write-Host "5. Click en 'View Logs'" -ForegroundColor Yellow
Write-Host ""

Write-Host "6. BUSCA ESTOS MENSAJES:" -ForegroundColor Yellow
Write-Host ""
Write-Host "   ✓ CORRECTO:" -ForegroundColor Green
Write-Host "   'Insertando animales en la base de datos...'" -ForegroundColor White
Write-Host "   'Seeded: Database\Seeders\AnimalesSeeder'" -ForegroundColor White
Write-Host ""
Write-Host "   ✗ ERROR:" -ForegroundColor Red
Write-Host "   'SQLSTATE[23505]' (error de duplicados)" -ForegroundColor White
Write-Host "   'Class AnimalesSeeder does not exist'" -ForegroundColor White
Write-Host "   Cualquier línea con 'ERROR' o 'FAILED'" -ForegroundColor White
Write-Host ""

Write-Host "7. COPIA Y PEGA LOS LOGS AQUÍ" -ForegroundColor Yellow
Write-Host ""

Write-Host "=== O USA RAILWAY CLI ===" -ForegroundColor Cyan
Write-Host ""
Write-Host "railway logs" -ForegroundColor White
Write-Host ""

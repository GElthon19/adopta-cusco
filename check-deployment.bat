@echo off
echo ========================================
echo 🔍 Verificando proyecto para deployment
echo ========================================
echo.

set PASSED=0
set FAILED=0

echo 📁 Verificando archivos esenciales...
if exist "Procfile" (
    echo [32m✓[0m Procfile existe
    set /a PASSED+=1
) else (
    echo [31m✗[0m Procfile NO existe
    set /a FAILED+=1
)

if exist "railway.json" (
    echo [32m✓[0m railway.json existe
    set /a PASSED+=1
) else (
    echo [31m✗[0m railway.json NO existe
    set /a FAILED+=1
)

if exist "composer.json" (
    echo [32m✓[0m composer.json existe
    set /a PASSED+=1
) else (
    echo [31m✗[0m composer.json NO existe
    set /a FAILED+=1
)

if exist ".env.example" (
    echo [32m✓[0m .env.example existe
    set /a PASSED+=1
) else (
    echo [31m✗[0m .env.example NO existe
    set /a FAILED+=1
)

if exist "artisan" (
    echo [32m✓[0m artisan existe
    set /a PASSED+=1
) else (
    echo [31m✗[0m artisan NO existe
    set /a FAILED+=1
)
echo.

echo 📦 Verificando dependencias...
if exist "vendor\autoload.php" (
    echo [32m✓[0m Autoload de Composer OK
    set /a PASSED+=1
) else (
    echo [31m✗[0m Autoload NO encontrado - ejecuta 'composer install'
    set /a FAILED+=1
)
echo.

echo 🏗️ Verificando estructura Laravel...
if exist "app" (
    echo [32m✓[0m Carpeta app/
    set /a PASSED+=1
) else (
    echo [31m✗[0m Carpeta app/ NO existe
    set /a FAILED+=1
)

if exist "config" (
    echo [32m✓[0m Carpeta config/
    set /a PASSED+=1
) else (
    echo [31m✗[0m Carpeta config/ NO existe
    set /a FAILED+=1
)

if exist "database" (
    echo [32m✓[0m Carpeta database/
    set /a PASSED+=1
) else (
    echo [31m✗[0m Carpeta database/ NO existe
    set /a FAILED+=1
)

if exist "public" (
    echo [32m✓[0m Carpeta public/
    set /a PASSED+=1
) else (
    echo [31m✗[0m Carpeta public/ NO existe
    set /a FAILED+=1
)
echo.

echo 🔧 Verificando Git...
if exist ".git" (
    echo [32m✓[0m Git está inicializado
    set /a PASSED+=1
) else (
    echo [31m✗[0m Git NO está inicializado - ejecuta 'git init'
    set /a FAILED+=1
)
echo.

echo 🔐 Verificaciones de seguridad...
findstr /C:"Juanalex4" "database\seeders\AdminUserSeeder.php" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo [31m✗[0m ¡ADVERTENCIA! Contraseña por defecto en AdminUserSeeder.php
    echo    → Cambia 'Juanalex4' por una contraseña segura
    set /a FAILED+=1
) else (
    echo [32m✓[0m Contraseña del admin modificada
    set /a PASSED+=1
)

if exist ".env" (
    echo [33m⚠[0m Archivo .env existe localmente
    echo    Asegúrate que esté en .gitignore
)
echo.

echo ========================================
echo 📊 RESUMEN
echo ========================================
echo Verificaciones exitosas: %PASSED%
echo Verificaciones fallidas: %FAILED%
echo.

if %FAILED% EQU 0 (
    echo [32m🎉 ¡Tu proyecto está listo para deployment![0m
    echo.
    echo Próximos pasos:
    echo 1. git add .
    echo 2. git commit -m "Ready for deployment"
    echo 3. git push origin main
    echo 4. Conecta con Railway.app
    echo.
    echo Lee DEPLOY-QUICK.md para instrucciones
) else (
    echo [31m⚠️  Hay problemas que resolver[0m
    echo Revisa los errores marcados con ✗
)
echo.
pause

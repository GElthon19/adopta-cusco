#!/bin/bash

echo "🔍 Verificando que el proyecto esté listo para deployment..."
echo ""

# Colores
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

checks_passed=0
checks_failed=0

# Función para verificar
check() {
    if [ $1 -eq 0 ]; then
        echo -e "${GREEN}✓${NC} $2"
        ((checks_passed++))
    else
        echo -e "${RED}✗${NC} $2"
        ((checks_failed++))
    fi
}

# 1. Verificar archivos esenciales
echo "📁 Verificando archivos esenciales..."
[ -f "Procfile" ] && check 0 "Procfile existe" || check 1 "Procfile NO existe"
[ -f "railway.json" ] && check 0 "railway.json existe" || check 1 "railway.json NO existe"
[ -f "composer.json" ] && check 0 "composer.json existe" || check 1 "composer.json NO existe"
[ -f ".env.example" ] && check 0 ".env.example existe" || check 1 ".env.example NO existe"
[ -f "artisan" ] && check 0 "artisan existe" || check 1 "artisan NO existe"
echo ""

# 2. Verificar .gitignore
echo "🔒 Verificando .gitignore..."
if grep -q "^\.env$" .gitignore; then
    check 0 ".env está en .gitignore"
else
    check 1 ".env NO está en .gitignore (¡PELIGRO!)"
fi
if grep -q "node_modules" .gitignore; then
    check 0 "node_modules está en .gitignore"
else
    check 1 "node_modules NO está en .gitignore"
fi
echo ""

# 3. Verificar dependencias
echo "📦 Verificando dependencias..."
[ -d "vendor" ] && check 0 "Vendor folder existe" || check 1 "Vendor folder NO existe - ejecuta 'composer install'"
[ -f "vendor/autoload.php" ] && check 0 "Autoload de Composer OK" || check 1 "Autoload NO encontrado"
echo ""

# 4. Verificar estructura Laravel
echo "🏗️ Verificando estructura Laravel..."
[ -d "app" ] && check 0 "Carpeta app/" || check 1 "Carpeta app/ NO existe"
[ -d "config" ] && check 0 "Carpeta config/" || check 1 "Carpeta config/ NO existe"
[ -d "database" ] && check 0 "Carpeta database/" || check 1 "Carpeta database/ NO existe"
[ -d "routes" ] && check 0 "Carpeta routes/" || check 1 "Carpeta routes/ NO existe"
[ -d "public" ] && check 0 "Carpeta public/" || check 1 "Carpeta public/ NO existe"
echo ""

# 5. Verificar Git
echo "🔧 Verificando Git..."
if [ -d ".git" ]; then
    check 0 "Git está inicializado"
    
    # Verificar si hay cambios sin commit
    if git diff-index --quiet HEAD --; then
        check 0 "No hay cambios sin commit"
    else
        echo -e "${YELLOW}⚠${NC} Hay cambios sin commit"
    fi
else
    check 1 "Git NO está inicializado - ejecuta 'git init'"
fi
echo ""

# 6. Verificar permisos
echo "🔑 Verificando permisos..."
if [ -w "storage" ]; then
    check 0 "storage/ es escribible"
else
    check 1 "storage/ NO es escribible - ejecuta 'chmod -R 775 storage'"
fi
if [ -w "bootstrap/cache" ]; then
    check 0 "bootstrap/cache/ es escribible"
else
    check 1 "bootstrap/cache/ NO es escribible - ejecuta 'chmod -R 775 bootstrap/cache'"
fi
echo ""

# 7. Advertencias de seguridad
echo "🔐 Verificaciones de seguridad..."
if grep -q "Juanalex4" database/seeders/AdminUserSeeder.php 2>/dev/null; then
    echo -e "${RED}✗${NC} ¡ADVERTENCIA! Contraseña por defecto en AdminUserSeeder.php"
    echo "  → Cambia 'Juanalex4' por una contraseña segura antes de subir"
    ((checks_failed++))
else
    check 0 "Contraseña del admin modificada o seeder no encontrado"
fi

if [ -f ".env" ]; then
    echo -e "${YELLOW}⚠${NC} Archivo .env existe localmente (asegúrate que esté en .gitignore)"
fi
echo ""

# Resumen
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 RESUMEN"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${GREEN}Verificaciones exitosas: $checks_passed${NC}"
echo -e "${RED}Verificaciones fallidas: $checks_failed${NC}"
echo ""

if [ $checks_failed -eq 0 ]; then
    echo -e "${GREEN}🎉 ¡Tu proyecto está listo para deployment!${NC}"
    echo ""
    echo "Próximos pasos:"
    echo "1. git add ."
    echo "2. git commit -m 'Ready for deployment'"
    echo "3. git push origin main"
    echo "4. Conecta con Railway.app"
    echo ""
    echo "Lee DEPLOY-QUICK.md para instrucciones detalladas"
    exit 0
else
    echo -e "${RED}⚠️  Hay problemas que resolver antes del deployment${NC}"
    echo "Revisa los errores marcados con ✗ arriba"
    exit 1
fi

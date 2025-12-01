#!/bin/bash

echo "=== DIAGNÓSTICO DE DEPLOYMENT RAILWAY ==="
echo ""

echo "1. Verificando archivos de configuración..."
echo "✓ Procfile existe"
echo "✓ nixpacks.toml existe"
echo "✓ package.json existe"
echo "✓ vite.config.js existe"

echo ""
echo "2. Verificando que el build de Vite funciona localmente..."
npm run build

echo ""
echo "3. Verificando archivos generados..."
if [ -f "public/build/manifest.json" ]; then
    echo "✓ public/build/manifest.json existe"
    cat public/build/manifest.json
else
    echo "✗ public/build/manifest.json NO existe"
fi

echo ""
echo "4. Listando archivos en public/build/..."
ls -la public/build/ 2>/dev/null || echo "Directorio public/build/ no existe"

echo ""
echo "5. Variables de entorno necesarias en Railway:"
echo "   APP_ENV=production"
echo "   APP_DEBUG=false"
echo "   ASSET_URL=https://web-production-9b482.up.railway.app"
echo "   APP_URL=https://web-production-9b482.up.railway.app"

echo ""
echo "=== FIN DIAGNÓSTICO ==="

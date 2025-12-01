# 🔧 Solución de Problemas - Assets no cargan en Railway

## ✅ VERIFICAR ESTAS VARIABLES EN RAILWAY:

1. **APP_ENV=production** (CRÍTICO)
2. **ASSET_URL=https://web-production-9b482.up.railway.app** (Opcional pero recomendado)
3. **APP_DEBUG=false** (por seguridad)

## 🚀 Pasos para Forzar Rebuild Limpio:

### Opción 1: Desde Railway Dashboard
1. Ve a tu proyecto en Railway
2. Click en el servicio web
3. Settings → Danger Zone
4. Click "**Trigger Deploy**" o "**Redeploy**"

### Opción 2: Limpiar Cache de Build
1. En Railway Dashboard → Settings
2. Busca "**Clear Build Cache**"
3. Click y espera el rebuild

### Opción 3: Variable de Entorno (Forzar Rebuild)
1. Agrega una variable temporal: `REBUILD_TRIGGER=1`
2. Espera el redeploy automático
3. Elimina la variable

## 📋 Verificar que el Build está Funcionando:

En los logs de Railway durante el build deberías ver:

```bash
#8 [build 1/4] npm run build
vite v7.2.4 building client environment for production...
✓ 55 modules transformed.
public/build/manifest.json
public/build/assets/app-XXXXXXXX.css
public/build/assets/app-XXXXXXXX.js
✓ built in X.XXs
```

Si NO ves esto, el problema es que npm run build no se está ejecutando.

## 🐛 Debugging:

### 1. Verificar que @vite encuentra el manifest:
```bash
# En local:
ls public/build/manifest.json

# Debería existir después de npm run build
```

### 2. Ver errores en Railway:
- Ve a Deployments → Latest deployment → View logs
- Busca errores relacionados con "Vite" o "manifest"

### 3. Verificar página en producción:
```
https://web-production-9b482.up.railway.app/usuario
```

Abre las herramientas de desarrollador (F12):
- Console: ¿Hay errores 404 en app.css o app.js?
- Network: ¿Los archivos /build/assets/app-XXXX.css están cargando?

## ✅ Si ves errores 404 en `/build/assets/app-XXXX.css`:

El problema es que Vite no compiló correctamente. Solución:

1. Verifica que `package.json` tenga:
```json
"scripts": {
    "build": "vite build",
    "dev": "vite"
}
```

2. Verifica que `nixpacks.toml` tenga:
```toml
[phases.build]
cmds = [
    'npm run build',
    ...
]
```

3. Fuerza un rebuild limpio en Railway

## 🎯 Configuración Correcta Actual:

✅ CSS migrados a `resources/css/` ✓
✅ JS migrados a `resources/js/` ✓
✅ Vistas usan `@vite` ✓
✅ `nixpacks.toml` tiene `npm run build` ✓
✅ `vite.config.js` configurado ✓
✅ Seeder idempotente ✓

## 📞 Si Nada Funciona:

Ejecuta manualmente el seeder en Railway CLI:

```bash
railway run php artisan db:seed --class=AnimalesSeeder --force
```

O conéctate a la base de datos y verifica:
```bash
railway run php artisan tinker
>>> \App\Models\Animal::count()
```

Debería retornar > 0 si hay animales.

# CHECKLIST COMPLETO - RAILWAY NO MUESTRA CONTENIDO

## ❌ PROBLEMAS QUE PODRÍAN ESTAR OCURRIENDO:

### 1. El seeder NO se ejecutó (base de datos vacía)
**Síntoma:** Mensaje "No hay animales registrados aún"
**Causa:** El comando `db:seed` falló silenciosamente
**Solución:** Ver logs de Railway

### 2. APP_ENV está en 'local' en lugar de 'production'
**Síntoma:** Errores de caché, rutas no encontradas
**Causa:** Variable de entorno incorrecta
**Solución:** Verificar en Railway → Variables → APP_ENV=production

### 3. Falta ejecutar `php artisan storage:link`
**Síntoma:** Imágenes no se muestran (404)
**Causa:** Symlink no creado
**Solución:** Ya está en Procfile, verificar logs

### 4. CSS no está cargando (a pesar del manifest)
**Síntoma:** Navbar sin colores, texto negro sobre blanco
**Causa:** @vite no encuentra los archivos o ASSET_URL falta
**Solución:** Agregar ASSET_URL en Railway

### 5. Bootstrap JS no carga
**Síntoma:** Dropdowns no funcionan, navbar móvil no abre
**Causa:** Script de Bootstrap no se carga
**Solución:** Verificar en DevTools → Network

---

## ✅ VERIFICACIÓN PASO A PASO:

### PASO 1: Ver logs del último deploy
```bash
railway logs
```

Busca:
- ✓ "Insertando animales en la base de datos..."
- ✓ "Seeded: Database\Seeders\AnimalesSeeder"
- ✗ Cualquier ERROR

---

### PASO 2: Verificar variables de entorno en Railway

Ve a Railway → Tu proyecto → Variables → Verifica:

```
APP_ENV=production          ← DEBE SER production
APP_DEBUG=false             ← DEBE SER false
APP_URL=https://web-production-9b482.up.railway.app
ASSET_URL=https://web-production-9b482.up.railway.app  ← IMPORTANTE
DATABASE_URL=(tu conexión PostgreSQL)
APP_KEY=(debe existir)
```

---

### PASO 3: Verificar en el navegador

1. Abre: https://web-production-9b482.up.railway.app/usuario
2. Presiona F12 (DevTools)
3. Ve a "Console"

**¿Qué ves?**

✓ CORRECTO: Sin errores, solo mensajes normales
✗ INCORRECTO:
- "Failed to load resource: 404" (para app-XXXX.css o app-XXXX.js)
- "Uncaught ReferenceError"
- Cualquier error en rojo

4. Ve a "Network"
5. Refresca (Ctrl+R)
6. Busca archivos que empiecen con "app-"

**¿Qué ves?**

✓ CORRECTO:
- app-XXXXXXXX.css | 200 | 56.7 KB
- app-XXXXXXXX.js  | 200 | 42.0 KB

✗ INCORRECTO:
- app-XXXXXXXX.css | 404
- app-XXXXXXXX.js  | 404

---

### PASO 4: Ejecutar comandos manualmente en Railway

Si los pasos anteriores no ayudan:

```bash
# Ver cuántos animales hay
railway run php artisan tinker --execute="echo \App\Models\Animal::count();"

# Si devuelve 0, ejecutar seeder manualmente
railway run php artisan db:seed --class=AnimalesSeeder

# Limpiar caché
railway run php artisan cache:clear
railway run php artisan config:clear
railway run php artisan view:clear
```

---

## 🎯 SOLUCIONES RÁPIDAS:

### Si NO hay animales:
```bash
railway run php artisan db:seed --class=AnimalesSeeder
```

### Si NO hay estilos:
Agregar en Railway → Variables:
```
ASSET_URL=https://web-production-9b482.up.railway.app
```

### Si nada funciona:
1. Railway → Settings → "Redeploy"
2. Esperar 5 minutos
3. Recargar página con Ctrl+Shift+R (borrar caché del navegador)

---

## 📞 INFORMACIÓN QUE NECESITO:

Para ayudarte mejor, necesito saber:

1. **¿Qué ves en la consola del navegador? (F12 → Console)**
   - Copia cualquier error en rojo

2. **¿Qué ves en Network? (F12 → Network → busca app-)**
   - ¿Los archivos CSS/JS dan 200 o 404?

3. **¿Ejecutaste el comando de logs?**
   ```bash
   railway logs
   ```
   - Copia las últimas 50 líneas

4. **¿Verificaste las variables de entorno?**
   - ¿Existe ASSET_URL?
   - ¿APP_ENV=production?

Con esta información podré darte la solución exacta.

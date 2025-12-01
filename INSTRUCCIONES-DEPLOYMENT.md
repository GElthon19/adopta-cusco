# ✅ CHECKLIST PRE-DEPLOYMENT

## 🎯 Tu proyecto está 100% LISTO para subir a producción

### ✅ Archivos creados para deployment:

- ✅ `Procfile` - Configura cómo Railway ejecuta tu app
- ✅ `railway.json` - Configuración de Railway
- ✅ `nixpacks.toml` - Configuración de build
- ✅ `.env.example` - Variables de entorno documentadas
- ✅ `deploy.sh` / `deploy.bat` - Scripts de deployment
- ✅ `TrustProxies.php` - Middleware para HTTPS
- ✅ `cors.php` - Configuración CORS
- ✅ `DEPLOYMENT.md` - Guía completa detallada
- ✅ `DEPLOY-QUICK.md` - Guía rápida
- ✅ `README.md` - Documentación actualizada
- ✅ `check-deployment.bat/.sh` - Script de verificación

---

## ⚠️ ACCIONES REQUERIDAS ANTES DE SUBIR:

### 1. 🔒 CAMBIAR CONTRASEÑA DEL ADMIN

**IMPORTANTE:** La contraseña actual es visible en el código.

**Archivo:** `database/seeders/AdminUserSeeder.php`

**Línea 17:** Cambia `'Juanalex4'` por una contraseña segura

```php
// ANTES:
'password' => Hash::make('Juanalex4'),

// DESPUÉS:
'password' => Hash::make('TuContraseñaSegura123!'),
```

### 2. 📝 Verificar configuración

Ejecuta el script de verificación:

```bash
# Windows:
.\check-deployment.bat

# Linux/Mac:
chmod +x check-deployment.sh
./check-deployment.sh
```

---

## 🚀 PASOS PARA SUBIR A RAILWAY (15 minutos)

### Paso 1: Preparar Git

```bash
# Si no has iniciado Git:
git init
git add .
git commit -m "Ready for deployment"
```

### Paso 2: Subir a GitHub

1. Crea un repositorio en GitHub: https://github.com/new
   - Nombre: `adopta-cusco`
   - Privado o público (tu elección)
   - NO inicialices con README

2. Sube tu código:
   ```bash
   git remote add origin https://github.com/TU_USUARIO/adopta-cusco.git
   git branch -M main
   git push -u origin main
   ```

### Paso 3: Crear cuenta en Railway

1. Ve a: https://railway.app
2. Click en "Login"
3. Elige "Login with GitHub"
4. Autoriza Railway
5. ✅ Recibirás $5 de crédito gratis (suficiente para 3-4 semanas)

### Paso 4: Deploy tu proyecto

1. En Railway, click "New Project"
2. Selecciona "Deploy from GitHub repo"
3. Busca y selecciona `adopta-cusco`
4. Railway detectará automáticamente que es Laravel
5. Espera 2-3 minutos mientras se construye

### Paso 5: Agregar base de datos

1. En tu proyecto Railway, click "+ New"
2. Selecciona "Database"
3. Click en "Add PostgreSQL"
4. Railway automáticamente conectará la base de datos

### Paso 6: Configurar variables de entorno

1. Click en tu servicio web (no la database)
2. Ve a la pestaña "Variables"
3. Agrega estas variables:

```env
APP_NAME=Adopta Cusco
APP_ENV=production
APP_DEBUG=false
```

4. Genera APP_KEY:
   - En tu terminal local ejecuta:
     ```bash
     php artisan key:generate --show
     ```
   - Copia el resultado (será algo como `base64:xxxxx...`)
   - Agrégalo como variable `APP_KEY` en Railway

5. Agrega la URL de tu app (la obtendrás después):
   ```env
   APP_URL=https://tu-app.up.railway.app
   ```

### Paso 7: Obtener tu URL pública

1. En Railway, ve a tu servicio
2. Click en "Settings"
3. En "Networking" → "Public Networking"
4. Click "Generate Domain"
5. Copia tu URL (será algo como: `tu-proyecto-production.up.railway.app`)
6. Actualiza la variable `APP_URL` con esta URL

### Paso 8: Verificar deployment

1. Ve a la pestaña "Deployments"
2. Verás el progreso del deployment
3. Espera a que diga "Success" ✅
4. Las migraciones se ejecutarán automáticamente

### Paso 9: Crear usuario administrador

Railway ejecutará el seeder automáticamente, PERO si necesitas hacerlo manualmente:

**Opción A: Desde Railway CLI**
```bash
# Instala Railway CLI
npm i -g @railway/cli

# Login
railway login

# Link al proyecto
railway link

# Ejecuta el seeder
railway run php artisan db:seed --class=AdminUserSeeder --force
```

**Opción B: Desde la interfaz web**
- Accede a tu app y regístrate manualmente
- Luego actualiza el rol en la base de datos

### Paso 10: ¡Listo! 🎉

Tu app estará disponible en: `https://tu-proyecto-production.up.railway.app`

**Credenciales de acceso:**
- Email: `alexcutipajara@gmail.com`
- Contraseña: La que configuraste en el paso 1

---

## 🎯 HOSTINGS GRATUITOS RECOMENDADOS

### 🥇 Railway.app (RECOMENDADO)
- ✅ **Gratis:** $5 crédito = ~500 horas/mes
- ✅ **Base de datos:** PostgreSQL incluida
- ✅ **Ventaja:** MÁS FÁCIL para Laravel
- ✅ **HTTPS:** Automático
- ⏱️ **Duración:** 20+ días activo 24/7

👉 **USA ESTA OPCIÓN**

### 🥈 Render.com
- ✅ Gratis: 750 horas/mes
- ⚠️ Se "duerme" tras 15 min inactivo
- ✅ PostgreSQL gratis
- Ver `DEPLOYMENT.md` para instrucciones

### 🥉 InfinityFree
- ✅ Hosting PHP tradicional
- ⚠️ Más complicado configurar
- ✅ Sin límite de tiempo
- Ver `DEPLOYMENT.md` para instrucciones

---

## 📊 Monitoreo en Railway

### Ver logs en tiempo real:
1. Click en tu servicio
2. Ve a "Deployments"
3. Click en el deployment activo
4. Verás los logs en tiempo real

### Ver métricas:
1. Click en tu servicio
2. Ve a "Metrics"
3. Verás CPU, RAM, Network

### Costos:
1. Click en tu proyecto
2. Ve a "Usage"
3. Verás el uso de tu crédito gratis

---

## 🔧 Troubleshooting

### Error: "No application encryption key"
```bash
# Genera la clave
php artisan key:generate --show

# Agrégala en Railway → Variables → APP_KEY
```

### Error 500 en Railway
1. Ve a Deployments → Logs
2. Busca el error específico
3. Verifica que `APP_KEY` esté configurada
4. Verifica que `APP_DEBUG=false`

### Migraciones no se ejecutan
- Railway las ejecuta automáticamente en `Procfile`
- Verifica en los logs si hubo errores

### Base de datos no conecta
- Railway configura automáticamente las variables
- Verifica que PostgreSQL esté agregado al proyecto
- Las variables PGHOST, PGPORT, etc. deben estar presentes

---

## 📞 Recursos

- **Guía rápida:** `DEPLOY-QUICK.md`
- **Guía completa:** `DEPLOYMENT.md`
- **Verificación:** `check-deployment.bat` / `.sh`
- **Railway Docs:** https://docs.railway.app
- **Laravel Docs:** https://laravel.com/docs

---

## 🎉 ¡FELICIDADES!

Tu proyecto está profesionalmente preparado para producción con:

- ✅ Configuración automática de deployment
- ✅ Scripts de optimización
- ✅ Documentación completa
- ✅ Verificación de seguridad
- ✅ Soporte multi-plataforma
- ✅ Guías paso a paso

**Tiempo estimado total: 15-20 minutos** ⏱️

---

**Última actualización:** 30 de Noviembre, 2025

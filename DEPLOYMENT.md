# 🚀 Guía de Deployment - Adopta Cusco

Esta guía te ayudará a subir tu aplicación Laravel a un hosting gratuito para uso temporal (3 semanas - 1 mes).

---

## 📋 Opciones de Hosting Gratuito Recomendadas

### 🥇 Opción 1: Railway.app (RECOMENDADO)
**✅ Ventajas:**
- Muy fácil de usar
- Base de datos PostgreSQL incluida gratis
- Deploy automático desde GitHub
- SSL gratis
- Ideal para Laravel

**⏱️ Límites:**
- 500 horas/mes gratis (suficiente para 3-4 semanas activo 24/7)
- $5 de crédito gratis al registrarte

### 🥈 Opción 2: Render.com
**✅ Ventajas:**
- Base de datos PostgreSQL gratis
- SSL automático
- Deploy desde GitHub

**⏱️ Límites:**
- La app se "duerme" después de 15 min de inactividad
- 750 horas/mes gratis

### 🥉 Opción 3: InfinityFree (Hosting tradicional)
**✅ Ventajas:**
- Hosting PHP tradicional
- MySQL gratis
- Sin límite de tiempo

**⚠️ Desventajas:**
- Más limitado en recursos
- Requiere configuración manual

---

## 🎯 DEPLOYMENT EN RAILWAY (Recomendado)

### Paso 1: Preparar tu proyecto

Tu proyecto YA ESTÁ LISTO con todos los archivos necesarios:
- ✅ `Procfile` - Configuración de inicio
- ✅ `railway.json` - Configuración de Railway
- ✅ `nixpacks.toml` - Build configuration
- ✅ `.env.example` - Variables de entorno documentadas

### Paso 2: Crear cuenta en Railway

1. Ve a https://railway.app
2. Haz clic en **"Start a New Project"**
3. Inicia sesión con GitHub (te dará $5 de crédito gratis)

### Paso 3: Subir tu código a GitHub

```bash
# Si aún no has inicializado Git:
git init
git add .
git commit -m "Preparar proyecto para deployment"

# Crea un repositorio en GitHub y luego:
git remote add origin https://github.com/TU_USUARIO/adopta-cusco.git
git branch -M main
git push -u origin main
```

### Paso 4: Crear proyecto en Railway

1. En Railway, haz clic en **"New Project"**
2. Selecciona **"Deploy from GitHub repo"**
3. Conecta tu cuenta de GitHub
4. Selecciona el repositorio `adopta-cusco`
5. Railway detectará automáticamente que es Laravel

### Paso 5: Agregar base de datos PostgreSQL

1. En tu proyecto Railway, haz clic en **"+ New"**
2. Selecciona **"Database"** → **"Add PostgreSQL"**
3. Railway automáticamente creará las variables de entorno

### Paso 6: Configurar variables de entorno

En Railway, ve a tu servicio → **Variables** y agrega:

```env
APP_NAME=Adopta Cusco
APP_ENV=production
APP_KEY=  # Esto lo generarás después
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app

# Railway automáticamente provee estas variables de la BD:
# PGHOST, PGPORT, PGDATABASE, PGUSER, PGPASSWORD

# Agrega manualmente:
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
```

### Paso 7: Generar APP_KEY

1. En Railway, ve a tu servicio
2. Haz clic en **"Settings"** → **"Variables"**
3. Ejecuta en tu terminal local:
   ```bash
   php artisan key:generate --show
   ```
4. Copia la clave generada y agrégala como `APP_KEY` en Railway

### Paso 8: Deploy automático

1. Railway automáticamente deployará tu app
2. Espera 2-3 minutos
3. Verás el progreso en la pestaña **"Deployments"**
4. Una vez completado, obtendrás una URL pública

### Paso 9: Ejecutar migraciones

En Railway, ve a tu servicio → **Settings** → **Deploy** y las migraciones se ejecutarán automáticamente gracias al `Procfile`.

Si necesitas ejecutar manualmente:
1. Ve a tu servicio en Railway
2. Haz clic en **"Settings"** → **"Variables"**
3. En **"Custom Start Command"** ejecuta:
   ```bash
   php artisan migrate --force
   ```

### Paso 10: Crear usuario administrador

Para ejecutar el seeder y crear tu usuario admin:

1. En Railway, puedes usar el **"Terminal"** del servicio
2. O ejecutar desde tu local conectándote a la base de datos de Railway
3. Ejecuta:
   ```bash
   php artisan db:seed --class=AdminUserSeeder --force
   ```

**O crea manualmente el usuario desde la interfaz web una vez que la app esté corriendo.**

---

## 🎯 DEPLOYMENT EN RENDER.COM

### Paso 1: Crear cuenta
1. Ve a https://render.com
2. Regístrate con GitHub

### Paso 2: Crear Web Service
1. Haz clic en **"New +"** → **"Web Service"**
2. Conecta tu repositorio GitHub
3. Configuración:
   - **Name**: adopta-cusco
   - **Environment**: Docker o Native
   - **Build Command**: `composer install --no-dev && php artisan config:cache`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Paso 3: Agregar PostgreSQL
1. En el dashboard, **"New +"** → **"PostgreSQL"**
2. Conecta la base de datos a tu web service

### Paso 4: Variables de entorno
Agrega las mismas variables que en Railway.

---

## 🎯 DEPLOYMENT EN HOSTING TRADICIONAL (InfinityFree)

### Paso 1: Crear cuenta
1. Ve a https://infinityfree.com
2. Crea una cuenta gratis

### Paso 2: Preparar archivos

1. Comprime tu proyecto:
   ```bash
   # Excluye node_modules y otros archivos innecesarios
   ```

2. **Importante**: En hosting tradicional necesitas:
   - Subir todos los archivos EXCEPTO la carpeta `public` al root
   - Los archivos de `public` van en `htdocs` o `public_html`

### Paso 3: Crear base de datos MySQL
1. En el panel de InfinityFree, crea una base de datos MySQL
2. Anota: nombre, usuario, contraseña, host

### Paso 4: Configurar .env
Crea un archivo `.env` con:
```env
APP_NAME="Adopta Cusco"
APP_ENV=production
APP_KEY=base64:TU_KEY_GENERADA
APP_DEBUG=false
APP_URL=http://tu-sitio.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sql123.infinityfreeapp.com
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### Paso 5: Subir archivos por FTP
1. Usa FileZilla o el File Manager del panel
2. Sube todos los archivos

### Paso 6: Ejecutar migraciones
Necesitarás acceso a terminal SSH (no disponible en plan gratis) o crear un script temporal:

Crea `install.php` en public:
```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->call('migrate', ['--force' => true]);
echo "Migraciones ejecutadas!";
// BORRAR ESTE ARCHIVO DESPUÉS
```

Visita `http://tu-sitio.infinityfreeapp.com/install.php` y luego borra el archivo.

---

## 🔧 Configuraciones Adicionales de Producción

### Optimización de permisos (hosting tradicional)
```bash
chmod -R 755 storage bootstrap/cache
```

### Caché de configuración
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📊 Comparación Rápida

| Característica | Railway | Render | InfinityFree |
|---------------|---------|--------|--------------|
| **Facilidad** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| **Laravel** | ✅ Excelente | ✅ Bueno | ⚠️ Limitado |
| **Base de datos** | PostgreSQL gratis | PostgreSQL gratis | MySQL gratis |
| **SSL/HTTPS** | ✅ Automático | ✅ Automático | ⚠️ Limitado |
| **Tiempo activo** | 500h/mes | 750h/mes | Ilimitado |
| **Performance** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |

---

## 🎯 RECOMENDACIÓN FINAL

Para tu proyecto temporal de 3 semanas - 1 mes:

### ✅ USA RAILWAY.APP

**Razones:**
1. Más fácil para Laravel
2. 500 horas = ~20 días activo 24/7 (suficiente para 3-4 semanas)
3. Deploy automático desde GitHub
4. Base de datos incluida
5. HTTPS automático
6. Mejor rendimiento

**Costo:** $0 (con el crédito gratis de $5 te durará tu tiempo necesario)

---

## 📞 Soporte

Si tienes problemas:
1. Revisa los logs en Railway/Render
2. Verifica las variables de entorno
3. Asegúrate que `APP_KEY` esté configurada
4. Revisa que las migraciones se hayan ejecutado

---

## ⚠️ IMPORTANTE - Antes de subir

### Seguridad:
1. **CAMBIA** la contraseña del admin en `AdminUserSeeder.php`
2. **NO SUBAS** el seeder a producción con contraseña visible
3. Asegúrate que `APP_DEBUG=false` en producción
4. Revisa que `.env` no esté en Git (debe estar en `.gitignore`)

### Checklist final:
- [ ] Código subido a GitHub
- [ ] Variables de entorno configuradas
- [ ] APP_KEY generada
- [ ] Base de datos conectada
- [ ] Migraciones ejecutadas
- [ ] Usuario admin creado
- [ ] SSL/HTTPS funcionando
- [ ] Archivos de storage accesibles

---

¡Tu aplicación está lista para deployment! 🎉

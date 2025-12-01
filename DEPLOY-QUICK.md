# 🎯 GUÍA RÁPIDA DE DEPLOYMENT

## ✅ Archivos Listos para Deployment:

Tu proyecto ya tiene TODO lo necesario:

- ✅ `Procfile` - Para Railway/Render
- ✅ `railway.json` - Configuración Railway
- ✅ `nixpacks.toml` - Build config
- ✅ `.env.example` - Variables de entorno
- ✅ `deploy.sh` / `deploy.bat` - Scripts de deployment
- ✅ `DEPLOYMENT.md` - Guía completa

## 🚀 OPCIÓN RECOMENDADA: Railway.app

### Por qué Railway:
- ⭐ MÁS FÁCIL para Laravel
- 🆓 Gratis con $5 de crédito inicial
- ⏱️ 500 horas gratis/mes (≈ 20 días 24/7)
- 🗄️ PostgreSQL incluido gratis
- 🔒 HTTPS automático
- 🚀 Deploy automático desde GitHub

### Pasos Rápidos:

1. **Subir a GitHub:**
   ```bash
   git init
   git add .
   git commit -m "Deploy ready"
   git remote add origin https://github.com/TU_USUARIO/adopta-cusco.git
   git push -u origin main
   ```

2. **Crear cuenta en Railway:**
   - Ve a https://railway.app
   - Inicia sesión con GitHub
   - Recibirás $5 de crédito gratis

3. **Deploy:**
   - New Project → Deploy from GitHub
   - Selecciona `adopta-cusco`
   - Railway lo detectará automáticamente

4. **Agregar base de datos:**
   - Click en "+ New" → Database → PostgreSQL
   - Se conectará automáticamente

5. **Configurar variables:**
   - Ve a Variables
   - Ejecuta localmente: `php artisan key:generate --show`
   - Agrega la clave como `APP_KEY`

6. **¡LISTO!** Tu app estará en: `https://tu-app.up.railway.app`

## ⚠️ IMPORTANTE - Seguridad:

### Antes de subir a GitHub:

1. **Cambia la contraseña del admin:**
   - Edita `database/seeders/AdminUserSeeder.php`
   - Cambia `'Juanalex4'` por una contraseña segura

2. **Verifica .gitignore:**
   - Asegúrate que `.env` NO se suba
   - Solo `.env.example` debe estar en Git

### Variables de entorno en Railway:

```env
APP_NAME=Adopta Cusco
APP_ENV=production
APP_KEY=base64:TU_KEY_AQUI
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app

# Railway provee automáticamente:
# PGHOST, PGPORT, PGDATABASE, PGUSER, PGPASSWORD

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
```

## 📊 Otras Opciones:

### Render.com
- Similar a Railway
- 750 horas/mes gratis
- La app se duerme tras 15 min sin uso

### InfinityFree (Hosting tradicional)
- Hosting PHP clásico
- Más complicado de configurar
- Sin límite de tiempo

Ver **DEPLOYMENT.md** para guías detalladas de cada opción.

## 🆘 Troubleshooting:

### Error: "Could not open input file: artisan"
✅ Ya resuelto - archivo `artisan` creado

### Error: "No application encryption key"
```bash
php artisan key:generate --show
# Agrega el resultado a APP_KEY en Railway
```

### Migraciones no se ejecutan
- Railway las ejecuta automáticamente
- Si falla, ve a Settings → Deploy y verifica logs

### Error 500
- Verifica que `APP_KEY` esté configurada
- Revisa que `APP_DEBUG=false`
- Checa los logs en Railway

## 📖 Documentación Completa:

Lee `DEPLOYMENT.md` para:
- Guías paso a paso detalladas
- Comparación de hostings
- Configuración avanzada
- Troubleshooting completo

---

**¡Tu proyecto está 100% listo para deployment!** 🎉

Solo necesitas:
1. Cambiar contraseña del admin
2. Subir a GitHub
3. Conectar con Railway
4. ¡Disfrutar!

Tiempo estimado: **15-20 minutos** ⏱️

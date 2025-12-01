# 🔐 Configuración de Google OAuth para Adopta Cusco

## Error Actual
```
Error 401: invalid_client
The OAuth client was not found.
```

**Causa**: Las credenciales de Google OAuth en `.env` son placeholders y no son válidas.

---

## 📋 Pasos para Configurar Google OAuth

### 1️⃣ Crear Proyecto en Google Cloud Console

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Inicia sesión con tu cuenta de Google
3. Clic en "Seleccionar un proyecto" → "Nuevo proyecto"
4. Nombre del proyecto: `Adopta Cusco`
5. Clic en "Crear"

### 2️⃣ Habilitar Google+ API

1. En el menú lateral, ve a: **APIs y servicios** → **Biblioteca**
2. Busca: `Google+ API`
3. Clic en `Google+ API`
4. Clic en **"HABILITAR"**

### 3️⃣ Configurar Pantalla de Consentimiento OAuth

1. Ve a: **APIs y servicios** → **Pantalla de consentimiento de OAuth**
2. Selecciona **"Externo"** (para usuarios de cualquier cuenta de Google)
3. Clic en **"Crear"**

4. **Información de la aplicación**:
   - Nombre de la aplicación: `Adopta Cusco`
   - Correo electrónico de asistencia: `alexcutipajara@gmail.com`
   - Logo de la aplicación: (opcional - puedes subirlo después)

5. **Información de contacto del desarrollador**:
   - Correo electrónico: `alexcutipajara@gmail.com`

6. Clic en **"GUARDAR Y CONTINUAR"**

7. **Permisos** (Scopes):
   - Clic en **"AGREGAR O QUITAR PERMISOS"**
   - Selecciona estos permisos:
     - `.../auth/userinfo.email` (Ver tu dirección de correo)
     - `.../auth/userinfo.profile` (Ver tu información personal)
   - Clic en **"ACTUALIZAR"**
   - Clic en **"GUARDAR Y CONTINUAR"**

8. **Usuarios de prueba** (IMPORTANTE):
   - Clic en **"+ AGREGAR USUARIOS"**
   - Agrega estos correos:
     ```
     alexcutipajara@gmail.com
     ```
   - Agrega cualquier otro correo que quieras probar
   - Clic en **"AGREGAR"**
   - Clic en **"GUARDAR Y CONTINUAR"**

9. **Resumen**:
   - Revisa la información
   - Clic en **"VOLVER AL PANEL"**

### 4️⃣ Crear Credenciales OAuth 2.0

1. Ve a: **APIs y servicios** → **Credenciales**
2. Clic en **"+ CREAR CREDENCIALES"** → **"ID de cliente de OAuth"**

3. **Configuración**:
   - Tipo de aplicación: **"Aplicación web"**
   - Nombre: `Adopta Cusco Web Client`

4. **Orígenes autorizados de JavaScript**:
   - Clic en **"+ AGREGAR URI"**
   - Agrega: `http://localhost:8000`
   - Clic en **"+ AGREGAR URI"**
   - Agrega: `http://127.0.0.1:8000`

5. **URIs de redirección autorizados**:
   - Clic en **"+ AGREGAR URI"**
   - Agrega: `http://localhost:8000/auth/google/callback`
   - Clic en **"+ AGREGAR URI"**
   - Agrega: `http://127.0.0.1:8000/auth/google/callback`

6. Clic en **"CREAR"**

7. **¡IMPORTANTE!** Se abrirá un popup con tus credenciales:
   ```
   ID de cliente: algo-como-esto.apps.googleusercontent.com
   Secreto del cliente: GOCSPX-algo_secreto_aqui
   ```
   
   ⚠️ **COPIA ESTAS CREDENCIALES INMEDIATAMENTE** ⚠️

### 5️⃣ Configurar el archivo .env

Abre el archivo `.env` y reemplaza estas líneas:

```env
GOOGLE_CLIENT_ID=tu_client_id_de_google
GOOGLE_CLIENT_SECRET=tu_client_secret_de_google
GOOGLE_REDIRECT_URI=http://tu-dominio.com/auth/google/callback
```

Por tus credenciales reales:

```env
GOOGLE_CLIENT_ID=TU_CLIENT_ID_AQUI.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-TU_CLIENT_SECRET_AQUI
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 6️⃣ Limpiar Cache de Laravel

Ejecuta estos comandos en la terminal:

```powershell
php artisan config:clear
php artisan cache:clear
```

### 7️⃣ Probar el Login con Google

1. Asegúrate que el servidor esté corriendo:
   ```powershell
   php artisan serve
   ```

2. Ve a: http://localhost:8000/login

3. Clic en el botón **"Iniciar sesión con Google"**

4. Selecciona tu cuenta de Google (debe estar en la lista de usuarios de prueba)

5. Acepta los permisos solicitados

6. Deberías ser redirigido a la página principal como usuario regular

---

## ⚠️ Notas Importantes

### Usuarios de Prueba
- **Solo** los correos agregados en "Usuarios de prueba" podrán iniciar sesión
- Si intentas con un correo no autorizado, verás un error
- Para agregar más usuarios: Google Cloud Console → OAuth consent screen → Test users → Add users

### Roles de Usuario
- **Usuarios con Google**: Siempre se crean como `role = 'user'` (NO admin)
- **Admin**: Solo se puede crear mediante:
  - Seeder: `php artisan db:seed --class=AdminUserSeeder`
  - Login manual con email/contraseña: `alexcutipajara@gmail.com` / `Juanalex4`

### URIs de Producción
Cuando subas la app a producción, debes:
1. Agregar el dominio real en Google Cloud Console:
   - Orígenes autorizados: `https://tudominio.com`
   - URI de redirección: `https://tudominio.com/auth/google/callback`
2. Actualizar `.env` con la nueva `GOOGLE_REDIRECT_URI`

### Verificación de la App
- Mientras esté en modo "Prueba", solo usuarios autorizados pueden acceder
- Para que cualquier usuario pueda entrar, debes **verificar la app** en Google
- La verificación requiere enviar la app para revisión (proceso de varios días)

---

## 🐛 Solución de Problemas

### Error: "invalid_client"
✅ **Solución**: Verifica que copiaste correctamente el `GOOGLE_CLIENT_ID` y `GOOGLE_CLIENT_SECRET` en `.env`

### Error: "redirect_uri_mismatch"
✅ **Solución**: Verifica que la URI en Google Cloud Console coincida exactamente con la de `.env`

### Error: "Access blocked: This app's request is invalid"
✅ **Solución**: Agrega tu correo en "Usuarios de prueba" en Google Cloud Console

### No aparece el botón de Google
✅ **Solución**: 
```powershell
composer require laravel/socialite
php artisan config:clear
```

---

## 📞 Contacto

Si tienes problemas con la configuración:
- Email: alexcutipajara@gmail.com
- Revisa la documentación oficial: [Laravel Socialite](https://laravel.com/docs/socialite)

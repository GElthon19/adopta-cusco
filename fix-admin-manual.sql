-- Script SQL para verificar y actualizar el rol del usuario admin
-- Ejecutar esto en Railway Shell o psql

-- Ver todos los usuarios y sus roles
SELECT id, name, email, role, email_verified_at FROM users;

-- Actualizar el rol a admin para alexcutipajara@gmail.com
UPDATE users SET role = 'admin' WHERE email = 'alexcutipajara@gmail.com';

-- Verificar el cambio
SELECT id, name, email, role FROM users WHERE email = 'alexcutipajara@gmail.com';

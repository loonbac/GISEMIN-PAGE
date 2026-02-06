# Base de Datos - GISEMIN

## Configuración

**Archivo:** `.env`

```env
DB_CONNECTION=mysql
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Tablas Principales

### 1. users
Almacena usuarios administradores.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | ID único |
| name | VARCHAR(255) | Nombre completo |
| email | VARCHAR(255) | Email (login) |
| password | VARCHAR(255) | Contraseña hasheada |
| created_at | TIMESTAMP | Fecha creación |
| updated_at | TIMESTAMP | Fecha actualización |

### 2. sessions
Almacena sesiones activas.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | VARCHAR(255) | ID sesión |
| user_id | BIGINT | ID usuario |
| payload | LONGTEXT | Datos sesión |
| last_activity | INTEGER | Última actividad |

### 3. password_reset_tokens
Tokens para recuperar contraseña.

| Campo | Tipo |
|-------|------|
| email | VARCHAR(255) |
| token | VARCHAR(255) |
| created_at | TIMESTAMP |

### 4. cache / cache_locks
Almacenamiento de caché.

### 5. jobs / failed_jobs / job_batches
Cola de trabajos asíncronos.

## Relaciones

- `sessions.user_id` → `users.id` (One-to-Many)
- `password_reset_tokens.email` → `users.email` (One-to-One)

## Usuarios y Contraseñas

### Usuario de Prueba
```
Email: admin@gisemin.com
Contraseña: admin123
```

### Crear Nuevo Usuario

**Via Tinker:**
```bash
php artisan tinker
```

```php
User::create([
    'name' => 'Nombre Usuario',
    'email' => 'email@ejemplo.com',
    'password' => Hash::make('contraseña'),
    'email_verified_at' => now(),
]);
```

## Roles

**Sistema actual:** Sin roles complejos
- Todos los usuarios autenticados = acceso completo
- Middleware: `SimpleAuthMiddleware` verifica solo sesión activa

## Comandos Útiles

```bash
# Migraciones
php artisan migrate
php artisan migrate:fresh --seed

# Tinker
php artisan tinker
User::all();
User::find(1);

# Backup
mysqldump -u root laravel > backup.sql
mysql -u root laravel < backup.sql
```

## Configuración Sesiones

- **Driver:** database (tabla `sessions`)
- **Lifetime:** 120 minutos
- **Expire on close:** true (cierra al cerrar navegador)

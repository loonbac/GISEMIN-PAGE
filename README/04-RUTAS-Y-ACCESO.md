# GISEMIN - Guía de Rutas y Acceso

## 📁 Estructura del Proyecto

El proyecto ahora está claramente separado en dos secciones:

### 🌐 Público (Visitantes)
- **Landing Page**: `/` 
- **Verificar Certificados**: `/certificados`

### 🔐 Administración (Solo administradores)
- **Login Admin**: `/admin/login`
- **Panel de Certificados**: `/admin/certificados/agregar` (requiere autenticación)
- **Dashboard**: `/admin/dashboard` (requiere autenticación)

## 🚀 Acceso Local

### Para visitantes (público):
```
http://localhost:3000/
http://localhost:3000/certificados
```

### Para administradores:
```
http://localhost:3000/admin/login
```

**Credenciales por defecto** (configurar en la base de datos):
- Email: `admin@gisemin.com`
- Contraseña: (definir en seeder)

## 🌍 Acceso via Tailscale

Reemplaza `localhost` con tu IP de Tailscale (por ejemplo: `100.83.130.19`):

```
http://100.83.130.19:3000/
http://100.83.130.19:3000/admin/login
```

## 📂 Organización de Vistas

```
resources/views/
├── layouts/
│   ├── public.blade.php    # Layout para páginas públicas
│   └── admin.blade.php     # Layout para panel admin
├── public/
│   └── certificados.blade.php  # Verificación pública de certificados
├── admin/
│   ├── login.blade.php     # Login del panel admin
│   └── certificados/
│       └── agregar.blade.php   # Agregar certificados (admin)
└── landing.blade.php       # Página principal
```

## 🎨 CSS Organizado

```
resources/css/
├── landing.css         # Estilos de landing page
├── certificados.css    # Estilos de verificación de certificados
├── login.css           # (legacy - puede eliminarse)
└── admin/
    ├── login.css       # Estilos del login admin
    └── admin.css       # Estilos del panel admin
```

## 🔒 Seguridad

- Las rutas `/admin/*` están protegidas por middleware de autenticación
- El acceso no autorizado redirige a `/admin/login`
- La sesión se almacena en el servidor (session-based auth)

## 🛠️ Desarrollo

**Iniciar servidores:**
```bash
# Terminal 1 - Laravel
php artisan serve --host=0.0.0.0 --port=3000

# Terminal 2 - Vite (assets)
npm run dev
```

**URL completa de desarrollo:**
- Pública: http://localhost:3000/
- Admin: http://localhost:3000/admin/login

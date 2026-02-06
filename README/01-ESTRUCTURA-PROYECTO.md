# Estructura del Proyecto GISEMIN

## Tecnología
- **Backend:** Laravel 12 + PHP 8.2
- **Frontend:** Blade + Vite 7.3.1 + Tailwind CSS 4
- **Base de datos:** MySQL (laravel)

## Ubicación del Frontend

### Vistas (HTML)
**Carpeta:** `resources/views/`

- `landing.blade.php` - Página principal `/`
- `login.blade.php` - Login `/login`
- `certificados.blade.php` - Búsqueda certificados `/certificados` (privada)
- `dashboard.blade.php` - Dashboard `/dashboard` (privada)

### Estilos (CSS)
**Carpeta:** `resources/css/`

- `app.css` - Estilos globales
- `landing.css` - Landing page
- `login.css` - Login
- `certificados.css` - Certificados

### JavaScript
**Carpeta:** `resources/js/`

- `app.js` - Principal
- `landing.js` - Funcionalidad landing
- `certificados.js` - Funcionalidad certificados

### Imágenes
**Carpeta:** `public/images/`

- `logo.svg` - Logo empresa
- `consultant.svg` - Imagen consultor
- `woman.svg` - Imagen consultora
- `bg-mountain.svg` - Fondo montaña

## Rutas

### Públicas
- `/` - Landing
- `/login` - Inicio de sesión

### Privadas (requieren login)
- `/certificados` - Búsqueda certificados
- `/dashboard` - Panel admin
- `/logout` - Cerrar sesión (POST)

## Servidor

```bash
# Laravel
php artisan serve --host=0.0.0.0 --port=3000

# Vite (desarrollo)
npm run dev

# Build producción
npm run build
```

# Estilos, Colores, Temas e Imágenes - GISEMIN

## Dónde Editar Estilos

### Por Página
- **Landing:** `resources/css/landing.css`
- **Login:** `resources/css/login.css`
- **Certificados:** `resources/css/certificados.css`
- **Global:** `resources/css/app.css`

## Paleta de Colores

**Tema:** Grayscale completo

```css
/* Negros y grises oscuros */
#1a1a1a  /* Negro principal - Botones, títulos */
#333333  /* Gris oscuro - Degradados, textos */
#666666  /* Gris medio - Textos secundarios */

/* Grises claros */
#999999  /* Gris claro - Placeholders */
#cccccc  /* Muy claro - Bordes sutiles */
#e0e0e0  /* Ultra claro - Bordes inputs */
#f5f5f5  /* Fondos alternativos */

/* Blanco */
#ffffff  /* Fondos principales, textos en negro */
```

## Tipografías

- **Títulos:** Playfair Display
- **Textos:** Inter
- **Botones/Formularios:** Montserrat

## Imágenes

### Ubicación
**Carpeta:** `public/images/`

### Archivos Actuales
- `logo.svg` - Logo empresa
- `consultant.svg` - Consultor
- `woman.svg` - Consultora  
- `bg-mountain.svg` - Fondo montaña

### Agregar Nueva Imagen

1. Subir a: `public/images/nombre.svg`

2. En Blade:
```blade
<img src="{{ asset('images/nombre.svg') }}" alt="">
```

3. En CSS:
```css
background-image: url('/images/nombre.svg');
```

## Compilar Assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build

# Limpiar cache
php artisan optimize:clear
```

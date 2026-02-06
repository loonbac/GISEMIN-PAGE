# ✅ Sistema de Autocompletado de Cursos

## 🎯 ¿Qué se implementó?

### Base de Datos
- **Tabla `cursos`**: Almacena todos los cursos/capacitaciones
  - `nombre`: Nombre único del curso
  - `descripcion`: Descripción opcional
  - `uso_count`: Contador de cuántas veces se usa (para ordenar por popularidad)

### 75+ Cursos Precargados
Se incluyen todos los cursos que proporcionaste:
- Inducción y Legislación (11 cursos)
- Trabajo en Altura y Espacios (11 cursos)
- Primeros Auxilios y Emergencias (11 cursos)
- Máquinas y Herramientas (7 cursos)
- Salud Ocupacional (11 cursos)
- Medio Ambiente (6 cursos)
- Cultura y Comportamiento (10 cursos)
- Sectores Específicos (8 cursos)

### Formulario Mejorado
- ✅ Campo de texto en lugar de select limitado
- ✅ Autocompletado en tiempo real mientras escribes
- ✅ Búsqueda automática en la BD
- ✅ Posibilidad de agregar nuevos cursos on-the-fly

### API Endpoints
```
GET  /api/cursos              → Obtener lista de cursos (con búsqueda opcional)
POST /api/cursos              → Guardar nuevo curso
```

## 🚀 Instalación

### 1️⃣ Ejecutar migración
```bash
php artisan migrate
```

### 2️⃣ Cargar datos precargados
```bash
php artisan db:seed --class=CursoSeeder
```

O si usas el seeder general:
```bash
php artisan db:seed
```

(Necesitas registrar el CursoSeeder en `database/seeders/DatabaseSeeder.php`)

### 3️⃣ Reiniciar servidores
```bash
# Terminal 1
php artisan serve --host=0.0.0.0 --port=3000

# Terminal 2
npm run dev
```

## 🎨 Características

✅ **Autocompletado Dinámico**
- Mientras escribes, se filtra la lista
- Muestra los cursos más usados primero

✅ **Agregar Nuevos Cursos**
- Si escribes un curso que no existe y das clic fuera o envías el formulario, se guarda automáticamente
- La próxima vez que alguien escriba, verá ese curso en el autocompletado

✅ **Contador de Uso**
- Cada vez que se usa un curso, incrementa su contador
- Los más usados aparecen primero en la lista

✅ **Búsqueda Inteligente**
- Busca por cualquier palabra en el nombre del curso
- Ejemplo: escribir "altura" muestra "Trabajo en Altura", "Rescate en Altura", etc.

## 🔄 Flujo de Uso

1. Admin abre `/admin/certificados/agregar`
2. Escribe en el campo "Curso o Capacitación"
3. Se muestra autocompletado con coincidencias
4. Puede:
   - Seleccionar uno de los sugeridos
   - Escribir un nombre nuevo que no existe (se guardará al perder el foco)
5. Completa el resto del formulario y envía

## 📊 Base de Datos

### Tabla `cursos`
```sql
id         - INT PRIMARY KEY
nombre     - VARCHAR(255) UNIQUE
descripcion - TEXT (nullable)
uso_count  - INT (default: 0)
created_at - TIMESTAMP
updated_at - TIMESTAMP
```

### Tabla `certificados` (actualizada)
Ahora guarda el nombre exacto del curso seleccionado/creado.

## 🛠️ Próximas Mejoras (Opcional)

- Agregar API para obtener estadísticas de cursos más usados
- Dashboard con gráfico de cursos más frecuentes
- Editar/Eliminar cursos desde panel admin
- Agrupar cursos por categoría

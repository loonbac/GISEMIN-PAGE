# 📋 Sistema de Gestión de Certificados - Documentación

## ✅ Funcionalidades Implementadas

### 1. Página de Gestión de Certificados
**Ruta:** `/admin/certificados/gestionar`

**Características:**
- ✅ Muestra **TODOS los certificados** precargados en la base de datos (no solo los que tienen usuarios)
- ✅ Tabla ordenada alfabéticamente con información de cada certificado
- ✅ Columnas: Nombre del Curso | Trabajadores Asignados | Usos | Acciones
- ✅ Botones de acción: **Editar** y **Eliminar**

---

## 🔧 Acciones Disponibles

### Editar Certificado
**Funcionalidad:**
- Cambia el nombre del certificado en la base de datos
- Actualiza automáticamente el nombre para **TODOS los trabajadores** que tenían ese certificado
- Modal elegante con confirmación

**Ejemplo:**
- Certificado actual: "Trabajo en Altura"
- Nuevo nombre: "Trabajo en Alturas y Espacios Confinados"
- Resultado: Se actualiza el certificado de todos los trabajadores que lo tenían

### Eliminar Certificado
**Funcionalidad:**
- Muestra un modal con **lista de todos los trabajadores** que tienen ese certificado
- Permite ver detalles: Nombre, DNI, Código de Certificado
- ⚠️ Advertencia clara sobre las consecuencias
- Elimina el certificado y todos los registros de usuarios asociados

**Ejemplo:**
- Certificado: "Primeros Auxilios"
- Modal muestra: 5 trabajadores que lo tienen
- Al confirmar: Se eliminan los 5 registros de la base de datos

---

## 🎨 Interfaz de Usuario

### Notificaciones
- ✅ **SIN alertas del navegador** (eliminadas las `alert()`)
- ✅ Notificaciones personalizadas que aparecen en esquina superior derecha
- Tipos de notificación:
  - 🟢 **Éxito** (verde) - Operación completada
  - 🔴 **Error** (rojo) - Algo salió mal
  - 🟡 **Advertencia** (amarillo) - Validación de entrada
- Desaparecen automáticamente después de 4 segundos
- Botón de cerrar manual

### Modal de Edición
- Input con el nombre actual del certificado
- Validaciones:
  - No permite campos vacíos
  - Valida que el nuevo nombre sea diferente
- Botones: Cancelar | Guardar Cambios

### Modal de Eliminación
- Muestra advertencia en color naranja
- Lista de trabajadores afectados (si los hay)
- Información por trabajador:
  - Nombre completo
  - DNI
  - Código del certificado
- Confirmación adicional antes de eliminar

---

## 📊 Datos Mostrados

### Tabla de Certificados
| Columna | Descripción |
|---------|-------------|
| **Curso** | Nombre del certificado/capacitación |
| **Trabajadores** | Cantidad de personas con ese certificado (puede ser 0) |
| **Usos** | Contador de uso general (reservado para estadísticas futuras) |
| **Acciones** | Botones para editar o eliminar |

**Ejemplo de datos:**
```
Trabajo en Altura | 12 trabajadores
Primeros Auxilios | 25 trabajadores
Inducción y Legislación | 0 trabajadores (sin asignaciones)
Máquinas y Herramientas | 8 trabajadores
```

---

## 🔌 API Endpoints

### Obtener Usuarios de un Certificado
```
GET /admin/api/certificados/usuarios?curso=NombreDelCertificado
```
**Respuesta:**
```json
{
  "success": true,
  "usuarios": [
    {
      "id": 1,
      "nombre": "Juan Pérez",
      "dni": "12345678",
      "codigo": "CERT-2026-001",
      "fecha_emision": "2026-01-15"
    }
  ],
  "total": 1
}
```

### Actualizar Certificado
```
PUT /admin/api/certificados/actualizar
```
**Body:**
```json
{
  "curso_actual": "Trabajo en Altura",
  "curso_nuevo": "Trabajo en Alturas y Espacios Confinados"
}
```

### Eliminar Certificado
```
DELETE /admin/api/certificados/eliminar
```
**Body:**
```json
{
  "curso": "NombreDelCertificado"
}
```

---

## 📁 Archivos Modificados

### Backend (PHP/Laravel)
- **`CertificadosController.php`**
  - `gestionar()` - Obtiene TODOS los certificados (no solo los asignados)
  - `obtenerUsuariosCertificado()` - API para obtener usuarios de un certificado
  - `actualizarCertificado()` - API para editar nombre
  - `eliminarCertificado()` - API para eliminar

### Frontend (JavaScript)
- **`certificados-gestionar.js`** (NUEVO)
  - Gestión completa de modales
  - Sistema de notificaciones personalizado
  - Peticiones AJAX a APIs del servidor
  - Validaciones de entrada
  - Manejo de confirmaciones

### Vistas (Blade)
- **`agregar.blade.php`**
  - Agregado enlace: "Gestionar Certificados" en el navbar

- **`gestionar.blade.php`** (NUEVA)
  - Tabla de certificados
  - Dos modales: Edición y Eliminación
  - Integración con JavaScript

### Estilos (CSS)
- **`admin.css`**
  - Tabla de certificados con responsive design
  - Estilos para botones (editar/eliminar)
  - Sistema de modales con animaciones
  - Notificaciones personalizadas
  - Animaciones: slideUp, fadeIn, slideInNotification

### Configuración
- **`vite.config.js`**
  - Agregado: `certificados-gestionar.js` al bundle

---

## 🚀 Cómo Usar

### Acceder a Gestión de Certificados
1. Ir a `/admin/certificados/agregar`
2. Click en "Gestionar Certificados" en el navbar
3. O acceder directamente a `/admin/certificados/gestionar`

### Editar un Certificado
1. Click en botón **Editar** de la fila del certificado
2. Se abre modal con el nombre actual
3. Cambiar el nombre
4. Click en "Guardar Cambios"
5. Notificación de éxito
6. Página se recarga automáticamente

### Eliminar un Certificado
1. Click en botón **Eliminar** de la fila del certificado
2. Se abre modal con lista de trabajadores afectados
3. Leer la advertencia cuidadosamente
4. Click en "Sí, Eliminar Certificado"
5. Confirmación adicional del navegador
6. Notificación de éxito
7. Página se recarga automáticamente

---

## ⚠️ Consideraciones Importantes

1. **Pérdida de datos**: Al eliminar un certificado, se pierden todos los registros de usuarios con ese certificado
2. **Sin recuperación**: No hay papelera de reciclaje, la eliminación es permanente
3. **Actualización masiva**: Al editar un certificado, se actualizan TODOS los registros de usuarios que lo tienen
4. **Permiso requerido**: Solo usuarios autenticados pueden acceder (requiere `auth.simple` middleware)

---

## 🎯 Flujo de Datos

### Edición
```
Usuario hace click en "Editar"
    ↓
Modal se abre con nombre actual
    ↓
Usuario ingresa nuevo nombre
    ↓
Click "Guardar Cambios"
    ↓
AJAX PUT a /admin/api/certificados/actualizar
    ↓
Controlador actualiza tabla certificados (UPDATE curso WHERE curso = old)
    ↓
Si existe en tabla cursos, también se actualiza
    ↓
Respuesta JSON success
    ↓
Notificación verde de éxito
    ↓
Página se recarga automáticamente
```

### Eliminación
```
Usuario hace click en "Eliminar"
    ↓
AJAX GET a /admin/api/certificados/usuarios
    ↓
Modal se abre mostrando lista de usuarios
    ↓
Usuario hace click "Sí, Eliminar"
    ↓
Confirmación adicional del navegador
    ↓
AJAX DELETE a /admin/api/certificados/eliminar
    ↓
Controlador elimina de tabla certificados
    ↓
Controlador elimina de tabla cursos (si existe)
    ↓
Respuesta JSON success
    ↓
Notificación verde de éxito
    ↓
Página se recarga automáticamente
```

---

## 🔒 Seguridad

- ✅ CSRF token requerido en todas las peticiones
- ✅ Validación de entrada en el servidor
- ✅ Middleware `auth.simple` protege las rutas
- ✅ Validación de datos antes de hacer cambios en BD
- ✅ Confirmación doble para operaciones destructivas

---

## 📱 Responsivo

- ✅ Tabla se adapta a pantallas pequeñas
- ✅ Modales optimizados para mobile
- ✅ Notificaciones se posicionan correctamente
- ✅ Botones de acción tienen tamaño adecuado


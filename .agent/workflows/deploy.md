---
description: Cómo desplegar cambios al servidor VPS
---

Para ver los cambios reflejados en tu página pública (`http://100.83.130.19`) después de que yo termine de editar, sigue estos pasos:

1. **Guardar cambios localmente**: Asegúrate de que he terminado de editar todos los archivos solicitados.
2. **Subir al repositorio (Git Push)**:
   ```bash
   git add .
   git commit -m "Descripción de los cambios realizados"
   git push origin main
   ```
3. **Actualizar el servidor VPS**:
   Entra a tu terminal del VPS y ejecuta:
   ```bash
   git pull origin main
   ```
// turbo
4. **Compilar para Producción**: (IMPORTANTE para CSS y JS nuevos)
   En la terminal del VPS, ejecuta:
   ```bash
   npm run build
   ```
5. **Limpiar Caché de Laravel**: (Solo si cambiaste lógica o rutas)
   En la terminal del VPS, ejecuta:
   ```bash
   php artisan optimize:clear
   ```

¡Listo! Con esto tus cambios estarán en vivo.

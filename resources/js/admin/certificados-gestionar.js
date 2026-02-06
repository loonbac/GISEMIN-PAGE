document.addEventListener('DOMContentLoaded', function () {
    // Elementos de los modales
    const editModal = document.getElementById('edit-modal');
    const deleteModal = document.getElementById('delete-modal');
    const categorizeModal = document.getElementById('categorize-modal');
    const editButtons = document.querySelectorAll('.btn-edit');
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const categorizeButtons = document.querySelectorAll('.btn-categorizar');

    const closeEditModal = document.getElementById('close-edit-modal');
    const closeDeleteModal = document.getElementById('close-delete-modal');
    const closeCategorizeModal = document.getElementById('close-categorize-modal');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const confirmEditBtn = document.getElementById('confirm-edit');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const cancelCategorizeBtn = document.getElementById('cancel-categorize');
    const confirmCategorizeBtn = document.getElementById('confirm-categorize');

    const editCursoOld = document.getElementById('edit-curso-old');
    const editCursoName = document.getElementById('edit-curso-name');
    const usersList = document.getElementById('users-list');
    const categorizeCurso = document.getElementById('categorize-curso');
    const categoriaSelect = document.getElementById('categoria-select');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Funcionalidad de colapsar/expandir categorías
    const categoriaHeaders = document.querySelectorAll('.categoria-header');

    categoriaHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const content = this.nextElementSibling;
            const isCollapsed = content.classList.contains('collapsed');

            if (isCollapsed) {
                content.classList.remove('collapsed');
                this.classList.add('active');
            } else {
                content.classList.add('collapsed');
                this.classList.remove('active');
            }
        });

    });

    // Función para mostrar notificaciones
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span>${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `;

        document.body.appendChild(notification);

        notification.querySelector('.notification-close').addEventListener('click', function () {
            notification.remove();
        });

        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    // Abrir modal de edición
    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const curso = this.getAttribute('data-curso');
            editCursoOld.value = curso;
            editCursoName.value = curso;
            editModal.classList.remove('hidden');
        });
    });

    // Cerrar modal de edición
    function closeEdit() {
        editModal.classList.add('hidden');
    }

    closeEditModal.addEventListener('click', closeEdit);
    cancelEditBtn.addEventListener('click', closeEdit);
    document.getElementById('edit-modal').addEventListener('click', function (e) {
        if (e.target === this) closeEdit();
    });

    // Confirmar edición
    confirmEditBtn.addEventListener('click', async function () {
        const cursoActual = editCursoOld.value;
        const cursoNuevo = editCursoName.value.trim();

        if (!cursoNuevo) {
            showNotification('Por favor ingresa un nombre para el certificado', 'warning');
            return;
        }

        if (cursoActual === cursoNuevo) {
            showNotification('El nombre es igual al actual', 'warning');
            return;
        }

        try {
            const response = await fetch('/admin/api/certificados/actualizar', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    curso_actual: cursoActual,
                    curso_nuevo: cursoNuevo,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showNotification('✅ ' + data.message, 'success');
                // Actualizar el DOM localmente
                const rows = document.querySelectorAll(`tr[data-curso="${cursoActual}"]`);
                rows.forEach(row => {
                    row.setAttribute('data-curso', cursoNuevo);
                    const nameCell = row.querySelector('.curso-name');
                    if (nameCell) nameCell.innerText = cursoNuevo;

                    // Actualizar atributos de los botones dentro de la fila
                    row.querySelectorAll('[data-curso]').forEach(el => {
                        el.setAttribute('data-curso', cursoNuevo);
                    });
                });
            } else {
                showNotification('❌ Error: ' + (data.message || 'No se pudo actualizar'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('❌ Error en la solicitud', 'error');
        }

        closeEdit();
    });

    // Abrir modal de eliminación
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', async function () {
            const curso = this.getAttribute('data-curso');
            editCursoOld.value = curso;

            try {
                const response = await fetch(`/admin/api/certificados/usuarios?curso=${encodeURIComponent(curso)}`);
                const data = await response.json();

                if (data.success && data.usuarios) {
                    // Limpiar lista anterior
                    usersList.innerHTML = '';

                    if (data.usuarios.length === 0) {
                        usersList.innerHTML = '<p class="no-users">No hay trabajadores con este certificado</p>';
                    } else {
                        const list = document.createElement('ul');
                        list.className = 'users-items';
                        data.usuarios.forEach(user => {
                            const li = document.createElement('li');
                            li.className = 'user-item';
                            li.innerHTML = `
                                <div class="user-info">
                                    <strong>${user.nombre}</strong>
                                    <span class="dni">DNI: ${user.dni}</span>
                                </div>
                                <div class="user-code">
                                    <span class="code-label">Código:</span>
                                    <span class="code-value">${user.codigo}</span>
                                </div>
                            `;
                            list.appendChild(li);
                        });
                        usersList.appendChild(list);
                    }

                    deleteModal.classList.remove('hidden');
                } else {
                    showNotification('Error al obtener información de usuarios', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al obtener información de usuarios', 'error');
            }
        });
    });

    // Cerrar modal de eliminación
    function closeDelete() {
        deleteModal.classList.add('hidden');
    }

    closeDeleteModal.addEventListener('click', closeDelete);
    cancelDeleteBtn.addEventListener('click', closeDelete);
    document.getElementById('delete-modal').addEventListener('click', function (e) {
        if (e.target === this) closeDelete();
    });

    // Confirmar eliminación
    confirmDeleteBtn.addEventListener('click', async function () {
        const curso = editCursoOld.value;
        const usuariosCount = document.querySelectorAll('.user-item').length;

        if (usuariosCount > 0 && !confirm(`¿Estás seguro de que quieres eliminar el certificado "${curso}" y los registros de ${usuariosCount} trabajador(es)?`)) {
            return;
        }

        try {
            const response = await fetch('/admin/api/certificados/eliminar', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    curso: curso,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showNotification('✅ ' + data.message, 'success');
                // Remover la fila del DOM
                const row = document.querySelector(`tr[data-curso="${curso}"]`);
                if (row) {
                    const categorySection = row.closest('.categoria-section');
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        // Actualizar contador de la categoría
                        if (categorySection) {
                            const countSpan = categorySection.querySelector('.categoria-count');
                            const rowsLeft = categorySection.querySelectorAll('tbody tr').length;
                            if (countSpan) {
                                countSpan.innerText = `(${rowsLeft} certificado${rowsLeft !== 1 ? 's' : ''})`;
                            }
                            // Si no quedan filas, ocultar la sección
                            if (rowsLeft === 0) {
                                categorySection.style.display = 'none';
                            }
                        }
                    }, 300);
                }
            } else {
                showNotification('❌ Error: ' + (data.message || 'No se pudo eliminar'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('❌ Error en la solicitud', 'error');
        }

        closeDelete();
    });

    // Prevenir envío de formulario
    document.getElementById('edit-curso-name')?.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            confirmEditBtn.click();
        }
    });

    // Abrir modal de categorización
    categorizeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const curso = this.getAttribute('data-curso');
            categorizeCurso.value = curso;
            categoriaSelect.value = '';
            categorizeModal.classList.remove('hidden');
        });
    });

    // Cerrar modal de categorización
    function closeCategorize() {
        categorizeModal.classList.add('hidden');
    }

    closeCategorizeModal.addEventListener('click', closeCategorize);
    cancelCategorizeBtn.addEventListener('click', closeCategorize);
    document.getElementById('categorize-modal').addEventListener('click', function (e) {
        if (e.target === this) closeCategorize();
    });

    // Confirmar categorización
    confirmCategorizeBtn.addEventListener('click', async function () {
        const curso = categorizeCurso.value;
        const categoria = categoriaSelect.value;

        if (!categoria) {
            showNotification('Por favor selecciona una categoría', 'warning');
            return;
        }

        try {
            const response = await fetch('/admin/api/certificados/categorizar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    curso: curso,
                    categoria: categoria,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showNotification('✅ ' + data.message, 'success');
                // Esto es más complejo porque cambia de categoría
                // Para simplificar y asegurar consistencia, aquí sí recargaremos 
                // pero con un delay para que se vea el mensaje de éxito
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('❌ Error: ' + (data.message || 'No se pudo categorizar'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('❌ Error en la solicitud', 'error');
        }

        closeCategorize();
    });

    // --- Lógica del Modal Crear Curso ---
    const createModal = document.getElementById('create-modal');
    const btnAddCourse = document.getElementById('btn-add-course');
    const closeCreateModal = document.getElementById('close-create-modal');
    const cancelCreateBtn = document.getElementById('cancel-create');
    const confirmCreateBtn = document.getElementById('confirm-create');
    const createCursoName = document.getElementById('create-curso-name');
    const createCursoCategory = document.getElementById('create-curso-category');

    // Abrir modal
    if (btnAddCourse) {
        btnAddCourse.addEventListener('click', function () {
            createCursoName.value = '';
            createCursoCategory.value = '';
            createModal.classList.remove('hidden');
        });
    }

    // Cerrar modal
    function closeCreate() {
        createModal.classList.add('hidden');
    }

    if (closeCreateModal) closeCreateModal.addEventListener('click', closeCreate);
    if (cancelCreateBtn) cancelCreateBtn.addEventListener('click', closeCreate);
    if (createModal) {
        createModal.addEventListener('click', function (e) {
            if (e.target === this) closeCreate();
        });
    }

    // Confirmar creación
    if (confirmCreateBtn) {
        confirmCreateBtn.addEventListener('click', async function () {
            const nombre = createCursoName.value.trim();
            const categoria = createCursoCategory.value;

            if (!nombre) {
                showNotification('Ingresa el nombre del curso', 'warning');
                return;
            }
            if (!categoria) {
                showNotification('Selecciona una categoría', 'warning');
                return;
            }

            try {
                const response = await fetch('/admin/api/certificados/crear-curso', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ nombre, categoria }),
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('✅ ' + data.message, 'success');
                    // Al crear uno nuevo, lo mejor es recargar para que aparezca en la categoría correcta con sus estilos
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification('❌ ' + (data.message || 'Error al guardar'), 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('❌ Error de conexión', 'error');
            }

            closeCreate();
        });
    }
});


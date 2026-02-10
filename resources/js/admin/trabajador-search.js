/**
 * Script para búsqueda de trabajadores y autocompletado de formulario
 */

document.addEventListener('DOMContentLoaded', () => {
    const btnBuscar = document.getElementById('btn-buscar');
    const dniInput = document.getElementById('dni-search');

    // Register vars
    const btnRegisterUser = document.getElementById('btn-register-user');
    const btnCancelRegister = document.getElementById('btn-cancel-register');

    if (btnBuscar) {
        btnBuscar.addEventListener('click', buscarTrabajador);
    }

    if (dniInput) {
        dniInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') buscarTrabajador();
        });

        // Auto-reset UI when search is cleared
        dniInput.addEventListener('input', (e) => {
            if (e.target.value.trim().length === 0) {
                resetView();
            }
        });
    }



    if (btnRegisterUser) {
        btnRegisterUser.addEventListener('click', registrarNuevoUsuario);
    }

    if (btnCancelRegister) {
        btnCancelRegister.addEventListener('click', () => {
            document.getElementById('register-user-section').classList.add('hidden');
            document.getElementById('right-empty-state').classList.remove('hidden');
            document.querySelector('.search-card').classList.remove('hidden');
        });
    }

    // Validation for course selection
    const cursoInput = document.getElementById('curso-input');
    if (cursoInput) {
        cursoInput.addEventListener('input', () => {
            cursoInput.dataset.isValid = 'false';
            validateCourseSelection();
        });
        cursoInput.addEventListener('change', validateCourseSelection);
    }

    window.validateCourseSelection = validateCourseSelection;

    // Handle Certificate AJAX Submission
    const certForm = document.querySelector('#certificate-form-card form');
    if (certForm) {
        certForm.addEventListener('submit', handleCertificateSubmit);
    }

    // Handle Direct Company Assignment
    const btnAssignCompany = document.getElementById('btn-assign-company');
    if (btnAssignCompany) {
        btnAssignCompany.addEventListener('click', handleAssignCompany);
    }

    const btnRemoveCompany = document.getElementById('btn-remove-company');
    if (btnRemoveCompany) {
        btnRemoveCompany.addEventListener('click', handleRemoveCompany);
    }
});

function validateCourseSelection() {
    const cursoInput = document.getElementById('curso-input');
    const selectionBox = cursoInput.closest('.selection-box');
    const btnSubmit = document.getElementById('btn-submit-certificate'); // Targeted ID
    const validationMsg = document.getElementById('course-validation-msg');

    if (!cursoInput || !btnSubmit || !selectionBox) return;

    const value = cursoInput.value.trim();
    const hasValue = value.length > 0;
    const isValid = cursoInput.dataset.isValid === 'true';
    const isDuplicate = cursoInput.dataset.isDuplicate === 'true';

    // Reset styles
    selectionBox.style.borderColor = '#e2e8f0';
    selectionBox.style.background = 'white';
    cursoInput.style.background = 'white';

    // Button state: only if it has a value AND is marked as valid AND is NOT a duplicate
    const canSubmit = isValid && !isDuplicate;
    btnSubmit.disabled = !canSubmit;
    btnSubmit.style.opacity = canSubmit ? '1' : '0.5';
    btnSubmit.style.cursor = canSubmit ? 'pointer' : 'not-allowed';

    if (validationMsg) {
        if (!hasValue) {
            selectionBox.style.borderColor = '#e2e8f0';
            selectionBox.style.background = 'white';
            validationMsg.style.color = '#94a3b8';
            validationMsg.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                Rellena esto con un certificado válido
            `;
        } else if (isDuplicate) {
            selectionBox.style.borderColor = '#fbbf24';
            selectionBox.style.background = '#fffbeb';
            validationMsg.style.color = '#92400e';
            validationMsg.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                Ya seleccionaste este certificado. ¡Prueba con otro!
            `;
        } else if (isValid) {
            selectionBox.style.borderColor = '#10b981';
            selectionBox.style.background = 'rgba(16, 185, 129, 0.05)';
            validationMsg.style.color = '#10b981';
            validationMsg.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                Certificado válido seleccionado
            `;
        } else {
            // Typing but haven't selected yet
            selectionBox.style.borderColor = '#3b82f6'; // Focus/Search blue instead of red
            selectionBox.style.background = 'rgba(59, 130, 246, 0.02)';
            validationMsg.style.color = '#3b82f6';
            validationMsg.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                Selecciona un certificado de la lista desplegable
            `;
        }
    }
}

async function handleCertificateSubmit(e) {
    e.preventDefault();
    const form = e.target;
    // Specific search for the certificate button within this form
    const btnSubmit = document.getElementById('btn-submit-certificate') || form.querySelector('button[type="submit"]');
    const formData = new FormData(form);

    // Disable button and show loading state
    console.log('Sending certificate registration...');
    const originalContent = btnSubmit.innerHTML; // Keep for fallback
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = '<svg class="animate-spin" style="margin-right: 8px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle><path d="M12 2a10 10 0 0 1 10 10"></path></svg> Registrando...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            // Success! Deep Reset for consecutive registrations
            const cursoInput = document.getElementById('curso-input');
            const dateInput = form.querySelector('input[name="fecha_emision"]');
            const duracionSelect = form.querySelector('select[name="duracion"]');
            const driveInput = form.querySelector('input[name="drive_link"]');

            if (cursoInput) {
                cursoInput.value = '';
                cursoInput.dataset.isValid = 'false';
                cursoInput.dataset.isDuplicate = 'false';
            }
            if (dateInput) {
                const today = new Date().toISOString().split('T')[0];
                dateInput.value = today;
            }
            if (duracionSelect) duracionSelect.selectedIndex = 0;
            if (driveInput) driveInput.value = '';

            // 2. Clear Active State from Renewal List
            document.querySelectorAll('#renew-options-list .course-option').forEach(el => {
                el.classList.remove('active');
                const badge = el.querySelector('.renewal-badge');
                if (badge) badge.style.display = 'none';
                el.style.borderColor = '#e2e8f0';
                el.style.background = 'white';
            });

            // 3. Reset validation labels
            const validationMsg = document.getElementById('course-validation-msg');
            if (validationMsg) {
                validationMsg.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Rellena esto con un certificado válido
                `;
                validationMsg.style.color = '#94a3b8';
            }

            // 4. Restore button
            btnSubmit.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                REGISTRAR CERTIFICADO
            `;
            btnSubmit.style.background = '';
            btnSubmit.disabled = true;

            // 5. Trigger background refresh of history
            buscarTrabajador().catch(() => { });
        }
        else if (response.status === 422) {
            // Duplicate detected by server
            const cursoInput = document.getElementById('curso-input');
            if (cursoInput) {
                cursoInput.dataset.isDuplicate = 'true';
                validateCourseSelection();
            }
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = originalContent;
        } else {
            await showAlert('Error', data.message || 'Error al registrar certificado', 'error');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalContent;
        }

    } catch (error) {
        console.error('Error:', error);
        await showAlert('Error', 'Error de conexión al servidor', 'error');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = originalContent;
    }
}

async function buscarTrabajador() {
    const dni = document.getElementById('dni-search').value.trim();
    if (dni.length < 1) {
        await showAlert('Atención', 'Por favor, ingresa un número de DNI', 'warning');
        return;
    }

    const btnBuscar = document.getElementById('btn-buscar');
    btnBuscar.disabled = true;

    try {
        const response = await fetch(`/api/trabajadores/buscar?dni=${dni}&_t=${Date.now()}`);
        const data = await response.json();

        if (data.success && data.encontrado) {
            mostrarTrabajador(data.trabajador);
        } else {
            mostrarRegistroUsuario(dni);
        }
    } catch (error) {
        console.error('Error:', error);
        await showAlert('Error', 'Hubo un problema al buscar el trabajador', 'error');
    } finally {
        btnBuscar.disabled = false;
    }
}

function mostrarTrabajador(trabajador) {
    // Show sections
    const profileInfoSection = document.getElementById('profile-info-section');
    if (profileInfoSection) profileInfoSection.classList.remove('hidden');

    document.getElementById('register-user-section').classList.add('hidden');

    // Fill profile
    document.getElementById('profile-nombre').textContent = trabajador.nombre;
    document.getElementById('profile-dni').textContent = `DNI: ${trabajador.dni}`;

    const profileEmpresa = document.getElementById('profile-empresa');
    const formEmpresa = document.getElementById('form-empresa');

    if (profileEmpresa) {
        profileEmpresa.textContent = trabajador.empresa || 'Independiente';
    }

    const btnAssignCompany = document.getElementById('btn-assign-company');
    const btnRemoveCompany = document.getElementById('btn-remove-company');

    if (formEmpresa) {
        const isIndependiente = !trabajador.empresa || trabajador.empresa === 'Independiente';
        formEmpresa.value = trabajador.empresa || '';

        if (isIndependiente) {
            formEmpresa.readOnly = false;
            formEmpresa.style.background = 'white';
            formEmpresa.style.cursor = 'text';
            formEmpresa.placeholder = 'Agregar Empresa (Opcional)';
            if (btnAssignCompany) btnAssignCompany.style.display = 'block';
            if (btnRemoveCompany) btnRemoveCompany.style.display = 'none';
        } else {
            formEmpresa.readOnly = true;
            formEmpresa.style.background = '#f1f5f9';
            formEmpresa.style.cursor = 'not-allowed';
            formEmpresa.placeholder = 'Ej: GISEMIN S.A.C.';
            if (btnAssignCompany) btnAssignCompany.style.display = 'none';
            if (btnRemoveCompany) btnRemoveCompany.style.display = 'block';
        }
    }

    const profileTotal = document.getElementById('profile-total');
    if (profileTotal) {
        profileTotal.textContent = trabajador.total_certificados;
    }

    document.getElementById('hidden-dni').value = trabajador.dni;
    document.getElementById('hidden-nombre').value = trabajador.nombre;

    // Fill Form Inputs Hidden
    document.getElementById('form-nombre').value = trabajador.nombre;
    document.getElementById('form-dni').value = trabajador.dni;

    // Show Form Column
    document.getElementById('right-empty-state').classList.add('hidden');
    document.getElementById('certificate-form-card').classList.remove('hidden');

    // Render History
    renderHistory(trabajador.vencidos, trabajador.vigentes);

    // Render Renew Options inside Form
    renderRenewOptions(trabajador.vencidos);

    // Initial validation check
    const cursoInput = document.getElementById('curso-input');
    if (cursoInput) {
        cursoInput.dataset.isValid = 'false';
        cursoInput.dataset.isDuplicate = 'false';
    }
    validateCourseSelection();
}

// Helper to format date
function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    try {
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return dateStr; // Fallback to raw string

        // Return DD/MM/YYYY
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    } catch (e) {
        return dateStr;
    }
}

function renderHistory(vencidos, vigentes) {
    const listVencidas = document.getElementById('list-vencidas');
    const listVigentes = document.getElementById('list-vigentes');
    const cardVencidas = document.getElementById('history-vencidas-card');
    const cardVigentes = document.getElementById('history-vigentes-card');

    // Clear
    listVencidas.innerHTML = '';
    listVigentes.innerHTML = '';

    // Vencidas
    if (vencidos && vencidos.length > 0) {
        cardVencidas.classList.remove('hidden');
        const pillEl = document.getElementById('count-vencidas-pill');
        if (pillEl) pillEl.textContent = vencidos.length;

        vencidos.forEach(cert => {
            const div = document.createElement('div');
            div.className = 'history-item venced';
            div.innerHTML = `
            <h5>${cert.curso}</h5>
            <p>Venció el: ${formatDate(cert.fecha_vencimiento)}</p>
        `;
            listVencidas.appendChild(div);
        });
    } else {
        cardVencidas.classList.add('hidden');
    }

    // Vigentes
    if (vigentes && vigentes.length > 0) {
        cardVigentes.classList.remove('hidden');
        const pillEl = document.getElementById('count-vigentes-pill');
        if (pillEl) pillEl.textContent = vigentes.length;

        vigentes.forEach(cert => {
            const div = document.createElement('div');
            div.className = 'history-item valid';
            div.innerHTML = `
            <h5>${cert.curso}</h5>
            <p>Vence: ${formatDate(cert.fecha_vencimiento)}</p>
        `;
            listVigentes.appendChild(div);
        });
    } else {
        cardVigentes.classList.add('hidden');
    }
}

function renderRenewOptions(vencidos) {
    const list = document.getElementById('renew-options-list');
    if (!list) return;
    list.innerHTML = '';

    if (vencidos && vencidos.length > 0) {
        vencidos.forEach(cert => {
            const div = document.createElement('div');
            div.className = 'course-option';
            div.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h5>${cert.curso}</h5>
                    <p style="color: #ef4444; font-weight: 600;">Venció el ${formatDate(cert.fecha_vencimiento)}</p>
                </div>
                <div class="renewal-badge" style="display:none; background: #fbbf24; color: #92400e; font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 800;">SELECCIONADO</div>
            </div>
        `;
            div.addEventListener('click', () => {
                selectCourseForRenewal(cert.curso, div);
            });
            list.appendChild(div);
        });
    } else {
        list.innerHTML = '<p style="font-size: 13px; color: #64748b; font-style: italic; margin-top: 10px;">No hay certificados vencidos para renovar.</p>';
    }
}

function selectCourseForRenewal(cursoNombre, element) {
    // Remove active state from others
    document.querySelectorAll('#renew-options-list .course-option').forEach(el => {
        el.classList.remove('active');
        const badge = el.querySelector('.renewal-badge');
        if (badge) badge.style.display = 'none';
        el.style.borderColor = '#e2e8f0';
        el.style.background = 'white';
    });

    // Add active state to selected
    if (element) {
        element.classList.add('active');
        const selectedBadge = element.querySelector('.renewal-badge');
        if (selectedBadge) selectedBadge.style.display = 'block';
        element.style.borderColor = '#fbbf24';
        element.style.background = '#fffbeb';
    }

    const cursoInput = document.getElementById('curso-input');
    cursoInput.value = cursoNombre;
    cursoInput.dataset.isValid = 'true';

    // Trigger validation
    validateCourseSelection();

    // Trigger existing checkStatus logic
    if (typeof checkCertificateStatus === 'function') {
        const dni = document.getElementById('hidden-dni').value;
        checkCertificateStatus(dni, cursoNombre);
    }

    // Focus next step for the user
    const dateInput = document.querySelector('input[name="fecha_emision"]');
    if (dateInput) {
        dateInput.focus();
        dateInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Visual cue
        const originalBorder = dateInput.style.borderColor;
        dateInput.style.borderColor = '#fbbf24';
        dateInput.style.boxShadow = '0 0 0 4px rgba(245, 158, 11, 0.2)';
        setTimeout(() => {
            dateInput.style.borderColor = originalBorder;
            dateInput.style.boxShadow = '';
        }, 1500);
    }
}

function resetView() {
    document.getElementById('dni-search').value = '';

    const profileInfoSection = document.getElementById('profile-info-section');
    if (profileInfoSection) profileInfoSection.classList.add('hidden');

    document.getElementById('history-vigentes-card').classList.add('hidden');
    document.getElementById('history-vencidas-card').classList.add('hidden');
    document.getElementById('right-empty-state').classList.remove('hidden');
    document.getElementById('certificate-form-card').classList.add('hidden');
    document.getElementById('register-user-section').classList.add('hidden');
}

function mostrarRegistroUsuario(dni) {
    const regDniEdit = document.getElementById('reg-dni-edit');
    if (regDniEdit) {
        regDniEdit.value = dni;
    }

    // Hide profile and history
    const profileInfoSection = document.getElementById('profile-info-section');
    if (profileInfoSection) profileInfoSection.classList.add('hidden');

    document.getElementById('history-vigentes-card').classList.add('hidden');
    document.getElementById('history-vencidas-card').classList.add('hidden');

    // Reset right column to empty state
    document.getElementById('right-empty-state').classList.remove('hidden');
    document.getElementById('certificate-form-card').classList.add('hidden');

    document.getElementById('register-user-section').classList.remove('hidden');
    document.getElementById('new-user-nombre').focus();
}

async function registrarNuevoUsuario() {
    const nombreInput = document.getElementById('new-user-nombre');
    const dniInput = document.getElementById('reg-dni-edit');
    const btnRegister = document.getElementById('btn-register-user');

    if (!nombreInput || !dniInput || !btnRegister) return;

    const nombre = nombreInput.value.trim();
    const dni = dniInput.value.trim();

    if (!dni) {
        await showAlert('Atención', 'Ingresa un DNI válido', 'warning');
        return;
    }

    if (!nombre) {
        await showAlert('Atención', 'Ingresa el nombre completo', 'warning');
        return;
    }

    // Show loading state
    const originalContent = btnRegister.innerHTML;
    btnRegister.disabled = true;
    btnRegister.innerHTML = '<svg class="animate-spin" style="margin: 0 auto; width: 14px; height: 14px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

    try {
        const response = await fetch('/api/trabajadores/registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ dni, nombre })
        });

        const data = await response.json();

        if (data.success) {
            // Success! Show full worker profile and form
            const formEmpresa = document.getElementById('form-empresa');
            if (formEmpresa) {
                formEmpresa.value = empresa;
                formEmpresa.readOnly = true;
                formEmpresa.style.background = '#f1f5f9';
                formEmpresa.style.cursor = 'not-allowed';
            }

            mostrarTrabajador({
                nombre: nombre,
                dni: dni,
                empresa: null,
                total_certificados: 0,
                vencidos: [],
                vigentes: []
            });
        } else {
            await showAlert('Error', data.message || 'Error al registrar usuario', 'error');
            btnRegister.disabled = false;
            btnRegister.innerHTML = originalContent;
        }
    } catch (error) {
        console.error('Error:', error);
        await showAlert('Error', 'Error de conexión al servidor', 'error');
        btnRegister.disabled = false;
        btnRegister.innerHTML = originalContent;
    }
}

async function handleAssignCompany() {
    const btn = document.getElementById('btn-assign-company');
    const input = document.getElementById('form-empresa');
    const dniInput = document.getElementById('hidden-dni');

    if (!dniInput) return;
    const dni = dniInput.value;
    const empresa = input.value.trim();

    if (!empresa) {
        await showAlert('Atención', 'Por favor, ingresa un nombre de empresa', 'warning');
        return;
    }

    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = '...';

    try {
        const response = await fetch('/api/trabajadores/asignar-empresa', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ dni, empresa })
        });

        const data = await response.json();

        if (data.success) {
            // Success! Block field and hide button
            input.readOnly = true;
            input.style.background = '#f1f5f9';
            input.style.cursor = 'not-allowed';
            btn.style.display = 'none';

            // Update profile label
            const profileEmpresa = document.getElementById('profile-empresa');
            if (profileEmpresa) profileEmpresa.textContent = empresa.toUpperCase();

            console.log('Empresa asignada correctamente');
            await showAlert('¡Éxito!', 'Empresa asignada correctamente.', 'success');
        } else {
            await showAlert('Error', data.message || 'Error al asignar empresa', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        await showAlert('Error', 'Error de conexión', 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = originalText;
    }
}


async function handleRemoveCompany() {
    const btn = document.getElementById('btn-remove-company');
    const btnAssign = document.getElementById('btn-assign-company');
    const input = document.getElementById('form-empresa');
    const dniInput = document.getElementById('hidden-dni');

    if (!dniInput) return;
    const dni = dniInput.value;

    const confirmed = await showConfirm('¿Estás seguro?', 'El usuario volverá a ser Independiente y saldrá del grupo de la empresa.', 'warning');
    if (!confirmed) {
        return;
    }

    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = '...';

    try {
        const response = await fetch('/api/trabajadores/remover-empresa', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ dni })
        });

        const data = await response.json();

        if (data.success) {
            // Re-enable field and show ASIGNAR, hide REMOVER
            input.value = '';
            input.readOnly = false;
            input.style.background = 'white';
            input.style.cursor = 'text';
            input.placeholder = 'Agregar Empresa (Opcional)';

            btn.style.display = 'none';
            if (btnAssign) btnAssign.style.display = 'block';

            // Update profile label
            const profileEmpresa = document.getElementById('profile-empresa');
            if (profileEmpresa) profileEmpresa.textContent = 'Independiente';

            console.log('Empresa removida correctamente');
            await showAlert('¡Éxito!', 'Usuario removido de la empresa con éxito.', 'success');
        } else {
            await showAlert('Error', data.message || 'Error al remover empresa', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        await showAlert('Error', 'Error de conexión', 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = originalText;
    }
}

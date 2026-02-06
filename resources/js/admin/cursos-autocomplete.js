/**
 * Script de autocompletado para cursos en formulario de certificados
 */

document.addEventListener('DOMContentLoaded', () => {
    initCursoAutocomplete();

    // Convert to global functions if needed
    window.checkCertificateStatus = checkCertificateStatus;
    window.updateFormUI = updateFormUI;
});

function initCursoAutocomplete() {
    const cursoInput = document.getElementById('curso-input');
    const cursoDropdown = document.getElementById('cursos-dropdown');
    let debounceTimer;

    if (!cursoInput || !cursoDropdown) return;

    // Evento de input para filtrar y mostrar dropdown con debounce
    cursoInput.addEventListener('input', function () {
        const termino = this.value.trim();
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            cargarCursos(termino);
        }, 300);
    });

    // Mostrar cursos al hacer focus (aunque esté vacío)
    cursoInput.addEventListener('focus', function () {
        const termino = this.value.trim();
        if (termino === '' || cursoDropdown.children.length === 0) {
            cargarCursos(termino);
        } else {
            cursoDropdown.classList.add('active');
        }
    });

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function (e) {
        if (!cursoInput.contains(e.target) && !cursoDropdown.contains(e.target)) {
            cursoDropdown.classList.remove('active');
        }
    });

    // Navegación con teclado (opcional, básico)
    cursoInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            cursoDropdown.classList.remove('active');
        }
    });
}

async function cargarCursos(termino) {
    const cursoDropdown = document.getElementById('cursos-dropdown');
    const cursoInput = document.getElementById('curso-input');

    const dniInput = document.getElementById('hidden-dni');
    const dni = dniInput ? dniInput.value : '';

    try {
        const response = await fetch(`/api/cursos/buscar?q=${encodeURIComponent(termino)}&dni=${dni}`);
        const data = await response.json();

        cursoDropdown.innerHTML = '';

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(curso => {
                const li = document.createElement('li');
                li.textContent = curso.nombre;
                li.className = 'cursor-pointer px-4 py-2 hover:bg-gray-100'; // Clases opcionales si usas Tailwind, sino CSS base maneja

                li.addEventListener('click', function () {
                    cursoInput.value = curso.nombre;
                    cursoInput.dataset.isValid = 'true';
                    cursoInput.dataset.isDuplicate = 'false'; // Reset until checked
                    cursoDropdown.classList.remove('active');

                    // Trigger validation immediately
                    if (typeof validateCourseSelection === 'function') {
                        validateCourseSelection();
                    }

                    // Verificar estado del certificado
                    const dniInput = document.getElementById('hidden-dni');
                    if (dniInput && dniInput.value) {
                        checkCertificateStatus(dniInput.value, curso.nombre);
                    }
                });

                cursoDropdown.appendChild(li);
            });
            cursoDropdown.classList.add('active');
        } else {
            cursoDropdown.classList.remove('active');
        }
    } catch (error) {
        console.error('Error cargando cursos:', error);
    }
}

async function checkCertificateStatus(dni, curso) {
    try {
        const response = await fetch(`/api/certificados/check-status?dni=${dni}&curso=${encodeURIComponent(curso)}&_t=${Date.now()}`);
        const data = await response.json();

        updateFormUI(data.status, data.certificado);
    } catch (error) {
        console.error('Error verificando estado:', error);
    }
}

function updateFormUI(status, certificado = null) {
    const cursoInput = document.getElementById('curso-input');
    const submitBtn = document.querySelector('.btn-submit-main');

    if (!cursoInput || !submitBtn) return;

    // Reset duplicate state
    cursoInput.dataset.isDuplicate = 'false';

    if (status === 'vigente') {
        cursoInput.dataset.isDuplicate = 'true';
    } else if (status === 'vencido') {
        // Optionially handle vencido pre-fill or special UI if needed, 
        // but for now let's focus on the duplicate requirement.
        if (certificado && certificado.drive_link) {
            const driveInput = document.querySelector('input[name="drive_link"]');
            if (driveInput) driveInput.value = certificado.drive_link;
        }
    }

    // Trigger validation to update UI inline
    if (typeof validateCourseSelection === 'function') {
        setTimeout(validateCourseSelection, 50); // Minimal delay to ensure dataset properties are updated
    }
}

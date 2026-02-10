/**
 * Script de autocompletado para empresas en el panel de administración
 */

document.addEventListener('DOMContentLoaded', () => {
    initEmpresaAutocomplete();
});

function initEmpresaAutocomplete() {
    const empresaInput = document.getElementById('form-empresa');
    const empresaDropdown = document.getElementById('empresas-dropdown');
    let debounceTimer;

    if (!empresaInput || !empresaDropdown) return;

    // Evento de input para filtrar y mostrar dropdown con debounce
    empresaInput.addEventListener('input', function () {
        if (this.readOnly) return;

        const termino = this.value.trim();
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            cargarEmpresas(termino);
        }, 300);
    });

    // Mostrar empresas al hacer focus (aunque esté vacío)
    empresaInput.addEventListener('focus', function () {
        if (this.readOnly) return;

        const termino = this.value.trim();
        if (termino === '' || empresaDropdown.children.length === 0) {
            cargarEmpresas(termino);
        } else {
            empresaDropdown.classList.add('active');
        }
    });

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function (e) {
        if (!empresaInput.contains(e.target) && !empresaDropdown.contains(e.target)) {
            empresaDropdown.classList.remove('active');
        }
    });

    // Navegación con teclado
    empresaInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            empresaDropdown.classList.remove('active');
        }
    });
}

async function cargarEmpresas(termino) {
    const empresaDropdown = document.getElementById('empresas-dropdown');
    const empresaInput = document.getElementById('form-empresa');

    try {
        const response = await fetch(`/api/empresas/buscar?q=${encodeURIComponent(termino)}`);
        const data = await response.json();

        empresaDropdown.innerHTML = '';

        if (Array.isArray(data) && data.length > 0) {
            data.forEach(empresaNombre => {
                const li = document.createElement('li');
                li.textContent = empresaNombre;

                li.addEventListener('click', function () {
                    empresaInput.value = empresaNombre;
                    empresaDropdown.classList.remove('active');

                    // Trigger sync if needed (for other scripts watching this field)
                    empresaInput.dispatchEvent(new Event('input'));
                });

                empresaDropdown.appendChild(li);
            });
            empresaDropdown.classList.add('active');
        } else {
            empresaDropdown.classList.remove('active');
        }
    } catch (error) {
        console.error('Error cargando empresas:', error);
    }
}

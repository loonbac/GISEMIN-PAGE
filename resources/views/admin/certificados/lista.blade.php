@extends('layouts.admin')

@section('title', 'Lista de Usuarios - Admin GISEMIN')

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css'])
<style>
    /* Stats Ultra Slim Rectangles */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .stats-summary .stat-card {
        background: white;
        padding: 0 16px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 40px; /* Even smaller height */
        transition: transform 0.2s;
    }

    .stats-summary .stat-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .stats-summary .stat-content {
        display: flex;
        flex-direction: row;
        align-items: center; /* Vertical center */
        justify-content: center; /* Horizontal center */
        gap: 12px;
        width: 100%;
    }

    .stats-summary .stat-number {
        font-size: 21px; /* Refined size */
        font-weight: 800;
        color: #0f5f8c;
        line-height: 1;
        margin: 0;
    }

    .stats-summary .stat-label {
        font-size: 16px; /* Refined size */
        color: #64748b;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 1;
        margin: 0;
    }

    /* User List Compact Strip - Grid Layout Balanced */
    .user-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 8px;
        overflow: hidden;
        transition: all 0.2s;
    }

    .user-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    .user-header {
        display: grid;
        grid-template-columns: 50px 1.2fr 110px 1fr 40px 40px; /* Added column for user delete */
        align-items: stretch;
        padding: 0 16px;
        cursor: pointer;
        user-select: none;
        transition: background 0.2s;
        height: 52px;
        gap: 16px; /* Controlled gap */
    }

    .user-header:hover {
        background: #f8fafc;
    }

    /* Force all columns to be perfectly centered containers */
    .user-header > div {
        display: flex !important;
        align-items: center !important; /* FORCE VERTICAL CENTER */
        height: 52px !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    /* Left-align specific content containers */
    .user-col-name,
    .user-col-dni,
    .user-stats {
        justify-content: flex-start;
    }

    /* Center-align specific content containers */
    .user-col-avatar,
    .user-col-icon {
        justify-content: center;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background: linear-gradient(135deg, #0f5f8c 0%, #0d4a6f 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
        margin: 0 !important;
    }

    .user-name {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 !important; /* CRITICAL: Remove default H3 margins */
        line-height: 1 !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: left;
    }

    .user-dni {
        font-size: 11px;
        color: #64748b;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 4px;
        font-family: monospace;
        font-weight: 700;
        letter-spacing: 0.5px;
        border: 1px solid #e2e8f0;
        line-height: 1 !important;
        margin: 0 !important;
    }

    .user-stats {
        gap: 6px;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1 !important;
        margin: 0 !important;
    }

    /* Icon Column */
    .collapse-icon {
        width: 18px;
        height: 18px;
        color: #94a3b8;
        transition: transform 0.3s;
    }
    
    .stat-badge.vigente {
        background: #d1fae5;
        color: #065f46;
    }

    .stat-badge.expirado {
        background: #fee2e2;
        color: #991b1b;
    }

    .collapse-icon {
        width: 20px;
        height: 20px;
        color: #94a3b8;
        transition: transform 0.3s;
    }

    .user-card.expanded .collapse-icon {
        transform: rotate(180deg);
    }
    
    /* Content & Table */
    .user-content {
        display: none;
        padding: 0 20px 20px;
        border-top: 1px solid #f1f5f9;
        background: #fcfcfc;
    }

    .user-card.expanded .user-content {
        display: block;
    }

    .cert-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }

    .cert-table th {
        text-align: left;
        padding: 8px 12px;
        background: transparent;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
    }

    .cert-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #334155;
    }

    .cert-table tr:last-child td {
        border-bottom: none;
    }

    .status-vigente { color: #059669; font-weight: 600; }
    .status-expirado { color: #dc2626; font-weight: 600; }
    .code-badge { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 6px; font-family: monospace; font-size: 13px; }

    .btn-view-drive { color: #0066B3; text-decoration: none; font-weight: 500; }
    .btn-view-drive:hover { text-decoration: underline; }

    .action-buttons { display: flex; gap: 6px; }
    
    .btn-action {
        padding: 4px 8px;
        border: none;
        border-radius: 10px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: background 0.2s;
    }
    
    .btn-action svg { width: 14px; height: 14px; }
    
    .btn-edit { background: #e0f2fe; color: #0369a1; }
    .btn-edit:hover { background: #bae6fd; }
    
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }

    .btn-user-delete {
        background: transparent;
        color: #dc2626;
        border: none;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        opacity: 0.1; /* High-risk action, keep subtle unless hovered */
    }
    
    .user-card:hover .btn-user-delete {
        opacity: 0.6;
    }
    
    .btn-user-delete:hover {
        background: #fee2e2;
        opacity: 1 !important;
        transform: scale(1.1);
    }
    
    .btn-user-delete svg {
        width: 18px;
        height: 18px;
    }

    .search-container { margin-bottom: 24px; }

    /* Modal Button Refinements */
    .modal-footer .btn-secondary,
    .modal-footer .btn-submit,
    .modal-footer .btn-danger {
        padding: 8px 20px !important;
        font-size: 13px !important;
        height: 38px !important;
        border-radius: 8px !important;
        text-transform: none !important;
        letter-spacing: normal !important;
    }

    .modal-footer .btn-secondary {
        background: #ef4444 !important; /* Red for Cancel */
        color: white !important;
    }

    .modal-footer .btn-secondary:hover {
        background: #dc2626 !important;
    }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
    <!-- Admin Navbar -->
    <nav class="admin-navbar">
        <div class="admin-nav-container">
            <a href="{{ route('home') }}" class="admin-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="GISEMIN Logo" class="logo-icon">
                <div class="logo-text-container">
                    <span class="logo-text">GISEMIN</span>
                    <span class="logo-accent">ADMIN</span>
                </div>
            </a>
            <div class="nav-actions">
                <a href="{{ route('admin.certificados.agregar') }}" class="btn-nav-primary">Editar/Agregar Usuarios</a>
                <a href="{{ route('admin.certificados.gestionar') }}" class="btn-nav-success">Gestionar Certificados</a>
                <a href="{{ route('certificados') }}" class="btn-nav-orange">Ver Certificados Públicos</a>
                <a href="{{ route('admin.reclamaciones.index') }}" class="btn-nav-yellow">Reclamaciones</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-container">
        <div class="admin-content" style="max-width: 1100px;">
            <div class="admin-card">
                <div class="form-header">
                    <h1>Lista de Usuarios</h1>
                    <p>{{ $usuarios->count() }} usuarios registrados</p>
                </div>

                <!-- Stats Summary -->
                <div class="stats-summary">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-users-count">{{ $usuarios->count() }}</div>
                            <div class="stat-label">Usuarios</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-certs-count">{{ $usuarios->sum('total_certificados') }}</div>
                            <div class="stat-label">Certificados</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-vigentes-count" style="color: #059669;">{{ $usuarios->sum('vigentes_count') }}</div>
                            <div class="stat-label">Vigentes</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-expirados-count" style="color: #dc2626;">{{ $usuarios->sum('expirados_count') }}</div>
                            <div class="stat-label">Expirados</div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-input" placeholder="Buscar por nombre o DNI..." onkeyup="filterUsers()">
                </div>

                <!-- Users List -->
                <div id="users-list">
                    @forelse($usuarios as $usuario)
                    <div class="user-card" data-nombre="{{ strtolower($usuario['nombre']) }}" data-dni="{{ $usuario['dni'] }}">
                        <div class="user-header" onclick="toggleUser(this)">
                            
                            <!-- Col 1: Avatar -->
                            <div class="user-col-avatar">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($usuario['nombre'], 0, 1)) }}
                                </div>
                            </div>

                            <!-- Col 2: Name -->
                            <div class="user-col-name">
                                <h3 class="user-name">{{ $usuario['nombre'] }}</h3>
                            </div>

                            <!-- Col 3: DNI -->
                            <div class="user-col-dni">
                                <span class="user-dni">DNI: {{ $usuario['dni'] }}</span>
                            </div>

                            <!-- Col 4: Dual Status Badges -->
                            <div class="user-stats">
                                @if($usuario['vigentes_count'] > 0)
                                    <span class="stat-badge vigente">{{ $usuario['vigentes_count'] }} Vigente(s)</span>
                                @endif
                                @if($usuario['expirados_count'] > 0)
                                    <span class="stat-badge expirado">{{ $usuario['expirados_count'] }} Expirado(s)</span>
                                @endif
                            </div>

                            <!-- Col 5: Trash (Cascade Delete) -->
                            <div class="user-col-delete">
                                <button class="btn-user-delete" title="Eliminar Usuario y Certificados" onclick="confirmDeleteUser('{{ $usuario['dni'] }}', '{{ $usuario['nombre'] }}', event)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Col 6: Icon -->
                            <div class="user-col-icon">
                                <svg class="collapse-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        </div>
                        <div class="user-content">
                            <table class="cert-table">
                                <thead>
                                    <tr>
                                        <th>Curso</th>
                                        <th>Fecha Emisión</th>
                                        <th>Estado</th>
                                        <th>Link</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usuario['certificados'] as $cert)
                                    @php
                                        $now = now()->setTimezone('America/Lima')->format('Y-m-d');
                                        $esVigente = $cert->fecha_vencimiento >= $now;
                                    @endphp
                                    <tr id="cert-row-{{ $cert->id }}">
                                        <td>{{ $cert->curso }}</td>
                                        <td>{{ $cert->fecha_emision->format('d/m/Y') }}</td>
                                        <td>
                                            @if($esVigente)
                                                <span class="status-vigente">Vigente</span>
                                            @else
                                                <span class="status-expirado">Expirado</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($cert->drive_link)
                                                <a href="{{ $cert->drive_link }}" target="_blank" class="btn-view-drive">Ver Drive</a>
                                            @else
                                                <span style="color: #999;">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-edit" onclick="openEditModal({{ $cert->id }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                    Editar
                                                </button>
                                                <button class="btn-action btn-delete" onclick="confirmDelete({{ $cert->id }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                                            Este usuario no tiene certificados registrados.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="text-align: center; padding: 40px; color: #64748b;">
                        No hay usuarios registrados.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar certificado -->
<div id="editCertModal" class="modal hidden">
    <div class="modal-overlay" onclick="closeEditModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Certificado</h2>
            <button class="modal-close" onclick="closeEditModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <!-- Área para mensajes de error local -->
            <div id="edit-error-area" style="display: none; background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 500; margin-bottom: 16px; border: 1px solid #fecaca; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px; flex-shrink: 0;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span id="edit-error-msg"></span>
            </div>

            <form id="editCertForm">
                <input type="hidden" id="edit-cert-id">
                <div class="form-group">
                    <label class="form-label">Curso</label>
                    <select id="edit-cert-curso" class="form-input" required>
                        <option value="">Seleccione un curso...</option>
                        @foreach($cursos as $c)
                            <option value="{{ $c->nombre }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Fecha Emisión</label>
                    <input type="date" id="edit-cert-fecha" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Link Drive (URL)</label>
                    <input type="url" id="edit-cert-link" class="form-input">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeEditModal()">Cancelar</button>
            <button type="button" class="btn-submit" id="btn-save-edit" onclick="saveCertificate()">Guardar Cambios</button>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div id="deleteCertModal" class="modal hidden">
    <div class="modal-overlay" onclick="closeDeleteModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Eliminar Certificado</h2>
            <button class="modal-close" onclick="closeDeleteModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="color: #64748b; font-size: 14px;">¿Estás seguro de que deseas eliminar este certificado? Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
            <button type="button" class="btn-danger" id="btn-confirm-delete" onclick="executeDelete()">Eliminar Definitivamente</button>
        </div>
    </div>
</div>

<script>
function toggleUser(header) {
    const card = header.closest('.user-card');
    card.classList.toggle('expanded');
}

function filterUsers() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.user-card');
    
    cards.forEach(card => {
        const nombre = card.dataset.nombre;
        const dni = card.dataset.dni;
        
        if (nombre.includes(search) || dni.includes(search)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Edit Logic
async function openEditModal(certId) {
    try {
        const response = await fetch(`/api/certificados/${certId}`);
        const data = await response.json();
        
        if (data.success) {
            const cert = data.certificado;
            document.getElementById('edit-cert-id').value = cert.id;
            document.getElementById('edit-cert-curso').value = cert.curso;
            
            // Limpiar errores previos
            document.getElementById('edit-error-area').style.display = 'none';
            document.getElementById('edit-error-msg').innerText = '';

            // Filtrar dropdown de cursos
            const cursoSelect = document.getElementById('edit-cert-curso');
            const vigentes = data.cursos_vigentes || [];
            
            Array.from(cursoSelect.options).forEach(option => {
                if (!option.value) return; // Saltarse la opción por defecto
                
                const valorLimpio = option.value.toLowerCase();
                // Ocultar si ya tiene un certificado vigente para ese curso
                // EXCEPTO si es el curso que ya tiene el certificado actual (para permitir cambios de fecha/link)
                if (vigentes.includes(valorLimpio) && valorLimpio !== cert.curso.toLowerCase()) {
                    option.style.display = 'none';
                } else {
                    option.style.display = '';
                }
            });
            
            // Format date for input[type="date"] (YYYY-MM-DD)
            // If it comes as YYYY-MM-DD HH:MM:SS or ISO, we just need the first 10 chars
            const formattedDate = cert.fecha_emision.split('T')[0].split(' ')[0];
            document.getElementById('edit-cert-fecha').value = formattedDate;
            
            document.getElementById('edit-cert-link').value = cert.drive_link || '';
            
            document.getElementById('editCertModal').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error fetching cert:', error);
        alert('Error al obtener datos del certificado');
    }
}

function closeEditModal() {
    document.getElementById('editCertModal').classList.add('hidden');
}

async function saveCertificate() {
    const id = document.getElementById('edit-cert-id').value;
    const btn = document.getElementById('btn-save-edit');
    const originalText = btn.innerText;

    const payload = {
        curso: document.getElementById('edit-cert-curso').value,
        fecha_emision: document.getElementById('edit-cert-fecha').value,
        drive_link: document.getElementById('edit-cert-link').value,
    };

    btn.disabled = true;
    btn.innerText = 'Guardando...';

    try {
        const response = await fetch(`/api/certificados/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success) {
            // Actualizar la fila en el DOM
            const row = document.getElementById(`cert-row-${id}`);
            if (row) {
                const cells = row.getElementsByTagName('td');
                cells[0].innerText = data.certificado.curso;
                cells[1].innerText = data.formatted_date;
                
                // Estado
                cells[2].innerHTML = data.es_vigente 
                    ? '<span class="status-vigente">Vigente</span>' 
                    : '<span class="status-expirado">Expirado</span>';
                
                // Link
                cells[3].innerHTML = data.certificado.drive_link 
                    ? `<a href="${data.certificado.drive_link}" target="_blank" class="btn-view-drive">Ver Drive</a>`
                    : '<span style="color: #999;">-</span>';
            }

            // Actualizar badges del usuario y stats globales
            const userCard = document.querySelector(`.user-card[data-dni="${document.getElementById('hidden-dni-active')?.value || ''}"]`) 
                           || row?.closest('.user-card');
            
            if (data.user_stats && userCard) {
                const statsContainer = userCard.querySelector('.user-stats');
                if (statsContainer) {
                    let html = '';
                    if (data.user_stats.vigentes > 0) {
                        html += `<span class="stat-badge vigente">${data.user_stats.vigentes} Vigente(s)</span>`;
                    }
                    if (data.user_stats.expirados > 0) {
                        html += `<span class="stat-badge expirado">${data.user_stats.expirados} Expirado(s)</span>`;
                    }
                    statsContainer.innerHTML = html;
                }
            }

            if (data.global_stats) {
                updateGlobalStats(data.global_stats);
            }

            closeEditModal();
        } else {
            // Mostrar error en el área local del modal
            const errorArea = document.getElementById('edit-error-area');
            const errorMsg = document.getElementById('edit-error-msg');
            errorMsg.innerText = data.message || 'Error al actualizar';
            errorArea.style.display = 'flex';
            errorArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    } catch (error) {
        console.error('Error:', error);
        const errorArea = document.getElementById('edit-error-area');
        const errorMsg = document.getElementById('edit-error-msg');
        errorMsg.innerText = 'Error de conexión con el servidor';
        errorArea.style.display = 'flex';
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

// Delete Logic
let certToDelete = null;

function confirmDelete(certId) {
    certToDelete = certId;
    document.getElementById('deleteCertModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteCertModal').classList.add('hidden');
    certToDelete = null;
}

async function executeDelete() {
    if (!certToDelete) return;
    
    const btn = document.getElementById('btn-confirm-delete');
    const originalText = btn.innerText;
    
    btn.disabled = true;
    btn.innerText = 'Eliminando...';

    try {
        const response = await fetch(`/api/certificados/${certToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const row = document.getElementById(`cert-row-${certToDelete}`);
            if (row) {
                const userCard = row.closest('.user-card');
                row.style.transition = 'opacity 0.3s';
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    
                    // Actualizar badges del usuario
                    if (data.user_stats && userCard) {
                        const statsContainer = userCard.querySelector('.user-stats');
                        if (statsContainer) {
                            let html = '';
                            if (data.user_stats.vigentes > 0) {
                                html += `<span class="stat-badge vigente">${data.user_stats.vigentes} Vigente(s)</span>`;
                            }
                            if (data.user_stats.expirados > 0) {
                                html += `<span class="stat-badge expirado">${data.user_stats.expirados} Expirado(s)</span>`;
                            }
                            statsContainer.innerHTML = html;
                        }
                    }
                }, 300);
            }

            if (data.global_stats) {
                updateGlobalStats(data.global_stats);
            }

            closeDeleteModal();
        } else {
            alert(data.message || 'Error al eliminar');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de red');
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

function updateGlobalStats(stats) {
    if (document.getElementById('global-users-count')) 
        document.getElementById('global-users-count').innerText = stats.total_usuarios;
    if (document.getElementById('global-certs-count')) 
        document.getElementById('global-certs-count').innerText = stats.total_certificados;
    if (document.getElementById('global-vigentes-count')) 
        document.getElementById('global-vigentes-count').innerText = stats.total_vigentes;
    if (document.getElementById('global-expirados-count')) 
        document.getElementById('global-expirados-count').innerText = stats.total_expirados;
}

// User Delete Logic
let userDniToDelete = null;

function confirmDeleteUser(dni, nombre, event) {
    if (event) event.stopPropagation(); // Don't toggle the card
    userDniToDelete = dni;
    document.getElementById('deleteUserModal').classList.remove('hidden');
    document.getElementById('delete-user-name').textContent = nombre;
    document.getElementById('delete-user-dni').textContent = dni;
}

function closeDeleteUserModal() {
    document.getElementById('deleteUserModal').classList.add('hidden');
    userDniToDelete = null;
}

async function executeUserDelete() {
    if (!userDniToDelete) return;
    
    const btn = document.getElementById('btn-confirm-user-delete');
    const originalText = btn.innerText;
    
    btn.disabled = true;
    btn.innerText = 'Eliminando Usuario...';

    try {
        const response = await fetch(`/api/trabajadores/${userDniToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const card = document.querySelector(`.user-card[data-dni="${userDniToDelete}"]`);
            if (card) {
                card.style.transition = 'all 0.4s';
                card.style.opacity = '0';
                card.style.transform = 'translateX(20px)';
                setTimeout(() => card.remove(), 400);
            }

            if (data.global_stats) {
                updateGlobalStats(data.global_stats);
            }

            closeDeleteUserModal();
        } else {
            alert(data.message || 'Error al eliminar usuario');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de red al intentar eliminar el usuario');
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}
</script>
<!-- Modal para confirmar eliminación de USUARIO (Cascada) -->
<div id="deleteUserModal" class="modal hidden">
    <div class="modal-overlay" onclick="closeDeleteUserModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2 style="color: #dc2626;">Eliminar Usuario Completo</h2>
            <button class="modal-close" onclick="closeDeleteUserModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="color: #1e293b; font-weight: 700; font-size: 15px; margin-bottom: 8px;">¿Eliminar a <span id="delete-user-name"></span>?</p>
            <p style="color: #64748b; font-size: 13px; margin-bottom: 12px;">DNI: <span id="delete-user-dni"></span></p>
            <div style="background: #fff1f2; border-left: 4px solid #dc2626; padding: 12px; margin-bottom: 15px;">
                <p style="color: #991b1b; font-size: 12px; font-weight: 600;">
                    <i class="fas fa-exclamation-triangle"></i> ADVERTENCIA: Esta acción eliminará al usuario y TODOS sus certificados registrados.
                </p>
            </div>
            <p style="color: #64748b; font-size: 12px;">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" onclick="closeDeleteUserModal()">Cancelar</button>
            <button type="button" class="btn-danger" id="btn-confirm-user-delete" onclick="executeUserDelete()" style="background: #dc2626;">Borrar Usuario y Todo</button>
        </div>
    </div>
</div>

@endsection

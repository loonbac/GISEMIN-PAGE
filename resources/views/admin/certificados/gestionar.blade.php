@extends('layouts.admin')

@section('title', 'Gestionar Certificados - Admin GISEMIN')

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css'])
<style>
    /* Responsive Improvements for Gestionar Certificados */
    @media (max-width: 991px) {
        .admin-container {
            padding: 12px 8px !important;
        }

        .form-header h1 {
            font-size: 20px !important;
            margin-bottom: 8px !important;
        }

        .form-header p {
            font-size: 13px !important;
            line-height: 1.4 !important;
        }

        .action-bar {
            margin-bottom: 20px !important;
        }

        .btn-submit {
            padding: 12px !important;
            font-size: 13px !important;
        }

        .categoria-header {
            padding: 8px 12px !important;
        }

        .categoria-title {
            font-size: 11px !important;
            gap: 6px !important;
        }

        .categoria-count {
            font-size: 10px !important;
            opacity: 0.8;
        }

        /* Transform table to cards */
        .certificates-table thead {
            display: none;
        }

        .certificates-table, 
        .certificates-table tbody, 
        .certificates-table tr, 
        .certificates-table td {
            display: block;
            width: 100%;
            border: none !important;
        }

        .certificates-table tr {
            background: white;
            border: 1px solid #f1f5f9 !important;
            border-radius: 12px;
            margin-bottom: 12px;
            padding: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            position: relative;
        }

        .certificates-table td {
            padding: 0 !important;
            margin-bottom: 8px;
            text-align: left !important;
        }

        .certificates-table td:last-child {
            margin-bottom: 0;
            margin-top: 14px;
            padding-top: 12px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        /* Custom styles for card contents */
        .curso-name {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            display: flex !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }

        .curso-name::before {
            content: "";
            display: inline-block;
            width: 18px;
            height: 18px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%233b82f6' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' /%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .cantidad {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #64748b !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .cantidad::before {
            content: "Trabajadores:";
            font-weight: 700;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cantidad::after {
            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238b5cf6' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z' /%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
            order: -1;
        }

        .action-buttons {
            justify-content: flex-start !important;
            gap: 10px !important;
        }

        .btn-action {
            flex: 1;
            padding: 10px !important;
            font-size: 12px !important;
            justify-content: center !important;
            border-radius: 8px !important;
        }

        .btn-edit {
            background: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid #dbeafe !important;
        }

        .btn-delete {
            background: #fef2f2 !important;
            color: #dc2626 !important;
            border: 1px solid #fee2e2 !important;
        }

        .modal-content {
            width: 95% !important;
            padding: 20px !important;
            margin: 10px !important;
        }

        .modal-header h2 {
            font-size: 16px !important;
        }

        .modal-body {
            padding: 15px 0 !important;
        }

        .modal-footer {
            flex-direction: column;
            gap: 8px;
        }

        .modal-footer button {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .form-header h1 {
            font-size: 18px !important;
        }
        
        .categoria-title {
            font-size: 12px !important;
        }
    }
</style>
@endpush

@push('scripts')
@vite('resources/js/admin/certificados-gestionar.js')
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
                <a href="{{ route('admin.certificados.lista') }}" class="btn-nav-purple">Lista de Usuarios</a>
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
        <div class="admin-content">
            <div class="admin-card">
                <div class="form-header">
                    <h1>Gestionar Certificados</h1>
                    <p>Administra los tipos de certificados y capacitaciones disponibles. Puedes agregar, editar o eliminar certificados.</p>
                </div>

                <div class="action-bar" style="margin-bottom: 30px;">
                    <button type="button" id="btn-add-course" class="btn-submit" style="width: 100%;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14m-7-7h14"/>
                        </svg>
                        AGREGAR NUEVO CERTIFICADO
                    </button>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @foreach($categorias as $catKey => $categoria)
                    @if(count($categoria['cursos']) > 0)
                        <div class="categoria-section collapsible-section">
                            <div class="categoria-header" data-category="{{ $catKey }}">
                                <h2 class="categoria-title">
                                    <svg class="collapse-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                    {{ $categoria['nombre'] }}
                                    <span class="categoria-count">({{ count($categoria['cursos']) }} certificado{{ count($categoria['cursos']) != 1 ? 's' : '' }})</span>
                                </h2>
                            </div>
                            <div class="categoria-content collapsed">
                                <div class="table-wrapper">
                                    <table class="certificates-table">
                                        <thead>
                                            <tr>
                                                <th class="col-curso">Certificado</th>
                                                <th class="col-trabajadores">Trabajadores</th>
                                                <th class="col-acciones">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categoria['cursos'] as $curso)
                                                <tr data-curso="{{ $curso['nombre'] }}" data-cantidad="{{ $curso['cantidad'] }}" data-categoria="{{ $catKey }}">
                                                    <td class="curso-name">{{ $curso['nombre'] }}</td>
                                                    <td class="cantidad">{{ $curso['cantidad'] }}</td>
                                                    <td class="actions">
                                                        <div class="action-buttons">
                                                            <button class="btn-action btn-edit" data-curso="{{ $curso['nombre'] }}" title="Editar nombre del certificado">
                                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                                </svg>
                                                                Editar
                                                            </button>
                                                            <button class="btn-action btn-delete" data-curso="{{ $curso['nombre'] }}" title="Eliminar certificado">
                                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <polyline points="3 6 5 6 21 6"/>
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                                    <line x1="10" y1="11" x2="10" y2="17"/>
                                                                    <line x1="14" y1="11" x2="14" y2="17"/>
                                                                </svg>
                                                                Eliminar
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar certificado -->
<div id="edit-modal" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Nombre del Certificado</h2>
            <button class="modal-close" id="close-edit-modal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p class="warning-text">Este cambio se aplicará a todos los trabajadores que tienen este certificado.</p>
            <input type="hidden" id="edit-curso-old" />
            <div class="form-group">
                <label class="form-label">Nombre Actual del Certificado</label>
                <input type="text" id="edit-curso-name" class="form-input" placeholder="Nombre del certificado" />
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="cancel-edit" class="btn-secondary">Cancelar</button>
            <button type="button" id="confirm-edit" class="btn-submit">Guardar Cambios</button>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div id="delete-modal" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Eliminar Certificado</h2>
            <button class="modal-close" id="close-delete-modal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p class="warning-text">⚠️ <strong>Atención:</strong> Al eliminar este certificado, también se borrarán todos los registros de los trabajadores que lo tenían.</p>
            <p class="info-text">Los siguientes trabajadores serán afectados:</p>
            <div id="users-list" class="users-list"></div>
        </div>
        <div class="modal-footer">
            <button type="button" id="cancel-delete" class="btn-secondary">Cancelar</button>
            <button type="button" id="confirm-delete" class="btn-danger">Sí, Eliminar Certificado</button>
        </div>
    </div>
</div>

<!-- Modal para categorizar -->
<div id="categorize-modal" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Asignar Categoría al Certificado</h2>
            <button class="modal-close" id="close-categorize-modal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="categorize-curso" />
            <p class="info-text">Selecciona la categoría correcta para este certificado:</p>
            <div class="form-group">
                <select id="categoria-select" class="form-input">
                    <option value="">-- Selecciona una categoría --</option>
                    <option value="obligatorias">🔴 Capacitaciones Obligatorias / Normativas (SST)</option>
                    <option value="alto_riesgo">🟠 Trabajos de Alto Riesgo (TAR)</option>
                    <option value="emergencias">🟡 Emergencias y Primeros Auxilios</option>
                    <option value="equipos">🔵 Equipos, Maquinaria y Herramientas</option>
                    <option value="salud">🟢 Higiene Ocupacional y Salud</option>
                    <option value="ambiente">🟣 Medio Ambiente y SST (SSOMA)</option>
                    <option value="cultura">⚫ Capacitaciones Complementarias / Cultura Preventiva</option>
                    <option value="sectores">🔧 Capacitaciones Específicas (Según Sector)</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="cancel-categorize" class="btn-secondary">Cancelar</button>
            <button type="button" id="confirm-categorize" class="btn-submit">Asignar Categoría</button>
        </div>
    </div>
</div>

<!-- Modal para crear curso -->
<div id="create-modal" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>Agregar Nuevo Certificado</h2>
            <button class="modal-close" id="close-create-modal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p class="info-text">Ingresa el nombre del nuevo certificado y selecciona su categoría.</p>
            <div class="form-group">
                <label class="form-label">Nombre del Certificado</label>
                <input type="text" id="create-curso-name" class="form-input" placeholder="Ej: Seguridad en Alturas" />
            </div>
            <div class="form-group">
                <label class="form-label">Categoría</label>
                <select id="create-curso-category" class="form-input">
                    <option value="">-- Selecciona una categoría --</option>
                    <option value="obligatorias">🔴 Capacitaciones Obligatorias / Normativas (SST)</option>
                    <option value="alto_riesgo">🟠 Trabajos de Alto Riesgo (TAR)</option>
                    <option value="emergencias">🟡 Emergencias y Primeros Auxilios</option>
                    <option value="equipos">🔵 Equipos, Maquinaria y Herramientas</option>
                    <option value="salud">🟢 Higiene Ocupacional y Salud</option>
                    <option value="ambiente">🟣 Medio Ambiente y SST (SSOMA)</option>
                    <option value="cultura">⚫ Capacitaciones Complementarias / Cultura Preventiva</option>
                    <option value="sectores">🔧 Capacitaciones Específicas (Según Sector)</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="cancel-create" class="btn-secondary">Cancelar</button>
            <button type="button" id="confirm-create" class="btn-submit">Crear Certificado</button>
        </div>
    </div>
</div>
@endsection

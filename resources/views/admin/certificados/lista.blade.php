@extends('layouts.admin')

@section('title', 'Lista de Usuarios - Admin GISEMIN')

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css'])
<style>
    /* Stats Ultra Slim Rectangles */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
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
        grid-template-columns: 50px 1fr 110px 1fr 80px; /* Redefined 5 columns for balance */
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

    /* Desktop: Target ONLY the 5 visible columns as flex containers */
    .user-col-avatar,
    .user-info-main,
    .user-col-dni,
    .user-stats,
    .user-header-actions {
        display: flex !important;
        align-items: center !important;
        height: 52px !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    /* Center-align specific columns on desktop */
    .user-col-avatar,
    .user-col-dni,
    .user-stats {
        justify-content: center;
    }

    .user-info-main {
        justify-content: flex-start;
    }

    .user-header-actions {
        justify-content: flex-end !important;
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
        text-align: center;
        padding: 10px 12px;
        background: transparent;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        border-bottom: 2px solid #e2e8f0;
    }

    .cert-table td {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #334155;
        text-align: center;
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
        padding: 6px 10px;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-view-drive-full {
        background: #0066B3;
        color: white !important;
        width: 100%;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .btn-action svg { width: 16px; height: 16px; }
    
    .btn-edit { background: #e0f2fe; color: #0369a1; }
    .btn-edit:hover { background: #bae6fd; }
    
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }

    .btn-user-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
        padding: 8px;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        opacity: 0.8;
    }
    
    .btn-user-delete:hover {
        background: #fecaca;
        opacity: 1;
        transform: scale(1.05);
    }
    
    .btn-user-delete svg {
        width: 18px;
        height: 18px;
    }

    .user-header-actions {
        display: flex !important;
        align-items: center !important;
        gap: 8px;
        justify-content: flex-end !important;
    }

    .btn-edit-inline {
        background: #f1f5f9;
        border: none;
        padding: 5px;
        border-radius: 6px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-edit-inline:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .search-container { margin-bottom: 24px; }

    /* Company Group "Window" Style */
    .company-group {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 24px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .company-header-toggle {
        padding: 16px 20px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        user-select: none;
        transition: background 0.2s;
        border-bottom: 2px solid #e2e8f0;
    }

    .company-header-toggle:hover {
        background: #f1f5f9;
    }

    .company-header-toggle h2 {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .company-chevron {
        margin-left: auto;
        width: 18px;
        height: 18px;
        color: #94a3b8;
        transition: transform 0.3s;
    }

    .company-group.collapsed .company-chevron {
        transform: rotate(-90deg);
    }

    .company-users-container {
        padding: 16px;
        transition: max-height 0.3s ease-out;
    }

    .company-group.collapsed .company-users-container {
        display: none;
    }

    /* Modal Button Refinements - General class */
    .btn-secondary-red {
        background: #fef2f2 !important; /* Light red background */
        color: #dc2626 !important; /* Red text */
        border: 2px solid #fee2e2 !important;
        padding: 8px 20px !important;
        font-size: 13px !important;
        height: 38px !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-secondary-red:hover {
        background: #fee2e2 !important;
    }

    .modal-footer .btn-secondary {
        /* Aliasing for consistency if needed */
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border: 2px solid #fee2e2 !important;
        padding: 8px 20px !important;
        font-size: 13px !important;
        height: 38px !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
    }

    .modal-footer .btn-secondary:hover {
        background: #fee2e2 !important;
    }

    .modal-footer .btn-submit,
    .modal-footer .btn-danger {
        padding: 8px 20px !important;
        font-size: 13px !important;
        height: 38px !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    /* New Card-Based Details for Mobile */
    .cert-cards-mobile {
        display: none;
        flex-direction: column;
        gap: 12px;
        margin-top: 15px;
    }

    .cert-mobile-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .cert-mobile-title {
        font-size: 15px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .cert-mobile-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .cert-mobile-date {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
    }

    .cert-mobile-actions {
        display: flex;
        gap: 8px;
    }

    .cert-mobile-actions .btn-action {
        flex: 1;
        height: 40px;
    }

    /* Hide mobile-only elements on high resolution (Desktop) */
    .user-stats-summary-mobile,
    .user-actions-mobile,
    .user-avatar-mobile {
        display: none !important;
    }

    /* Responsive Improvements */
    @media (max-width: 991px) {
        .user-stats-summary-mobile {
            display: flex !important;
            font-size: 11px;
            color: #64748b;
            font-weight: 700;
            gap: 8px;
        }

        .user-header-actions {
            display: flex !important;
            margin-left: auto;
        }

        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .admin-container {
            padding: 12px 10px !important;
        }

        .user-card {
            margin-bottom: 10px;
            border-radius: 12px;
        }

        .user-header {
            display: grid !important;
            grid-template-areas: 
                "info actions" 
                "details details";
            grid-template-columns: 1fr auto;
            padding: 16px !important;
            height: auto !important;
            gap: 4px 12px !important;
            align-items: center !important;
        }

        .user-info-main { 
            grid-area: info; 
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            justify-content: flex-start !important;
        }
        
        .user-header-actions { 
            grid-area: actions;
        }

        .user-stats-summary-mobile { 
            grid-area: details;
            display: flex !important;
            align-items: center;
            gap: 8px;
            padding-top: 6px;
            border-top: 1px solid #f1f5f9;
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
        }

        /* Hide desktop-only elements */
        .user-col-avatar,
        .user-col-dni, 
        .user-stats,
        .table-responsive {
            display: none !important;
        }

        .cert-cards-mobile {
            display: flex;
        }

        .user-name {
            font-size: 16px !important;
            font-weight: 800 !important;
            max-width: 180px;
        }

        .user-avatar-mobile {
            display: inline-block !important; /* Make visible as requested */
            font-size: 16px;
            margin-right: 4px;
        }

        .user-dni {
            font-size: 11px !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            color: #64748b;
        }

        .collapse-icon {
            width: 22px !important;
            height: 22px !important;
        }

        .btn-user-delete {
            opacity: 1 !important;
            padding: 6px !important;
        }
    }

    @media (max-width: 576px) {
        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .stat-card:last-child {
            grid-column: 1 / -1;
            width: 50%;
            margin: 0 auto;
        }

        .stats-summary .stat-number {
            font-size: 16px !important;
        }

        .stats-summary .stat-label {
            font-size: 10px !important;
        }
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
                    <p>{{ $usuariosPorEmpresa->flatten(1)->count() }} usuarios registrados</p>
                </div>

                <!-- Stats Summary -->
                <div class="stats-summary">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-users-count">{{ $usuariosPorEmpresa->flatten(1)->count() }}</div>
                            <div class="stat-label">Usuarios</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-certs-count">{{ $usuariosPorEmpresa->flatten(1)->sum('total_certificados') }}</div>
                            <div class="stat-label">Certificados</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-vigentes-count" style="color: #059669;">{{ $usuariosPorEmpresa->flatten(1)->sum('vigentes_count') }}</div>
                            <div class="stat-label">Vigentes</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-expirados-count" style="color: #dc2626;">{{ $usuariosPorEmpresa->flatten(1)->sum('expirados_count') }}</div>
                            <div class="stat-label">Expirados</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-number" id="global-empresas-count" style="color: #3b82f6;">{{ $usuariosPorEmpresa->has('INDEPENDIENTE') ? $usuariosPorEmpresa->count() - 1 : $usuariosPorEmpresa->count() }}</div>
                            <div class="stat-label">Empresas</div>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-input" placeholder="Buscar por nombre o DNI..." onkeyup="filterUsers()">
                </div>

                <!-- Users List Grouped by Company -->
                <div id="users-list">
                    @forelse($usuariosPorEmpresa as $empresa => $grupo)
                    <div class="company-group collapsed" id="group-{{ Str::slug($empresa) }}">
                        <div class="company-header-toggle" onclick="toggleCompanyGroup('{{ Str::slug($empresa) }}')">
                            <h2>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #64748b;">
                                    <path d="M3 21h18M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7M4 17h16V4H4v13z"/>
                                </svg>
                                {{ $empresa }}
                                <span style="background: #f1f5f9; color: #64748b; font-size: 9px; padding: 1px 6px; border-radius: 20px; font-weight: 700;">{{ $grupo->count() }}</span>
                            </h2>
                            @if($empresa !== 'INDEPENDIENTE')
                            <div style="margin-left: auto; display: flex; align-items: center; gap: 4px;">
                                <button onclick="openBulkEditModal('{{ addslashes($empresa) }}', event)" style="background: none; border: none; color: #3b82f6; cursor: pointer; padding: 4px; display: flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 800; text-transform: none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    <span style="text-decoration: underline;">Editar</span>
                                </button>
                                <button onclick="confirmDeleteCompany('{{ addslashes($empresa) }}', event)" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center; opacity: 0.7; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7" title="Eliminar Empresa y Usuarios">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                            <svg class="company-chevron" style="width: 16px; height: 16px; color: #94a3b8; transition: transform 0.3s; margin-left: 8px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                            @else
                            <svg class="company-chevron" style="width: 16px; height: 16px; color: #94a3b8; transition: transform 0.3s; margin-left: auto;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                            @endif
                        </div>
                        
                        <div class="company-users-container">
                            @foreach($grupo as $usuario)
                        <div class="user-card" data-nombre="{{ strtolower($usuario['nombre']) }}" data-dni="{{ $usuario['dni'] }}" data-empresa="{{ strtolower($usuario['empresa'] ?? 'independiente') }}">
                            <div class="user-header" onclick="toggleUser(this)">
                                
                                <!-- Desktop only: Avatar -->
                                <div class="user-col-avatar">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($usuario['nombre'], 0, 1)) }}
                                    </div>
                                </div>

                                <!-- Name & Edit (Main Info) -->
                                <div class="user-info-main">
                                    <div class="user-avatar-mobile">
                                        <span style="font-weight: 800; color: #0f5f8c;">[{{ strtoupper(substr($usuario['nombre'], 0, 1)) }}]</span>
                                    </div>
                                    <h3 class="user-name">{{ $usuario['nombre'] }}</h3>
                                    
                                    <button onclick="openEditWorkerModal('{{ $usuario['dni'] }}', '{{ addslashes($usuario['nombre']) }}', event)" class="btn-edit-inline" title="Editar Datos">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                </div>

                                <!-- Desktop DNI -->
                                <div class="user-col-dni">
                                    <span class="user-dni">DNI: {{ $usuario['dni'] }}</span>
                                </div>

                                <!-- Desktop Stats -->
                                <div class="user-stats">
                                    @if($usuario['vigentes_count'] > 0)
                                        <span class="stat-badge vigente" style="margin: 0;">{{ $usuario['vigentes_count'] }} V</span>
                                    @endif
                                    @if($usuario['expirados_count'] > 0)
                                        <span class="stat-badge expirado" style="margin: 0;">{{ $usuario['expirados_count'] }} E</span>
                                    @endif
                                </div>

                                <!-- Mobile Details (Second row on mobile) -->
                                <div class="user-stats-summary-mobile">
                                    <span>DNI: {{ $usuario['dni'] }}</span>
                                    <span style="color: #059669;">({{ $usuario['vigentes_count'] }} V)</span>
                                    <span style="color: #dc2626;">({{ $usuario['expirados_count'] }} E)</span>
                                </div>

                                <!-- Actions (Delete & Chevron) -->
                                <div class="user-header-actions">
                                    <button class="btn-user-delete" title="Eliminar Usuario" onclick="confirmDeleteUser('{{ $usuario['dni'] }}', '{{ $usuario['nombre'] }}', event)">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                    <svg class="collapse-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>
                            </div>
                            <div class="user-content">
                                <div class="table-responsive">
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
                                                <td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">
                                                    Este usuario no tiene certificados registrados.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Mobile Certificate Cards -->
                                <div class="cert-cards-mobile">
                                    @forelse($usuario['certificados'] as $cert)
                                    @php
                                        $now = now()->setTimezone('America/Lima')->format('Y-m-d');
                                        $esVigente = $cert->fecha_vencimiento >= $now;
                                    @endphp
                                    <div class="cert-mobile-card" id="cert-card-mobile-{{ $cert->id }}">
                                        <div class="cert-mobile-title">{{ $cert->curso }}</div>
                                        
                                        <div class="cert-mobile-meta">
                                            <span class="cert-mobile-date">{{ $cert->fecha_emision->format('d/m/Y') }}</span>
                                            @if($esVigente)
                                                <span class="status-vigente" style="font-size: 11px;">Vigente</span>
                                            @else
                                                <span class="status-expirado" style="font-size: 11px;">Expirado</span>
                                            @endif
                                        </div>

                                        <div class="cert-mobile-actions-wrapper">
                                            @if($cert->drive_link)
                                                <a href="{{ $cert->drive_link }}" target="_blank" class="btn-action btn-view-drive-full">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                                    VER CERTIFICADO
                                                </a>
                                            @endif
                                            
                                            <div class="cert-mobile-actions">
                                                <button class="btn-action btn-edit" onclick="openEditModal({{ $cert->id }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                    Editar
                                                </button>
                                                <button class="btn-action btn-delete" onclick="confirmDelete({{ $cert->id }})">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    Borrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div style="text-align: center; padding: 20px; color: #64748b; font-size: 13px;">
                                        Sin certificados registrados.
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            </div>
                        </div>
                            @endforeach
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
                    <label class="form-label" style="font-weight: 800; text-transform: uppercase; font-size: 11px;">Editar Certificado</label>
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
            <button type="button" class="btn-secondary-red" onclick="closeEditModal()">Cancelar</button>
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
            <button type="button" class="btn-secondary-red" onclick="closeDeleteModal()">Cancelar</button>
            <button type="button" class="btn-danger" id="btn-confirm-delete" onclick="executeDelete()">Eliminar Definitivamente</button>
        </div>
    </div>
</div>

<script>
function toggleCompanyGroup(slug) {
    const group = document.getElementById(`group-${slug}`);
    if (group) {
        group.classList.toggle('collapsed');
    }
}

function toggleUser(header) {
    const card = header.closest('.user-card');
    card.classList.toggle('expanded');
}

function filterUsers() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const companyGroups = document.querySelectorAll('.company-group');
    
    companyGroups.forEach(group => {
        const cards = group.querySelectorAll('.user-card');
        let hasVisibleCards = false;
        
        cards.forEach(card => {
            const nombre = card.dataset.nombre;
            const dni = card.dataset.dni;
            const empresa = card.dataset.empresa;
            
            if (nombre.includes(search) || dni.includes(search) || empresa.includes(search)) {
                card.style.display = '';
                hasVisibleCards = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Hide/Show the entire company group based on visibility of its users
        group.style.display = hasVisibleCards ? '' : 'none';
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

// Company Delete Logic
let companyToDelete = null;

function confirmDeleteCompany(empresa, event) {
    if (event) event.stopPropagation();
    companyToDelete = empresa;
    document.getElementById('deleteCompanyModal').classList.remove('hidden');
    document.getElementById('delete-company-name-display').textContent = empresa;
}

function closeDeleteCompanyModal() {
    document.getElementById('deleteCompanyModal').classList.add('hidden');
    companyToDelete = null;
}

async function executeCompanyDelete() {
    if (!companyToDelete) return;
    
    const btn = document.getElementById('btn-confirm-company-delete');
    const originalText = btn.innerText;
    
    btn.disabled = true;
    btn.innerText = 'Eliminando Empresa...';

    try {
        const response = await fetch(`{{ config('app.url') }}/admin/api/empresas/eliminar`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ empresa: companyToDelete })
        });

        const data = await response.json();

        if (data.success) {
            const slug = companyToDelete.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            const companyGroup = document.getElementById(`group-${slug}`);
            
            if (companyGroup) {
                companyGroup.style.transition = 'all 0.4s';
                companyGroup.style.opacity = '0';
                companyGroup.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    companyGroup.remove();
                    if (document.querySelectorAll('.company-group').length === 0) {
                        location.reload();
                    }
                }, 400);
            }
            
            if (data.global_stats) {
                updateGlobalStats(data.global_stats);
            }

            closeDeleteCompanyModal();
        } else {
            alert(data.message || 'Error al eliminar la empresa');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de red al intentar eliminar la empresa');
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

// Consolidation of Worker Edit and Bulk Company Edit
function openEditWorkerModal(dni, nombre, event) {
    if (event) event.stopPropagation();
    document.getElementById('edit-worker-dni').value = dni;
    document.getElementById('edit-worker-nombre').value = nombre;
    const modal = document.getElementById('workerEditModal');
    modal.style.display = 'flex';
}

function closeEditWorkerModal() {
    document.getElementById('workerEditModal').style.display = 'none';
}

function openBulkEditModal(empresaActual, event) {
    if (event) event.stopPropagation();
    document.getElementById('bulk-empresa-actual-display').textContent = empresaActual;
    document.getElementById('bulk-empresa-actual').value = empresaActual;
    document.getElementById('bulk-empresa-nueva').value = empresaActual === 'Independiente' ? '' : empresaActual;
    const modal = document.getElementById('bulkCompanyEditModal');
    modal.style.display = 'flex';
}

function closeBulkEditModal() {
    document.getElementById('bulkCompanyEditModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const editWorkerForm = document.getElementById('editWorkerForm');
    if (editWorkerForm) {
        editWorkerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const dni = document.getElementById('edit-worker-dni').value;
            const nombre = document.getElementById('edit-worker-nombre').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Guardando...';

            try {
                const response = await fetch('/admin/api/trabajadores/actualizar', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ dni, nombre })
                });
                const data = await response.json();
                if (data.success) { location.reload(); }
                else { alert(data.message || 'Error al actualizar'); submitBtn.disabled = false; submitBtn.textContent = originalText; }
            } catch (error) { console.error('Error:', error); alert('Error de conexión'); submitBtn.disabled = false; submitBtn.textContent = originalText; }
        });
    }

    const bulkCompanyEditForm = document.getElementById('bulkCompanyEditForm');
    if (bulkCompanyEditForm) {
        bulkCompanyEditForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const empresaActual = document.getElementById('bulk-empresa-actual').value;
            const empresaNueva = document.getElementById('bulk-empresa-nueva').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Actualizando...';

            try {
                const response = await fetch('/admin/api/empresas/actualizar', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ empresa_actual: empresaActual, empresa_nueva: empresaNueva })
                });
                const data = await response.json();
                if (data.success) { location.reload(); }
                else { alert(data.message || 'Error al actualizar'); submitBtn.disabled = false; submitBtn.textContent = originalText; }
            } catch (error) { console.error('Error:', error); alert('Error de conexión'); submitBtn.disabled = false; submitBtn.textContent = originalText; }
        });
    }
});
</script>
</div>

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
            <button type="button" class="btn-secondary-red" onclick="closeDeleteUserModal()">Cancelar</button>
            <button type="button" class="btn-danger" id="btn-confirm-user-delete" onclick="executeUserDelete()" style="background: #dc2626;">Borrar Usuario y Todo</button>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de EMPRESA -->
<div id="deleteCompanyModal" class="modal hidden">
    <div class="modal-overlay" onclick="closeDeleteCompanyModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2 style="color: #dc2626;">Eliminar Empresa</h2>
            <button class="modal-close" onclick="closeDeleteCompanyModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="color: #1e293b; font-weight: 700; font-size: 15px; margin-bottom: 8px;">¿Eliminar la empresa <span id="delete-company-name-display"></span>?</p>
            <div style="background: #fff1f2; border-left: 4px solid #dc2626; padding: 12px; margin-bottom: 15px;">
                <p style="color: #991b1b; font-size: 12px; font-weight: 600;">
                    <i class="fas fa-exclamation-triangle"></i> ADVERTENCIA CRÍTICA: Se eliminarán TODOS los trabajadores y certificados asociados a esta empresa de forma definitiva.
                </p>
            </div>
            <p style="color: #64748b; font-size: 12px;">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary-red" onclick="closeDeleteCompanyModal()">Cancelar</button>
            <button type="button" class="btn-danger" id="btn-confirm-company-delete" onclick="executeCompanyDelete()" style="background: #dc2626;">Borrar Empresa y Todo su Personal</button>
        </div>
    </div>
</div>

<!-- Worker Edit Modal -->
<div id="workerEditModal" class="modal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="modal-content" style="background:#fff; padding:24px; border-radius:16px; width:400px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border: 2px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #3b82f6;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Editar Trabajador
            </h2>
            <button onclick="closeEditWorkerModal()" style="background:none; border:none; color:#64748b; cursor:pointer; padding:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        
        <form id="editWorkerForm">
            <input type="hidden" id="edit-worker-dni">
            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display:block; font-size:11px; font-weight:800; color:#64748b; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Nombre Completo</label>
                <input type="text" id="edit-worker-nombre" name="nombre" class="form-input" style="width:100%; padding:10px 14px; border:2px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none;" required>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn-secondary-red" onclick="closeEditWorkerModal()" style="flex:1;">Cancelar</button>
                <button type="submit" class="btn-primary" style="flex:2; background: #3b82f6; color: white; border: none; font-weight: 700; padding:10px; border-radius:10px; cursor:pointer;">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Company Edit Modal -->
<div id="bulkCompanyEditModal" class="modal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div class="modal-content" style="background:#fff; padding:24px; border-radius:16px; width:450px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border: 2px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 18px; font-weight: 800; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #3b82f6;"><path d="M3 21h18M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7M4 17h16V4H4v13z"/></svg>
                Editar Empresa
            </h2>
            <button onclick="closeBulkEditModal()" style="background:none; border:none; color:#64748b; cursor:pointer; padding:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        
        <form id="bulkCompanyEditForm">
            <input type="hidden" id="bulk-empresa-actual">
            <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px; margin-bottom: 16px; border-radius: 4px;">
                <p style="font-size: 12px; color: #1e40af; margin: 0; font-weight: 600;">
                    Se cambiará el nombre de la empresa para TODOS los trabajadores de:
                </p>
                <p style="font-size: 14px; font-weight: 800; color: #1e293b; margin: 4px 0 0;" id="bulk-empresa-actual-display"></p>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display:block; font-size:11px; font-weight:800; color:#64748b; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">Nuevo Nombre de Empresa</label>
                <input type="text" id="bulk-empresa-nueva" name="empresa_nueva" class="form-input" style="width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:10px; font-size:14px; outline:none;" placeholder="Ej: NUEVA EMPRESA S.A.C." required>
            </div>
            
            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn-secondary-red" onclick="closeBulkEditModal()" style="flex:1;">Cancelar</button>
                <button type="submit" class="btn-primary" style="flex:2; background: #3b82f6; color: white; border: none; font-weight: 700; padding:12px; border-radius:10px; cursor:pointer;">Actualizar Todo</button>
            </div>
        </form>
    </div>
</div>

@endsection

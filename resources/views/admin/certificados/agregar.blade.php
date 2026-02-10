@extends('layouts.admin')

@section('title', 'Agregar / Buscar Usuario - Admin GISEMIN')

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css', 'resources/css/admin/agregar.css'])
@endpush

@push('scripts')
@vite(['resources/js/admin/trabajador-search.js', 'resources/js/admin/cursos-autocomplete.js'])
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
                <a href="{{ route('admin.certificados.lista') }}" class="btn-nav-purple">Lista de Usuarios</a>
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

    <div class="admin-container">

        <div class="page-grid">
            <!-- Left Column -->
            <div class="left-column">
                <div id="main-side-card" class="card">
                    <!-- Search Section (Always visible) -->
                    <div class="search-section" style="margin-bottom: 0;">
                        <h3 style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 12px; letter-spacing: 0.5px;">Buscar por DNI</h3>
                        <div class="search-input-group">
                            <input type="text" id="dni-search" placeholder="Ingresa el DNI" autocomplete="off" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <button id="btn-buscar" class="btn-search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M10 2a8 8 0 0 1 6.32 12.9l4.39 4.38a1 1 0 0 1-1.42 1.42l-4.38-4.39A8 8 0 1 1 10 2zm0 2a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Profile Info Section (Hidden until search) -->
                    <div id="profile-info-section" class="hidden" style="margin-top: 16px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="profile-icon" style="width: 44px; height: 44px; flex-shrink: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div class="profile-info">
                                    <h4 id="profile-nombre" style="margin: 0; font-size: 14px; font-weight: 800; color: #1e293b; line-height: 1.2;"></h4>
                                    <div style="display: flex; gap: 8px; align-items: center; margin-top: 2px;">
                                        <p id="profile-dni" style="margin: 0; font-size: 11px; font-weight: 800; color: #64748b;"></p>
                                        <span style="color: #cbd5e1; font-size: 10px;">•</span>
                                        <p id="profile-empresa" style="margin: 0; font-size: 11px; font-weight: 800; color: #3b82f6;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="hidden-dni">
                    <input type="hidden" id="hidden-nombre">
                </div>
                
                <!-- Tarjeta de Vigentes -->
                <div id="history-vigentes-card" class="card hidden" style="max-height: 159px; display: flex; flex-direction: column; padding: 0; border: 1px solid #e2e8f0; border-top: 3px solid #10b981; background: white; margin-bottom: 12px;">
                    <div style="padding: 12px 14px; border-bottom: 1px solid #f1f5f9; background: rgba(16, 185, 129, 0.03); flex-shrink: 0;">
                        <h3 style="color: #065f46; font-size: 11px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; justify-content: space-between; letter-spacing: 0.5px; width: 100%;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="color: #10b981;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                Certificados Vigentes
                            </span>
                            <span id="count-vigentes-pill" style="background: #10b981; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 900; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);">0</span>
                        </h3>
                    </div>
                    
                    <div style="overflow-y: auto; flex: 1; padding: 12px 14px;">
                        <div id="list-vigentes" style="display: flex; flex-direction: column; gap: 6px;"></div>
                    </div>
                </div>

                <!-- Tarjeta de Vencidos -->
                <div id="history-vencidas-card" class="card hidden" style="max-height: 159px; display: flex; flex-direction: column; padding: 0; border: 1px solid #e2e8f0; border-top: 3px solid #ef4444; background: white; margin-bottom: 12px;">
                    <div style="padding: 12px 14px; border-bottom: 1px solid #f1f5f9; background: rgba(239, 68, 68, 0.03); flex-shrink: 0;">
                        <h3 style="color: #991b1b; font-size: 11px; font-weight: 800; text-transform: uppercase; margin: 0; display: flex; align-items: center; justify-content: space-between; letter-spacing: 0.5px; width: 100%;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="color: #ef4444;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                Vencidos
                            </span>
                            <span id="count-vencidas-pill" style="background: #fee2e2; color: #ef4444; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 900; border: 1px solid #fecaca;">0</span>
                        </h3>
                    </div>
                    
                    <div style="overflow-y: auto; flex: 1; padding: 12px 14px;">
                        <div id="list-vencidas" style="display: flex; flex-direction: column; gap: 6px;"></div>
                    </div>
                </div>

                <div id="register-user-section" class="card hidden" style="background: #fffbeb; border: 1px solid #fde68a; padding: 12px; gap: 0; max-height: 390px; overflow-y: auto;">
                    <div style="text-align: center; margin-bottom: 12px;">
                        <h3 style="color: #92400e; font-weight: 800; font-size: 14px; margin: 0 0 2px;">¡DNI no encontrado!</h3>
                        <div style="background: white; padding: 6px; border-radius: 8px; border: 1px solid #fbbf24; margin-bottom: 8px; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.05);">
                            <p style="font-size: 8px; color: #b45309; text-transform: uppercase; margin-bottom: 0; font-weight: 800; letter-spacing: 0.5px;">DNI PARA REGISTRO</p>
                            <input type="text" id="reg-dni-edit" style="width: 100%; border: none; text-align: center; font-size: 18px; font-weight: 900; color: #92400e; letter-spacing: 0px; padding: 0; background: transparent; outline: none;" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <p style="font-size: 11px; color: #92400e; line-height: 1.3; font-weight: 500; margin: 0;">Verifica el DNI e ingresa el nombre y empresa.</p>
                    </div>
                    <div class="registration-form-grid" style="display: grid; grid-template-columns: 1fr; gap: 10px; margin-bottom: 12px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label style="color: #92400e; font-size: 11px; margin-bottom: 4px;">Nombre Completo</label>
                            <input type="text" id="new-user-nombre" class="form-input" placeholder="Ej: Juan Pérez" style="border-color: #fcd34d; background: white; color: #92400e; padding: 8px 12px; font-size: 13px;" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                        </div>
                    </div>
                    <button id="btn-register-user" class="btn-submit-main" style="margin-top: 0; background: #fbbf24; color: #92400e; border: none; padding: 10px; font-size: 12px; box-shadow: 0 2px 8px rgba(251, 191, 36, 0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="margin-right: 6px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="12" y1="11" x2="12" y2="13"/><line x1="12" y1="16" x2="12" y2="16"/></svg>
                        REGISTRAR USUARIO
                    </button>
                    <button id="btn-cancel-register" class="btn-reset" style="margin-top: 8px; width:100%; border-color: #fcd34d; color: #92400e; background: rgba(255, 255, 255, 0.5); padding: 6px; font-size: 11px;">CANCELAR</button>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <div id="right-empty-state" class="empty-state-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 20px; opacity: 0.3;">
                        <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <p>Ingrese un DNI para ver el historial del usuario</p>
                </div>

                <div id="certificate-form-card" class="form-card hidden">
                    <div class="form-header">
                        <h2>Registrar Certificado</h2>
                        <p>Complete los detalles para asignar un nuevo certificado.</p>
                    </div>
                    
                    <div class="form-body">
                        <form action="{{ route('admin.certificados.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="nombre" id="form-nombre">
                            <input type="hidden" name="dni" id="form-dni">
                            
                            <div class="certificate-action-grid">
                                <!-- Left Column: Assignment and Details -->
                                <div class="form-column-left">
                                    <span class="section-label">Asignar Nuevo Certificado</span>
                                    <div class="selection-box" style="margin-bottom: 12px;">
                                        <div class="selection-box-header new">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                            Seleccionar Certificado
                                        </div>
                                        <div class="autocomplete-wrapper">
                                            <input type="text" name="curso" id="curso-input" class="form-input" placeholder="Buscar certificado..." required>
                                            <ul id="cursos-dropdown" class="custom-dropdown"></ul>
                                        </div>
                                        <p id="course-validation-msg" style="margin: 6px 0 0; font-size: 10px; font-weight: 600; color: #94a3b8; display: flex; align-items: center; gap: 4px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                            Rellena esto con un certificado válido
                                        </p>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 12px;">
                                        <label>Empresa (Se edita en la lista)</label>
                                        <div style="display: flex; gap: 8px; align-items: center;">
                                            <input type="text" name="empresa" id="form-empresa" class="form-input reg-empresa-sync" placeholder="Ej: GISEMIN S.A.C." readonly style="background: #f1f5f9; cursor: not-allowed; flex: 1;">
                                            <button type="button" id="btn-assign-company" class="btn-primary" style="display: none; padding: 10px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; white-space: nowrap; background: #0f5f8c; color: white; border: none; cursor: pointer;">ASIGNAR</button>
                                        </div>
                                    </div>

                                    <div class="form-row" style="margin-bottom: 12px;">
                                        <div class="form-group">
                                            <label>Fecha de Emisión</label>
                                            <input type="date" name="fecha_emision" class="form-input" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tiempo de Vigencia</label>
                                            <select name="duracion" class="form-input" required>
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ $i == 12 ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Mes' : 'Meses' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Link de Drive (Certificado)</label>
                                        <input type="url" name="drive_link" class="form-input" placeholder="https://drive.google.com/...">
                                    </div>
                                </div>

                                <!-- Right Column: Renewal Options -->
                                <div class="form-column-right">
                                    <span class="section-label">Renovación Rápida</span>
                                    <div class="selection-box" style="min-height: 150px; background: #f8fafc;">
                                        <div class="selection-box-header renew">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38"/></svg>
                                            Renovar Vencidas
                                        </div>
                                        <div id="renew-options-list"></div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="btn-submit-certificate" class="btn-submit-main" style="margin-top: 24px; padding: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Registrar Certificado
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

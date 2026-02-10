@extends('layouts.admin')

@section('title', 'Reclamaciones - GISEMIN Admin')

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css'])
<style>
    .reclamaciones-container {
        padding: 16px 24px; /* Minimal padding */
        max-width: 1400px;
        margin: 0 auto;
        zoom: 0.91; /* +11% from 0.82 */
    }

    .page-header {
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
        position: relative;
        padding-left: 14px;
        display: flex;
        align-items: center;
    }
    
    .page-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: linear-gradient(to bottom, #3b82f6, #06b6d4);
        border-radius: 4px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        margin-left: auto;
    }

    /* Stats Grid */
    .stats-grid {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }

    /* Stabilized Compact Card */
    .stat-card {
        flex: 1 1 0px; 
        width: 0;
        background: white;
        border-radius: 10px;
        padding: 0 12px;
        height: 50px; /* Reduced height */
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .stat-num-box {
        background: transparent !important;
        min-width: 24px;
        font-size: 31px; /* +12% from 28px */
        font-weight: 800;
        line-height: 1;
        padding: 0;
        margin: 0;
        border-radius: 0;
        order: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-label {
        font-size: 16px; /* +12% from 14px */
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1;
        margin: 0;
        padding-top: 2px;
        order: 2;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    /* Number Colors based on type */
    .stat-card.total .stat-num-box { color: #1d4ed8; }
    .stat-card.pendiente .stat-num-box { color: #d97706; }
    .stat-card.resuelto .stat-num-box { color: #059669; }

    /* Tabs Container */
    .tabs-container {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 10px;
        margin-bottom: 16px;
        position: relative;
    }

    .tab-btn {
        width: 140px; /* Narrower tabs */
        height: 36px; /* Shorter tabs */
        padding: 0;
        border: none;
        background: transparent;
        color: #64748b;
        border-radius: 7px;
        cursor: pointer;
        font-weight: 700;
        font-size: 16px; /* +12% from 14px */
        position: relative;
        z-index: 2;
        transition: all 0.2s;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .tab-btn.active {
        background: #0f5f8c;
        color: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .tab-btn.active[onclick*="'all'"] { background: #4f46e5 !important; color: white !important; }
    .tab-btn.active[onclick*="'pendiente'"] { background: #f59e0b !important; color: white !important; }
    .tab-btn.active[onclick*="'resuelto'"] { background: #10b981 !important; color: white !important; }

    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        min-height: auto; /* Shrink to fit content exactly */
        display: flex;
        flex-direction: column;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        flex: 1;
    }

    th {
        text-align: left;
        padding: 0 15px; /* Increased from 10px */
        height: 66px; /* Increased by ~9% (60px -> 66px) */
        background: #f8fafc;
        font-size: 15px; /* +12% from 13px */
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        line-height: 1;
    }

    /* MICRO COMPACT ROW HEIGHT (Increased by ~9%) */
    tbody tr {
        height: 66px; /* 60px -> 66px */
    }

    td {
        padding: 0 15px; /* Increased from 10px for better separation */
        border-bottom: 1px solid #e2e8f0;
        font-size: 16px; /* +12% from 14px */
        color: #334155;
        vertical-align: middle;
        white-space: nowrap;
        overflow: visible; /* Changed to visible to help see content */
        text-overflow: ellipsis;
        line-height: 1;
    }

    /* Extra padding for ID column to separate from border */
    td:first-child, th:first-child {
        padding-left: 24px;
    }

    tr:last-child td { border-bottom: none; }
    
    tr.reclamacion-row[data-status="pendiente"] { background-color: #fffbeb; }
    tr.reclamacion-row[data-status="resuelto"] { background-color: #f0fdf4; }
    tr.reclamacion-row:hover { filter: brightness(0.98); }

    tr.reclamacion-row[data-status="pendiente"] td:first-child { box-shadow: inset 3px 0 0 #f59e0b; }
    tr.reclamacion-row[data-status="resuelto"] td:first-child { box-shadow: inset 3px 0 0 #10b981; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px; /* Increased gap */
        padding: 4px 12px; /* Increased padding */
        border-radius: 12px;
        font-size: 14px; /* Increased from 12px */
        font-weight: 700;
        background: white;
        height: 28px; /* Increased from 18px */
    }
    .status-badge.pendiente { color: #b45309; border: 1px solid #fcd34d; }
    .status-badge.resuelto { color: #047857; border: 1px solid #6ee7b7; }
    .status-dot { width: 4px; height: 4px; border-radius: 50%; }
    .status-badge.pendiente .status-dot { background: #f59e0b; }
    .status-badge.resuelto .status-dot { background: #10b981; }

    .btn-view {
        padding: 6px 16px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
    }

    .btn-view:hover {
        background: #1d4ed8;
    }
    
    .empty-state {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 500;
        padding: 10px;
    }
    
    @media (max-width: 1024px) {
        .stats-grid { flex-wrap: wrap; }
        .stat-card { min-width: 45%; }
    }

    @media (max-width: 991px) {
        .reclamaciones-container {
            padding: 12px 8px !important;
            zoom: 1 !important; /* Reset zoom on mobile */
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 4px !important;
        }

        .page-title {
            font-size: 20px !important;
        }

        .page-subtitle {
            margin-left: 0 !important;
            font-size: 12px !important;
        }

        .stats-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
        }

        .stat-card {
            min-width: 0 !important;
            width: 100% !important;
            padding: 0 10px !important;
            height: 44px !important;
        }

        .stat-num-box {
            font-size: 24px !important;
        }

        .stat-label {
            font-size: 13px !important;
        }

        .stat-card.total {
            grid-column: 1 / -1;
        }

        .tabs-container {
            display: flex !important;
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            padding: 4px !important;
        }

        .tab-btn {
            flex: 1 !important;
            min-width: 100px !important;
            font-size: 14px !important;
            height: 32px !important;
        }

        /* Card Layout for Table */
        .table-container {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        table {
            display: block !important;
            width: 100% !important;
        }

        thead {
            display: none !important;
        }

        tbody {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
        }

        .reclamacion-row {
            display: block !important;
            height: auto !important;
            background: white !important;
            border: 1px solid #f1f5f9 !important;
            border-radius: 16px !important;
            padding: 18px !important;
            position: relative !important;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02) !important;
            margin-bottom: 16px !important;
        }

        td {
            display: block !important;
            padding: 0 !important;
            border: none !important;
            margin-bottom: 10px !important;
            white-space: normal !important;
            width: 100% !important;
            height: auto !important;
        }

        td:first-child {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            margin-bottom: 14px !important;
            padding-bottom: 12px !important;
            border-bottom: 1px dashed #e2e8f0 !important;
            box-shadow: none !important;
        }

        /* Move Date to top right near ID */
        td:nth-child(2) {
            position: absolute !important;
            top: 18px !important;
            right: 18px !important;
            width: auto !important;
            margin-bottom: 0 !important;
            font-size: 11px !important;
            color: #94a3b8 !important;
            font-weight: 500 !important;
        }

        td:nth-child(2)::before {
            content: "";
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' /%3E%3C/svg%3E");
            background-size: contain;
            display: inline-block;
            width: 12px;
            height: 12px;
            vertical-align: middle;
            margin-right: 4px;
            margin-top: -2px;
        }

        .id-cell {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 2px 10px;
            border-radius: 6px;
        }

        .reclamacion-id {
            font-weight: 800;
            color: #475569;
            font-size: 12px;
        }

        /* Name Styling */
        td:nth-child(3) {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 6px !important;
            letter-spacing: -0.3px !important;
            padding-right: 120px !important; /* Avoid overlap with date */
        }

        /* DNI Styling */
        td:nth-child(4) {
            font-size: 13px !important;
            color: #64748b !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            margin-bottom: 12px !important;
        }

        td:nth-child(4)::before {
            content: "";
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0a1 1 0 011-1h2a1 1 0 011 1v1m-4 0h4' /%3E%3C/svg%3E");
            background-size: contain;
            width: 14px;
            height: 14px;
            display: inline-block;
        }

        /* Status Badge */
        td:nth-child(5) {
            margin-bottom: 4px !important;
        }

        .status-badge {
            height: 24px !important;
            padding: 0 12px !important;
            font-size: 12px !important;
            border-radius: 20px !important;
        }

        /* Actions - Fluid Button centered with borders */
        td:last-child {
            margin-bottom: 0 !important;
            margin-top: 18px !important;
            padding: 16px 0 0 0 !important;
            border-top: 1px solid #f1f5f9 !important;
            border-bottom: none !important;
            text-align: center !important;
        }

        .btn-view {
            width: 100% !important;
            height: 44px !important;
            border-radius: 12px !important;
            background: #2563eb !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            justify-content: center !important; /* Ensure perfect centering */
            display: flex !important;
            align-items: center !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr !important;
        }
        .stat-card.total {
            grid-column: auto;
        }
        
        td:nth-child(3) {
            padding-right: 0 !important;
        }
        
        td:nth-child(2) {
            position: static !important;
            margin-bottom: 8px !important;
            background: #fdf2f2; /* Subtle bg if forced to stack */
            padding: 2px 8px !important;
            border-radius: 4px !important;
            display: inline-block !important;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
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
                <a href="{{ route('admin.certificados.gestionar') }}" class="btn-nav-success">Gestionar Certificados</a>
                <a href="{{ route('certificados') }}" class="btn-nav-orange">Ver Certificados Públicos</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form"> @csrf <button type="submit" class="btn-logout">Cerrar Sesión</button> </form>
            </div>
        </div>
    </nav>

<div class="reclamaciones-container">
    <div class="page-header">
        <h1 class="page-title">Libro de Reclamaciones</h1>
        <p class="page-subtitle">Gestiona todas las reclamaciones recibidas de los usuarios</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-num-box">{{ $stats['total'] }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-card pendiente">
            <div class="stat-num-box">{{ $stats['pendientes'] }}</div>
            <div class="stat-label">Pendientes</div>
        </div>
        <div class="stat-card resuelto">
            <div class="stat-num-box">{{ $stats['leidos'] }}</div>
            <div class="stat-label">Leídos</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-container">
        <button class="tab-btn active" onclick="filterTable('all')">Todos</button>
        <button class="tab-btn" onclick="filterTable('pendiente')">Por leer</button>
        <button class="tab-btn" onclick="filterTable('resuelto')">Leídos</button>
    </div>

    <!-- Table -->
    <div class="table-container">
        @if($reclamaciones->count() > 0)
        <table>
            <colgroup>
                <col style="width: 80px;"> <!-- ID -->
                <col style="width: 200px;"> <!-- Fecha (Widened) -->
                <col style="width: 250px;"> <!-- Nombre -->
                <col style="width: 150px;"> <!-- DNI (Widened slightly) -->
                <col style="width: 140px;"> <!-- Estado -->
                <col style="width: 100px;"> <!-- Acción -->
            </colgroup>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FECHA</th>
                    <th>NOMBRE</th>
                    <th>DNI</th>
                    <th>ESTADO</th>
                    <th style="text-align: center;">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reclamaciones as $reclamacion)
                    <tr class="reclamacion-row" data-status="{{ $reclamacion->estado }}">
                        <td>
                            <div class="id-cell">
                                <span class="reclamacion-id">#{{ $reclamacion->id }}</span>
                            </div>
                        </td>
                        <td>{{ $reclamacion->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $reclamacion->nombre_completo }}</td>
                        <td>{{ $reclamacion->dni }}</td>
                        <td>
                            <div class="status-cell">
                                <span class="status-badge {{ $reclamacion->estado }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($reclamacion->estado_label) }}
                                </span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('admin.reclamaciones.show', $reclamacion->id) }}" class="btn-view">
                                Ver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            Sin reclamaciones
        </div>
        @endif
    </div>
</div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initial Filter
        filterTable('all');
    });

    function filterTable(status) {
        const allRows = document.querySelectorAll('.reclamacion-row');
        
        // Update active tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('onclick').includes(`'${status}'`)) {
                btn.classList.add('active');
            }
        });

        // Simple Layout Toggle
        allRows.forEach(row => {
            if(status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    }
</script>
@endpush
@endsection

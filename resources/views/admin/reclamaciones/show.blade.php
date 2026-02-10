@extends('layouts.admin')

@section('title')
Reclamación #{{ $reclamacion->id }} - GISEMIN Admin
@endsection

@push('styles')
@vite(['resources/css/landing.css', 'resources/css/admin/admin.css'])
<style>
    /* Sobrescribir estilos globales si es necesario */
    .admin-content {
        max-width: 100% !important;
        padding: 0 !important;
    }

    .reclamacion-detail {
        padding: 20px;
        width: 100%;
        max-width: 64%; /* Aumentado un 28% respecto al 50% anterior */
        margin: 0 auto;
    }
    
    /* ... (estilos del botón back) ... */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px; /* Más compacto */
        background: #0f5f8c;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
        margin-bottom: 16px;
    }

    .btn-back:hover {
        background: #0d4a6f;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    /* ... (resto de estilos header/body) ... */
    .detail-header {
        padding: 10px 16px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h1 {
        font-size: 18px; /* Un poco más pequeño */
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .detail-header .date {
        color: #64748b;
        font-size: 13px;
    }

    .detail-body {
        padding: 20px; /* Reducido de 24px */
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .info-group {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .info-group.full-width {
        grid-column: 1 / -1;
    }

    .info-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0; /* Quitamos espaciado extra */
    }

    .info-value {
        font-size: 15px;
        color: #1e293b;
        line-height: 1.4;
    }

    .info-value.large {
        background: #f8fafc;
        padding: 14px; /* Reducido */
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 15px;
    }

    .section-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 24px 0; /* Reducido */
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }

    .status-section {
        background: white;
        padding: 12px 16px; 
        border-radius: 50px; /* Estilo cápsula */
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-label {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px; /* Reducido un poco */
        border-radius: 30px;
        font-size: 14px;
        font-weight: 700;
    }

    /* ... badges colors ... */
    .status-badge.pendiente {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.resuelto {
        background: #d1fae5;
        color: #065f46;
    }

    .btn-mark-read {
        padding: 8px 20px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 30px; /* Redondeado completo */
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-mark-read:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
    }

    /* ... alert/media queries ... */
    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .btn-delete {
        padding: 8px 20px;
        background: transparent;
        color: #ef4444;
        border: 1px solid #ef4444;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-delete:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #dc2626;
    }

    @media (max-width: 991px) {
        .reclamacion-detail {
            max-width: 100% !important;
            padding: 12px 10px !important;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 4px !important;
        }

        .detail-header h1 {
            font-size: 16px !important;
        }

        .detail-body {
            padding: 16px !important;
        }

        .section-title {
            font-size: 14px !important;
            margin-bottom: 10px !important;
        }

        .info-grid {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        .info-value {
            font-size: 14px !important;
        }

        .info-value.large {
            padding: 10px !important;
        }

        .status-section {
            flex-direction: column !important;
            border-radius: 12px !important;
            padding: 16px !important;
            gap: 16px !important;
        }

        .status-info {
            flex-direction: column !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .btn-mark-read {
            width: 100% !important;
            height: 46px !important;
            background: #2563eb !important;
            color: white !important;
            border-radius: 12px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
        }

        .btn-delete {
            width: 100% !important;
            height: 46px !important;
            background: #fef2f2 !important;
            color: #ef4444 !important;
            border: 1px solid #fca5a5 !important;
            border-radius: 12px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-top: 10px;
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
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

<div class="reclamacion-detail">
    <a href="{{ route('admin.reclamaciones.index') }}" class="btn-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Volver a la lista
    </a>

    <div class="detail-card">
        <div class="detail-header">
            <h1>Reclamación #{{ $reclamacion->id }}</h1>
            <span class="date">{{ $reclamacion->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="detail-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <h3 class="section-title">Datos del Reclamante</h3>
            <div class="info-grid">
                <div class="info-group">
                    <span class="info-label">Nombre Completo</span>
                    <span class="info-value">{{ $reclamacion->nombre_completo }}</span>
                </div>
                <div class="info-group">
                    <span class="info-label">DNI</span>
                    <span class="info-value">{{ $reclamacion->dni }}</span>
                </div>
                <div class="info-group">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $reclamacion->telefono }}</span>
                </div>
                <div class="info-group">
                    <span class="info-label">Correo Electrónico</span>
                    <span class="info-value">{{ $reclamacion->email }}</span>
                </div>
            </div>

            <div class="section-divider"></div>

            <h3 class="section-title">Detalle de la Reclamación</h3>
            <div class="info-grid">
                <div class="info-group full-width">
                    <span class="info-label">Descripción del Problema</span>
                    <span class="info-value large">{{ $reclamacion->detalle_reclamo }}</span>
                </div>
                <div class="info-group full-width">
                    <span class="info-label">Solución Esperada</span>
                    <span class="info-value large">{{ $reclamacion->pedido }}</span>
                </div>
            </div>

            <div class="section-divider"></div>

            <div class="status-section">
                <div class="status-info">
                    <div class="status-label">Estado Actual:</div>
                    <span class="status-badge {{ $reclamacion->estado == 'resuelto' ? 'resuelto' : 'pendiente' }}">
                        {{ $reclamacion->estado == 'resuelto' ? 'Leído' : 'Por leer' }}
                    </span>
                </div>

                <div class="actions" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @if($reclamacion->estado != 'resuelto')
                    <button id="btnMarkRead" class="btn-mark-read">Marcar como leído</button>
                    @endif
                    
                    <button id="btnDelete" class="btn-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
    const btnMarkRead = document.getElementById('btnMarkRead');
    const btnDelete = document.getElementById('btnDelete');

    if (btnMarkRead) {
        btnMarkRead.addEventListener('click', async function() {
            try {
                const response = await fetch('/api/reclamaciones/{{ $reclamacion->id }}/status', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ 
                        estado: 'resuelto',
                        respuesta: 'Marcado como leído'
                    })
                });
                
                const data = await response.json();
                if (data.success) location.reload();
            } catch (error) {
                console.error('Error:', error);
            }
        });
    }

    if (btnDelete) {
        btnDelete.addEventListener('click', async function() {
            if (!confirm('¿Estás seguro de que deseas eliminar esta reclamación? Esta acción no se puede deshacer.')) return;

            try {
                const response = await fetch('/api/reclamaciones/{{ $reclamacion->id }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                if (data.success) {
                    window.location.href = "{{ route('admin.reclamaciones.index') }}";
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    }
</script>
@endpush
@endsection

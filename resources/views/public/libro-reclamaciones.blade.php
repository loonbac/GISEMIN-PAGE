@extends('layouts.public')

@section('title', 'Libro de Reclamaciones - GISEMIN')

@push('styles')
    @vite(['resources/css/libro-reclamaciones.css', 'resources/css/libro-reclamaciones-navbar.css'])
@endpush

@push('scripts')
    @vite(['resources/js/libro-reclamaciones-navbar.js'])
@endpush

@section('content')
<div class="complaints-book-container">
    <div class="book-header">
        <h1>LIBRO DE RECLAMACIONES</h1>
    </div>

    <div class="form-content">
        <div class="company-info-row">
            <div class="company-details">
                <p class="company-name">GISEMIN CONSULTORES S.A.C.</p>
                <p class="company-ruc">RUC: 20602886777</p>
            </div>
            <div class="claim-info">
                <div class="info-item">
                    <span class="info-label">FECHA</span>
                    <span class="info-value">{{ date('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <form action="/libro-reclamaciones" method="POST" class="complaint-form" autocomplete="off">
            @csrf
            
            <!-- Section 1: Datos del Reclamante -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">1</span>
                    <span class="section-text">Datos del Reclamante</span>
                </div>
                
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="nombre_completo">Nombre Completo <span class="required">*</span></label>
                        <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" required placeholder="Ingrese sus nombres y apellidos completos" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                        @error('nombre_completo') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="dni">DNI <span class="required">*</span></label>
                        <input type="text" id="dni" name="dni" value="{{ old('dni') }}" required placeholder="Ingrese su DNI" maxlength="8" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8)">
                        @error('dni') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono <span class="required">*</span></label>
                        <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required placeholder="Ej: 987654321" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('telefono') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="ejemplo@correo.com">
                        @error('email') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Detalle de la Reclamación -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">2</span>
                    <span class="section-text">Detalle de la Reclamación</span>
                </div>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="detalle_reclamo">Descripción del Problema <span class="required">*</span></label>
                        <textarea id="detalle_reclamo" name="detalle_reclamo" rows="5" required placeholder="Describa detalladamente el problema: qué ocurrió, cuándo, con qué servicio está relacionado y cualquier otra información relevante...">{{ old('detalle_reclamo') }}</textarea>
                        @error('detalle_reclamo') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="pedido">Solución Esperada <span class="required">*</span></label>
                        <textarea id="pedido" name="pedido" rows="3" required placeholder="Indique la solución que espera recibir de nuestra parte...">{{ old('pedido') }}</textarea>
                        @error('pedido') <span class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="success-banner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="form-actions">
                <a href="{{ route('home') }}" class="btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"></path><path d="M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                    Enviar Reclamación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

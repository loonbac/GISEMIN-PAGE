@extends('layouts.admin')

@section('title', 'Iniciar Sesión - GISEMIN')

@push('styles')
@vite('resources/css/admin/login.css')
@endpush

@section('content')
<div class="login-container">
    <!-- Triángulo superior izquierdo con borde -->
    <div class="triangle-top"></div>
    
    <!-- Logo superior derecho -->
    <div class="header-logo">
        <img src="{{ asset('images/logo.svg') }}" alt="GISEMIN" class="header-logo-icon">
        <span class="header-logo-text">GISEMIN CONSULTORES</span>
    </div>

    <div class="login-form-side">
        <!-- Triángulo inferior derecho con borde -->
        <div class="triangle-bottom"></div>
        
        <main class="login-content">
            <div class="login-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="GISEMIN Logo" class="logo-image">
            </div>
            <p class="subtitle">BIENVENIDO</p>
            <h1>Panel Administrativo</h1>

            <form id="login-form" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="admin@gisemin.com" value="{{ old('email') }}" required>
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <span class="input-icon toggle-password" id="toggle-password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-primary btn-full">Ingresar al Panel</button>
            </form>

            <div class="back-to-site">
                <a href="{{ route('home') }}" class="btn-back">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Volver al sitio web
                </a>
            </div>
        </main>
    </div>

    <div class="login-image-side"></div>
</div>

@push('scripts')
<script>
    document.getElementById('toggle-password').addEventListener('click', function() {
        const password = document.getElementById('password');
        const isPassword = password.type === 'password';
        password.type = isPassword ? 'text' : 'password';
        
        this.innerHTML = isPassword ? 
            `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
                <line x1="1" y1="1" x2="23" y2="23" />
            </svg>` : 
            `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                <circle cx="12" cy="12" r="3" />
            </svg>`;
    });
</script>
@endpush
@endsection

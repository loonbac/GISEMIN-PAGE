<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Verifique certificados de trabajadores capacitados por GISEMIN Consultores. Busqueda por DNI, nombre o codigo del certificado.">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="#0F5F8C">
    <link rel="canonical" href="https://www.gisemin.com/certificados">
    <link rel="alternate" hreflang="es-PE" href="https://www.gisemin.com/certificados">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GISEMIN Consultores">
    <meta property="og:url" content="https://www.gisemin.com/certificados">
    <meta property="og:title" content="Verificar Certificados - GISEMIN Consultores">
    <meta property="og:description" content="Verifique certificados por DNI, nombre o codigo. Consulte validez y vigencia en linea.">
    <meta property="og:image" content="https://www.gisemin.com/images/logo.svg">
    <meta property="og:locale" content="es_PE">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Verificar Certificados - GISEMIN Consultores">
    <meta name="twitter:description" content="Verifique certificados por DNI, nombre o codigo. Consulte validez y vigencia en linea.">
    <meta name="twitter:image" content="https://www.gisemin.com/images/logo.svg">
    <title>Verificar Certificados - GISEMIN Consultores</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    @vite(['resources/css/certificados.css', 'resources/js/certificados.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @verbatim
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "GISEMIN Consultores",
            "url": "https://www.gisemin.com/",
            "logo": "https://www.gisemin.com/images/logo.svg"
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Verificar Certificados",
            "url": "https://www.gisemin.com/certificados",
            "isPartOf": {
                "@type": "WebSite",
                "name": "GISEMIN Consultores",
                "url": "https://www.gisemin.com/"
            }
        }
    </script>
    @endverbatim
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="{{ route('home') }}" class="logo">
                    <img src="images/logo.svg" alt="GISEMIN Logo" class="logo-image">
                    <div class="logo-text">
                        <span class="logo-title">GISEMIN</span>
                        <span class="logo-subtitle">Consultores</span>
                    </div>
                </a>
                
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('home') }}#nosotros">Nosotros</a></li>
                    <li><a href="{{ route('home') }}#servicios">Servicios</a></li>
                </ul>

                <button class="nav-toggle" id="navToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1>Verificación de <span class="gradient-text">Certificados</span></h1>
            <p class="hero-description">Consulte la validez y autenticidad de los certificados emitidos por GISEMIN Consultores. Ingrese el DNI o nombre del trabajador.</p>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-wrapper">
                <div class="search-card">
                    <div class="search-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="searchInput" 
                        class="search-input" 
                        placeholder="Ingrese su DNI..."
                        autocomplete="off"
                    >
                    <button id="searchBtn" class="search-btn">
                        <span>Buscar</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                

            </div>

            <!-- Results Area -->
            <div id="resultsArea" class="results-area">
                <!-- Los resultados se mostrarán aquí dinámicamente -->
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number" data-count="15000">0</span>
                        <span class="stat-label">Certificados Emitidos</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number" data-count="8500">0</span>
                        <span class="stat-label">Trabajadores Capacitados</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number" data-count="250">0</span>
                        <span class="stat-label">Empresas Atendidas</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number" data-count="45">0</span>
                        <span class="stat-label">Cursos Disponibles</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="info-section">
        <div class="container">
            <div class="info-header">
                <h2>¿Cómo funciona?</h2>
                <p>Verificar la autenticidad de un certificado es simple y rápido</p>
            </div>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-step">1</div>
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3>Ingrese los datos</h3>
                    <p>Escriba el DNI, nombre del trabajador o código del certificado en el buscador.</p>
                </div>
                <div class="info-card">
                    <div class="info-step">2</div>
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3>Revise los resultados</h3>
                    <p>Visualice todos los certificados asociados con la información de cursos y fechas.</p>
                </div>
                <div class="info-card">
                    <div class="info-step">3</div>
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3>Verifique la validez</h3>
                    <p>Confirme que el certificado está vigente y fue emitido oficialmente por GISEMIN.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section footer-brand">
                    <div class="footer-logo">
                        <img src="images/logo.svg" alt="Logo GISEMIN">
                        <div class="logo-text">
                            <h3>GISEMIN</h3>
                            <span>Consultores</span>
                        </div>
                    </div>
                    <p>Protegemos tu negocio, cuidamos a tu gente. Expertos en Seguridad y Salud en el Trabajo.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="WhatsApp">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('home') }}#nosotros">Nosotros</a></li>
                        <li><a href="{{ route('home') }}#servicios">Servicios</a></li>
                        <li><a href="{{ route('certificados') }}">Certificados</a></li>
                        <li><a href="{{ route('home') }}#contacto">Contacto</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Servicios SST</h4>
                    <ul>
                        <li><a href="{{ route('home') }}#servicios">Capacitaciones Obligatorias</a></li>
                        <li><a href="{{ route('home') }}#servicios">IPERC</a></li>
                        <li><a href="{{ route('home') }}#servicios">Trabajos de Alto Riesgo</a></li>
                        <li><a href="{{ route('home') }}#servicios">Primeros Auxilios</a></li>
                        <li><a href="{{ route('home') }}#servicios">Ergonomía</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Contacto</h4>
                    <ul class="footer-contact">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"></path>
                            </svg>
                            <a href="mailto:contacto@gisemin.com">contacto@gisemin.com</a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"></path>
                            </svg>
                            <a href="tel:+51937631988">937 631 988 - José Luis Perales</a>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"></path>
                            </svg>
                            <a href="tel:+51929003598">929 003 598 - Jasmine Luna</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 GISEMIN Consultores. Todos los derechos reservados.</p>
                <div class="footer-links">
                    <a href="#">Política de Privacidad</a>
                    <span>|</span>
                    <a href="#">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

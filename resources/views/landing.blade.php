<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, viewport-fit=cover">
    <meta name="description" content="GISEMIN Consultores: Seguridad y Salud Ocupacional, Calidad, Medio Ambiente y Responsabilidad Social. Implementación ISO 9001, 14001, 45001 en Perú.">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="#0F5F8C">
    <link rel="canonical" href="https://www.gisemin.com/">
    <link rel="alternate" hreflang="es-PE" href="https://www.gisemin.com/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GISEMIN Consultores">
    <meta property="og:url" content="https://www.gisemin.com/">
    <meta property="og:title" content="GISEMIN Consultores - Consultoria Integral en Sistemas de Gestion ISO">
    <meta property="og:description" content="Seguridad y Salud Ocupacional, Calidad, Medio Ambiente y Responsabilidad Social. Implementacion ISO 9001, 14001, 45001.">
    <meta property="og:image" content="https://www.gisemin.com/images/logo.svg">
    <meta property="og:locale" content="es_PE">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="GISEMIN Consultores - Consultoria Integral en Sistemas de Gestion ISO">
    <meta name="twitter:description" content="Seguridad y Salud Ocupacional, Calidad, Medio Ambiente y Responsabilidad Social. Implementacion ISO 9001, 14001, 45001.">
    <meta name="twitter:image" content="https://www.gisemin.com/images/logo.svg">
    <title>GISEMIN Consultores - Consultoria Integral en Sistemas de Gestion ISO</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    @vite(['resources/css/landing.css', 'resources/js/landing.js', 'resources/js/services-rotation.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            "@type": "WebSite",
            "name": "GISEMIN Consultores",
            "url": "https://www.gisemin.com/"
        }
    </script>
    @endverbatim
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <img src="images/logo.svg" alt="GISEMIN Logo" class="logo-image">
                    <div class="logo-text">
                        <span class="logo-title">GISEMIN</span>
                        <span class="logo-subtitle">Consultores</span>
                    </div>
                </div>
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#mision-vision">Misión y Visión</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="{{ route('certificados') }}">Certificados</a></li>
                    <li><a href="#contacto" class="btn-contact">Contacto</a></li>
                    <li>
                        <a href="https://wa.me/51937631988" target="_blank" class="btn-whatsapp">
                            <span class="whatsapp-icon-wrapper">
                                <span class="whatsapp-pulse"></span>
                                <span class="whatsapp-pulse delay"></span>
                                <span class="whatsapp-icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="whatsapp-text">+51 937 631 988</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <!-- Background Slider -->
        <div class="hero-slider">
            <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=1600&q=80');" aria-label="Sostenibilidad y Medio Ambiente"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=1600&q=80');" aria-label="Seguridad en Construcción"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1600&q=80');" aria-label="Industria y Minería"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1600&q=80');" aria-label="Capacitación y Equipo"></div>
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1600&q=80');" aria-label="Consultoría y Gestión"></div>
        </div>
        
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <h1 class="hero-title">Consultoria Integral en <span class="text-highlight">Seguridad</span>, <span class="text-highlight">Gestion</span> y <span class="text-highlight">Sostenibilidad</span> Empresarial</h1>
                <p class="hero-subtitle">Impulsamos la eficiencia operativa, protegemos a las personas y fortalecemos la sostenibilidad de su organización</p>
                <div class="hero-cta">
                    <a href="#servicios" class="btn btn-primary">Explorar Servicios</a>
                    <a href="#contacto" class="btn btn-secondary">Contactar</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="nosotros">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-header">
                    <h2>Acerca de <span class="text-highlight">Nosotros</span></h2>
                </div>
                
                <div class="about-grid">
                    <div class="about-content">
                        <p class="about-description">Somos un socio estratégico especializado en integrar <span class="text-highlight">Seguridad</span>, <span class="text-highlight">Salud</span>, <span class="text-highlight">Calidad</span>, <span class="text-highlight">Medio Ambiente</span> y <span class="text-highlight">Responsabilidad Social</span>, transformando el cumplimiento normativo en ventajas competitivas que reducen riesgos y costos, y fortalecen la sostenibilidad y reputación corporativa.</p>
                        
                        <div class="about-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14,2 14,8 20,8"></polyline>
                                        <path d="M9 15l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <h4>{{ $totalCursos }}+</h4>
                                    <p>Certificados Disponibles</p>
                                </div>
                            </div>
                            
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <div class="stat-info">
                                    <h4>200+</h4>
                                    <p>Clientes Atendidos</p>
                                </div>
                            </div>
                        </div>

                        <div class="about-buttons">
                            <a href="#collage" class="btn btn-primary">Conocer Más</a>
                            <a href="#contacto" class="btn btn-secondary">Contáctanos</a>
                        </div>
                    </div>
                    <div class="about-image">
                        <div class="image-wrapper">
                            <img src="https://peru.unir.net/wp-content/uploads/sites/2/2024/12/Que-es-un-Sistema-Integrado-de-Gestion-Definicion-y-Fundamentos1.jpg" alt="Sistema Integrado de Gestión">
                            <div class="image-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission and Vision Section -->
    <section class="mission-vision-section" id="mision-vision">
        <div class="container">
            <div class="mission-vision-grid">
                <div class="mission-card">
                    <div class="mv-header">
                        <div class="mv-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 2L2 7l10 5 10-5-10-5z" stroke-width="2"></path>
                                <path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke-width="2"></path>
                            </svg>
                        </div>
                        <h3>Misión</h3>
                    </div>
                    <p>Fortalecer la competitividad organizacional mediante Sistemas Integrados de Gestión que aseguren eficiencia, calidad, seguridad y sostenibilidad.</p>
                </div>
                
                <div class="vision-card">
                    <div class="mv-header">
                        <div class="mv-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="2"></path>
                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                            </svg>
                        </div>
                        <h3>Visión</h3>
                    </div>
                    <p>Ser el referente líder en consultoría integral, reconocido por generar valor sostenible y un impacto positivo en las organizaciones y la sociedad.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="servicios">
        <div class="container">
            <div class="section-header">
                <h2>Nuestros <span class="text-highlight">Servicios</span></h2>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&q=80" alt="Implementación de Sistemas de Gestión">
                    </div>
                    <div class="service-info">
                        <h3>IMPLEMENTACIÓN DE SISTEMAS DE GESTIÓN</h3>
                        <a href="#contacto" class="btn-service">Más información</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1553028826-f4804a6dba3b?w=600&q=80" alt="Consultoría Senior Especializada">
                    </div>
                    <div class="service-info">
                        <h3>CONSULTORÍA SENIOR ESPECIALIZADA</h3>
                        <a href="#contacto" class="btn-service">Más información</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=600&q=80" alt="Formación y Entrenamiento">
                    </div>
                    <div class="service-info">
                        <h3>FORMACIÓN Y ENTRENAMIENTO DE ALTO IMPACTO</h3>
                        <a href="#contacto" class="btn-service">Más información</a>
                    </div>
                </div>

                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=600&q=80" alt="Outsourcing Estratégico">
                    </div>
                    <div class="service-info">
                        <h3>OUTSOURCING ESTRATÉGICO DE PERSONAL</h3>
                        <a href="#contacto" class="btn-service">Más información</a>
                    </div>
                </div>
            </div>
        </div>



        <!-- Services Collage -->
        <div class="services-collage" id="collage">
            <div class="container">
                <div class="collage-grid">
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&q=80" alt="Capacitaciones SST">
                        <div class="collage-overlay">
                            <h4>CAPACITACIONES OBLIGATORIAS / NORMATIVAS (SST)</h4>
                        </div>
                    </div>
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&q=80" alt="IPERC">
                        <div class="collage-overlay">
                            <h4>IDENTIFICACIÓN DE PELIGROS, EVALUACIÓN DE RIESGOS Y CONTROLES (IPERC)</h4>
                        </div>
                    </div>
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&q=80" alt="Trabajo en Altura">
                        <div class="collage-overlay">
                            <h4>TRABAJOS DE ALTO RIESGO (TAR) - TRABAJO EN ALTURA</h4>
                        </div>
                    </div>
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?w=800&q=80" alt="SST en Minería">
                        <div class="collage-overlay">
                            <h4>SST EN MINERÍA</h4>
                        </div>
                    </div>
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1584362917165-526a968579e8?w=400&q=80" alt="Bioseguridad">
                        <div class="collage-overlay">
                            <h4>BIOSEGURIDAD</h4>
                        </div>
                    </div>
                    <div class="collage-item">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=400&q=80" alt="Primeros Auxilios">
                        <div class="collage-overlay">
                            <h4>EMERGENCIAS Y PRIMEROS AUXILIOS</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards Section -->
        <div class="stats-cards">
            <div class="container">
                <div class="stats-cards-grid">
                    <div class="stat-card-box">
                        <div class="stat-card-content">
                            <span class="stat-badge">CERTIFICACIONES DISPONIBLES</span>
                            <h3 class="stat-number">{{ $totalCursos }}+</h3>
                            <p class="stat-label">CERTIFICADOS TOTALES</p>
                            <a href="#servicios" class="btn-stat">VE NUESTROS SERVICIOS</a>
                        </div>
                    </div>
                    <div class="stat-card-box">
                        <div class="stat-card-content">
                            <span class="stat-badge">PROFESIONALES CAPACITADOS</span>
                            <h3 class="stat-number">1,200+</h3>
                            <p class="stat-label">PERSONAS CERTIFICADAS</p>
                            <a href="#nosotros" class="btn-stat">CONOZCA MÁS</a>
                        </div>
                    </div>
                    <div class="stat-card-box">
                        <div class="stat-card-content">
                            <span class="stat-badge">ÍNDICE DE SATISFACCIÓN</span>
                            <h3 class="stat-number">100%</h3>
                            <p class="stat-label">PERSONAS SATISFECHAS</p>
                            <a href="#contacto" class="btn-stat">CONTÁCTANOS</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contacto">
        <div class="container">
            <div class="contact-wrapper">
                <!-- Form Section -->
                <div class="contact-form-section">
                    <h2>Contáctanos</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="form-row">
                            <input type="text" placeholder="Tu nombre">
                            <input type="email" placeholder="Tu correo electrónico">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Asunto">
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Tu mensaje (Opcional)" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn-send">Enviar mensaje</button>
                    </form>
                </div>

                <!-- Contact Details Section -->
                <div class="contact-details-section">
                    <div class="contact-header-line">
                        <span class="line"></span>
                        <span class="subtitle">Estamos para ayudarte</span>
                    </div>
                    <h2>Contáctanos</h2>
                    <p class="contact-intro">Completa el formulario y nuestros especialistas resolverán tus dudas o te brindarán una cotización personalizada.</p>
                    
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="contact-icon whatsapp-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <div class="contact-item-content">
                                <span class="contact-label">WhatsApp Online</span>
                                <a href="https://wa.me/51937631988" class="contact-value">+51 937 631 988 - José Luis Perales</a>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon whatsapp-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <div class="contact-item-content">
                                <span class="contact-label">WhatsApp Online</span>
                                <a href="https://wa.me/51929003598" class="contact-value">+51 929 003 598 - Jasmine Luna</a>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </div>
                            <div class="contact-item-content">
                                <span class="contact-label">Correo electrónico</span>
                                <a href="mailto:ventas@gisemin.com" class="contact-value">ventas@gisemin.com</a>
                            </div>
                        </div>

                    </div>
                            </div>
                        </div>
                    </div>
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
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Footer Libro de Reclamaciones -->
                    <div class="footer-libro-wrapper">
                        <a href="{{ route('libro-reclamaciones') }}" class="footer-libro-btn">
                            <div class="footer-libro-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </div>
                            <span>LIBRO DE RECLAMACIONES</span>
                        </a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="#inicio">Inicio</a></li>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#collage">Certificados</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Servicios SST</h4>
                    <ul>
                        <li><a href="#servicios">Capacitaciones Obligatorias</a></li>
                        <li><a href="#servicios">IPERC</a></li>
                        <li><a href="#servicios">Trabajos de Alto Riesgo</a></li>
                        <li><a href="#servicios">Primeros Auxilios</a></li>
                        <li><a href="#servicios">Ergonomía</a></li>
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

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>


</body>
</html>

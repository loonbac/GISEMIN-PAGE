// ========================================
// Navigation Menu Toggle
// ========================================

const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const navMenu = document.getElementById('navMenu');

mobileMenuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    mobileMenuToggle.classList.toggle('active');
});

// Close mobile menu when clicking on a link
const navLinks = document.querySelectorAll('.nav-menu a');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
    });
});

// ========================================
// Navbar Scroll Effect
// ========================================

const navbar = document.getElementById('navbar');
let lastScroll = 0;

// Function to update navbar state based on scroll position
function updateNavbarState() {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    // Cambiar a blanco cuando se hace scroll
    if (currentScroll > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
}

// Check initial state immediately when script loads
updateNavbarState();

// Also check on DOMContentLoaded (in case of hash navigation)
document.addEventListener('DOMContentLoaded', updateNavbarState);

// Update on scroll
window.addEventListener('scroll', updateNavbarState);

// Handle hash navigation specifically
if (window.location.hash) {
    // Small delay to ensure DOM is ready after hash navigation
    setTimeout(updateNavbarState, 100);
}

// ========================================
// Smooth Scroll for Navigation Links
// ========================================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            const navbarHeight = navbar.offsetHeight;
            const viewportHeight = window.innerHeight;
            const sectionHeight = targetElement.offsetHeight;

            // Calculate position to center the section in the space BELOW the navbar
            const availableHeight = viewportHeight - navbarHeight;
            let targetPosition;

            if (sectionHeight < availableHeight) {
                // If section is smaller than view, center it in the remaining space
                const centerOffset = (availableHeight - sectionHeight) / 2;
                // Add a small 140px adjustment to move the section higher as requested
                targetPosition = targetElement.offsetTop - navbarHeight - centerOffset + 140;
            } else {
                // If section is taller than view, align to top with navbar offset
                targetPosition = targetElement.offsetTop - navbarHeight;
            }

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// ========================================
// Scroll to Top Button
// ========================================

const scrollToTopBtn = document.getElementById('scrollToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }
});

scrollToTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// ========================================
// Scroll Animations - DISABLED
// ========================================

// Animations disabled per user request

// ========================================
// Collage Dynamic Layout - DISABLED
// ========================================

// Collage now displays 6 static squares without rotation

// ========================================
// Contact Form Handling
// ========================================

const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Get form data
    const formData = new FormData(contactForm);
    const data = Object.fromEntries(formData);

    // Simulate form submission
    // In a real application, you would send this data to a server
    console.log('Form submitted:', data);

    // Show success message
    showNotification('¡Gracias por contactarnos! Nos pondremos en contacto pronto.', 'success');

    // Reset form
    contactForm.reset();
});

// ========================================
// Notification System
// ========================================

function showNotification(message, type = 'info') {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 30px;
        background-color: ${type === 'success' ? '#10b981' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        animation: slideIn 0.3s ease;
        max-width: 400px;
    `;

    // Add animation keyframes
    if (!document.querySelector('#notification-styles')) {
        const style = document.createElement('style');
        style.id = 'notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Append to body
    document.body.appendChild(notification);

    // Remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// ========================================
// Form Input Validation
// ========================================

const formInputs = document.querySelectorAll('.contact-form input, .contact-form textarea');

formInputs.forEach(input => {
    input.addEventListener('blur', () => {
        validateInput(input);
    });

    input.addEventListener('input', () => {
        if (input.classList.contains('invalid')) {
            validateInput(input);
        }
    });
});

function validateInput(input) {
    const value = input.value.trim();

    // Remove previous error message
    const existingError = input.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }

    input.classList.remove('invalid');

    // Check if required field is empty
    if (input.hasAttribute('required') && !value) {
        showInputError(input, 'Este campo es obligatorio');
        return false;
    }

    // Validate email
    if (input.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            showInputError(input, 'Por favor, ingrese un correo electrónico válido');
            return false;
        }
    }

    // Validate phone
    if (input.type === 'tel' && value) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        if (!phoneRegex.test(value)) {
            showInputError(input, 'Por favor, ingrese un número de teléfono válido');
            return false;
        }
    }

    return true;
}

function showInputError(input, message) {
    input.classList.add('invalid');

    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    `;

    input.parentElement.appendChild(errorDiv);
}

// Add invalid state styling
const style = document.createElement('style');
style.textContent = `
    .contact-form input.invalid,
    .contact-form textarea.invalid {
        border-color: #ef4444 !important;
    }
`;
document.head.appendChild(style);

// ========================================
// Parallax Effect - DISABLED
// ========================================

// Parallax effect disabled per user request

// ========================================
// Active Navigation Link
// ========================================

const sections = document.querySelectorAll('section[id]');

function updateActiveNavLink() {
    const scrollY = window.pageYOffset;

    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

window.addEventListener('scroll', updateActiveNavLink);

// Add active link styling
const navStyle = document.createElement('style');
navStyle.textContent = `
    .nav-menu a.active {
        color: var(--primary-color);
        font-weight: 600;
    }
`;
document.head.appendChild(navStyle);

// ========================================
// Lazy Loading for Images
// ========================================

if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    const images = document.querySelectorAll('img[data-src]');
    images.forEach(img => imageObserver.observe(img));
}

// ========================================
// Hero Slider
// ========================================

const heroSlides = document.querySelectorAll('.hero-slide');
if (heroSlides.length > 0) {
    let currentSlide = 0;
    const slideInterval = 10000; // 10 seconds

    setInterval(() => {
        heroSlides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % heroSlides.length;
        heroSlides[currentSlide].classList.add('active');
    }, slideInterval);
}

// ========================================
// Initialize on Page Load
// ========================================

document.addEventListener('DOMContentLoaded', () => {
    console.log('GISEMIN Consultores - Website Loaded Successfully');

    // Add loading animation completion
    document.body.classList.add('loaded');
});

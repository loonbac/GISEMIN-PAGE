// Disable navbar scroll effect for Libro de Reclamaciones
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');

    if (navbar) {
        // Force scrolled class to keep navbar white
        navbar.classList.add('scrolled');

        // Prevent the scroll listener from removing it
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (!navbar.classList.contains('scrolled')) {
                        navbar.classList.add('scrolled');
                    }
                }
            });
        });

        observer.observe(navbar, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/landing.css',
                'resources/css/login.css',
                'resources/css/certificados.css',
                'resources/css/admin/login.css',
                'resources/css/admin/admin.css',
                'resources/css/admin/agregar.css',
                'resources/js/landing.js',
                'resources/js/certificados.js',
                'resources/js/services-rotation.js',
                'resources/js/admin/cursos-autocomplete.js',
                'resources/js/admin/certificados-gestionar.js',
                'resources/js/admin/trabajador-search.js',
                'resources/js/admin/empresas-autocomplete.js',
                'resources/css/libro-reclamaciones.css',
                'resources/css/libro-reclamaciones-navbar.css',
                'resources/css/libro-reclamaciones-radios.css',
                'resources/js/libro-reclamaciones-navbar.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Escuchar en todas las interfaces
        port: 5174,
        strictPort: true,
        hmr: {
            // HMR se conecta al mismo host que el cliente usa
            // El navegador usará el host de la URL actual
            host: undefined, // Permite que el cliente determine el host
            port: 5174,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        cors: true,
    },
});

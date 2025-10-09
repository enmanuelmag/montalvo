import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/vendor-bundle.css','resources/css/theme-bundle.css',],
            refresh: true,
        }),
    ],
    build: {
        // Aseguramos que los archivos CSS se minifiquen
        cssMinify: true,
    },
});

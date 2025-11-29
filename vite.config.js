import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,
        port: 5173,

        hmr: {
            host: 'host.docker.internal',   // ✨ THIS IS THE FIX
            port: 5173,
            protocol: 'ws',
        },
    },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/client/app.css',
                'resources/js/client/app.js',

                'resources/css/admin/app.css',
                'resources/js/admin/app.js',
            ],
            refresh: true,
        }),
    ],
});

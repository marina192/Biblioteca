import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/usuarios.css',
                'resources/css/admin/categorias.css',
                'resources/css/admin/libros.css',
                'resources/css/admin/ejemplares.css',
                'resources/css/admin/prestamos.css',
                'resources/css/admin/reportes.css',
                'resources/css/lector/categorias.css',
                'resources/css/lector/libros.css',
                'resources/css/lector/prestamos.css',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

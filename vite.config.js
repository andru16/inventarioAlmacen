import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',

                //Autenticación
                'resources/js/autenticacion/iniciar_sesion.js',

                /**
                 * Configuración - Almacén
                 */
                'resources/js/configuracion/almacen/almacen.js',

                /**
                 * Configuración - Categoria
                 */
                'resources/js/configuracion/categorias/categoria.js'


            ],
            refresh: true,
        }),

    ],
});

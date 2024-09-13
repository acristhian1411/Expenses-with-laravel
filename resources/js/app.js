import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-svelte';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.svelte`,
        import.meta.glob('./Pages/**/*.svelte')
    ),
    setup({ el, App, props }) {
        new App({ target: el, props });
    },
});

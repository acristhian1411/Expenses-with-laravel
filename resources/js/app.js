import './bootstrap';
import { createInertiaApp } from '@inertiajs/inertia-svelte';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from './components/Commons/Layout.svelte';

// createInertiaApp({
//     resolve: (name) => resolvePageComponent(
//         `./Pages/${name}.svelte`,
//         import.meta.glob('./Pages/**/*.svelte')
//     ),
//     setup({ el, App, props }) {
//         new App({ target: el, props });
//     },
// });

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true })
        let page = pages[`./Pages/${name}.svelte`]
        return { default: page.default, layout: page.layout || Layout }
    },
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
})
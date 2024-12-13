import './bootstrap';
import '../css/app.css';
import 'vue-final-modal/style.css'
import 'vue3-toastify/dist/index.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';
import { createVfm } from 'vue-final-modal'
import Vue3Toastify from 'vue3-toastify';

const pinia = createPinia();
const vfm = createVfm();
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    progress: {
        delay: 100,
        color: '#FFD100',
        includeCSS: true,
        showProgressBar: false,
        showSpinner: true,
    },
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(vfm)
            .use(Vue3Toastify, {
                autoClose: 3000,
                "theme": "dark",
                "position": "top-center",
                "hideProgressBar": true,
                "transition": "bounce",
                "dangerouslyHTMLString": true
            })
            .mount(el);
    },
});

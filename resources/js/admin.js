import './bootstrap';
import '../css/app.css';
import 'element-plus/theme-chalk/src/dark/css-vars.scss'

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

//layout
import Admin from '@/Layouts/Admin.vue'
import Auth from '@/Layouts/Auth.vue'
import NavLink from '@/Components/NavLink.vue'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: async name => {
        const comps = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let match = comps[`./Pages/${name}.vue`];
        if (match === undefined) {
            return import('./Errors/404page.vue');
        }
        let page = (await match).default;

        if (page.layout === 'admin') {
            page.layout = Admin
        }
        else if (page.layout === 'auth') {
            page.layout = Auth
        }
        else {
            page.layout = Admin
        }
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link)
            .component("NavLink", NavLink)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

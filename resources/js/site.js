import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import {createInertiaApp, Link} from '@inertiajs/vue3';

import Site from "@/Layouts/Site.vue";
import NavLink from '@/Components/NavLink.vue'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async name => {
        const comps = import.meta.glob('./Site/Pages/**/*.vue', {eager: true});
        let match = comps[`./Site/Pages/${name}.vue`];
        console.log(name);
        if (match === undefined) {
            return import('./Errors/404page.vue');
        }
        let page = (await match).default;
        page.layout = Site
        return page
    },
    setup({el, App, props, plugin}) {
        // return createApp({render: () => h(App, props)})
        const VueApp = createApp({render: () => h(App, props)});

        VueApp.use(plugin)
        VueApp.component("Link", Link)
        VueApp.component("NavLink", NavLink)
        VueApp.config.globalProperties.appRoute = route
        VueApp.mount(el);

    },
    progress: {
        color: '#4B5563',
    },
});

import './bootstrap';
import '../css/admin.css';
import 'element-plus/theme-chalk/src/dark/css-vars.scss'

/* import the fontawesome core */
import {library} from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
/* import all icons */

import {
    faCircleInfo, faRightFromBracket, faShield, faUser, faUnlockKeyhole, faBell, faFileExcel, faHome, faGear, faTrash,faShop,faCartShopping, faFish,faBlog,faUsers,faGauge,faList
} from '@fortawesome/free-solid-svg-icons'
library.add(faCircleInfo, faRightFromBracket, faShield, faUser, faUnlockKeyhole, faBell, faFileExcel, faHome, faGear, faTrash,faFish,faBlog,faUsers,faGauge,faList,faShop,faCartShopping);

import {createApp, h} from 'vue';
import {createInertiaApp, Link} from '@inertiajs/vue3';
//layout s
import Admin from '@/Layouts/Admin.vue'
import Auth from '@/Layouts/Auth.vue'
import NavLink from '@/Components/NavLink.vue'
// import { fab } from '@fortawesome/free-brands-svg-icons'
// import { far } from '@fortawesome/free-regular-svg-icons'
/* add icons to the library */

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`, // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: async name => {
        const comps = import.meta.glob('./Admin/Pages/**/*.vue', {eager: true});
        let match = comps[`./Admin/Pages/${name}.vue`];
        if (match === undefined) {
            return import('./Errors/404page.vue');
        }
        let page = (await match).default;

        if (page.layout === 'admin') {
            page.layout = Admin
        } else if (page.layout === 'auth') {
            page.layout = Auth
        } else {

        }
        return page
    }, setup({el, App, props, plugin}) {
        // return createApp({render: () => h(App, props)})
        const VueApp = createApp({render: () => h(App, props)});

        VueApp.use(plugin)
        VueApp.component("Link", Link)
        VueApp.component("NavLink", NavLink)
        VueApp.component('fa', FontAwesomeIcon)
        // VueApp.mixin({methods: {appRoute: window.route}})
        // .use(ZiggyVue)
        VueApp.config.globalProperties.appRoute = route
        VueApp.mount(el);

    },
    progress: {
        color: '#d0112b',
        showSpinner: true
    },
});

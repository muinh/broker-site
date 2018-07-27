import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

import Layout from '../components/Layout';

let routes = [
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: ':slug',
                component: Layout
            }
        ]
    },
    {
        path: '*',
        redirect: '/',
    }
];
let router = new Router({
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior: () => ({y: 0}),
    routes
});

router.beforeEach((to, from, next) => {
    // if (to.path === '/trading' && window.browserDetect.name === 'ie'){
    //     next('/unsupported');
    // }
    next();
});
export default router;

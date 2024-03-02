import { createRouter, createWebHistory } from 'vue-router'

import AuthLayout from '../layouts/AuthLayout.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/Login.vue')
        },
        {
            path: '/',
            component: AuthLayout,
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: () => import('../views/Dashboard.vue'),
                },
                {
                    path: 'herramienta',
                    name: 'herramienta',
                    children: [
                        {
                            path: 'bizig',
                            name: 'bizig',
                            children: [
                                {
                                    path: '',
                                    component: () => import('../views/tools/bizig/Presentation.vue'),
                                },
                                {
                                    path: 'perspectiva',
                                    name: 'perspectiva',
                                    component: () => import('../views/tools/bizig/Perspectiva.vue'),
                                }
                            ]
                        },
                    ]
                }
            ]
        }
    ]
})

// router.beforeEach((to, from, next) => {
//     let token = localStorage.getItem('token')
//     const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

//     if (to.path === '/') {
//         next('/dashboard');
//     }

//     if (requiresAuth && !token) {
//         next("/login");
//     } else if (!requiresAuth && token) {
//         next("/dashboard");
//     } else {
//         next();
//     }

// })


export default router

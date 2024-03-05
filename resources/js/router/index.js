import { createRouter, createWebHistory } from 'vue-router'


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
            component: () => import('../layouts/AuthLayout.vue'),
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: () => import('../views/Dashboard.vue'),
                },
                {
                    path: 'herramientas',
                    name: 'herramientas',
                    children: [
                        {
                            path: 'bizig',
                            name: 'bizig',
                            component: () => import('../components/tools/bizig/layout/BizigLayout.vue'),
                            children: [
                                {
                                    path: '',
                                    name: 'presentacion',
                                    component: () => import('../views/tools/bizig/Presentation.vue'),
                                },
                                {
                                    path: 'perspectiva',
                                    name: 'perspectiva',
                                    component: () => import('../views/tools/bizig/Perspectiva.vue'),
                                },
                                {
                                    path: 'admin',
                                    name: 'admin',
                                    component: () => import('../views/tools/bizig/Administration.vue'),
                                },
                                {
                                    path: 'dashboard',
                                    name: 'dashboard',
                                    component: () => import('../views/tools/bizig/Dashboard.vue'),
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

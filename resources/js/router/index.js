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
                    path: '',
                    name: 'home',
                    component: () => import('../views/Home.vue')
                },
                {
                    path: 'empresas',
                    name: 'empresas',
                    component: () => import('../views/company/Companies.vue'),
                },
                {
                    path: 'herramientas',
                    name: 'herramientas',
                    children: [
                        {
                            path: 'bizig',
                            name: 'Bizig',
                            component: () => import('../components/tools/bizig/layout/BizigLayout.vue'),
                            children: [
                                {
                                    path: '',
                                    name: 'presentacion',
                                    component: () => import('../views/tools/bizig/Presentation.vue'),
                                },
                                {
                                    path: 'perspectivas/:id',
                                    name: 'perspectiva',
                                    component: () => import('../views/tools/bizig/Perspectives.vue'),
                                },
                                {
                                    path: 'admin',
                                    name: 'admin',
                                    component: () => import('../views/tools/bizig/Administration.vue'),
                                },
                                {
                                    path: 'dashboard/:companyId?',
                                    name: 'dashboard',
                                    component: () => import('../views/tools/bizig/Dashboard.vue'),
                                }
                            ]
                        },
                    ]
                }
            ]
        },
        {
            path: '/:catchAll(.*)', component: () => import('../views/NotFound.vue'),
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

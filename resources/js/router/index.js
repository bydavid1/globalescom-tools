import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/Login.vue')
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

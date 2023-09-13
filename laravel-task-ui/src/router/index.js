import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/game',
        name: 'game',
        component: () => import('@/views/Game.vue'),
        meta: {
            title: ''
        }
    }
]

const router = new createRouter({
    // mode: 'history',
    history: createWebHistory(),
    routes,
});

export default router;

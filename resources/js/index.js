import { createRouter, createWebHistory } from 'vue-router';
import TransferList from './components/pages/TransferList.vue';

const routes = [
    {
        path: '/transfers',
        name: 'TransferList',
        component: TransferList,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

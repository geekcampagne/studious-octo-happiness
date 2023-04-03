import {createRouter, createWebHistory} from 'vue-router'
const routes = [
    {
        path: '/',
        name: 'Listing',
        component: () => import('./pages/Listing.vue'),
    },
    {
        path: '/order/:id',
        name: 'Order',
        component: () => import('./pages/Order.vue'),
    },
    //404
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('./pages/NotFound.vue'),
    }

]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router

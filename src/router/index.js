import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue'
import Products from '../views/Products.vue'
import ProductDetail from '../views/ProductDetail.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Wishlist from '../views/Wishlist.vue'
import Cart from '../views/Cart.vue'
import Checkout from '../views/Checkout.vue'
import Orders from '../views/Orders.vue'
import Profile from '../views/Profile.vue'

const routes = [
    { path: '/',               component: Home },
    { path: '/products',       component: Products },
    { path: '/products/:id',   component: ProductDetail },
    { path: '/login',          component: Login },
    { path: '/register',       component: Register },
    { path: '/wishlist',       component: Wishlist,    meta: { requiresAuth: true } },
    { path: '/cart',           component: Cart,        meta: { requiresAuth: true } },
    { path: '/checkout',       component: Checkout,    meta: { requiresAuth: true } },
    { path: '/orders',         component: Orders,      meta: { requiresAuth: true } },
    { path: '/profile',        component: Profile,     meta: { requiresAuth: true } },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Guard — ការពារ Private Pages
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')
    if (to.meta.requiresAuth && !token) {
        next('/login')
    } else {
        next()
    }
})

export default router
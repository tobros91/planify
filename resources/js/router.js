import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
import routes from './routes'

Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history',
})

router.beforeEach((to, from, next) => {

    store.commit('setRouterLoading', true)

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isAuth) {
            window.location.href = '/login'
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

axios.interceptors.response.use(null, (error) => {
    if (error.response.status === 403) {
        router.push({ name: '403' })
    }

    return Promise.reject(error);
});

window.Vue = require('vue');

window.bus = new Vue()

Vue.component('notificationBadge', require('./components/notification-badge'));
Vue.component('flasher', require('./components/flasher'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import routes from './routes'

const router = new VueRouter({
    routes,
    mode: 'history',
})

router.beforeEach((to, from, next) => {
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

import store from './store'

Vue.mixin({
    computed: {
        auth ()
        {
            return this.$store.state.auth
        }
    }
})

const app = new Vue({
    el: '#app',
    router,
    store,
    created ()
    {
        if (!isAuth) {
            return
        }
        this.$store.dispatch('auth/get')
    }
});

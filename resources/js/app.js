require('./bootstrap')

window.Vue = require('vue')
window.bus = new Vue()

import store from './store'
import router from './router'

import notificationBadge from './components/notification-badge'
import flasher from './components/flasher'

Vue.mixin({
    computed: {

        auth ()
        {
            return this.$store.state.auth
        },

        routerLoading ()
        {
            return this.$store.state.routerLoading
        }

    },

    methods: {

        setRouterLoading (loading)
        {
            this.$store.commit('setRouterLoading', loading)
        }

    }
})

const app = new Vue({
    el: '#app',
    components: {
        notificationBadge,
        flasher
    },
    router,
    store,
    created ()
    {
        if (!isAuth) {
            return
        }
        this.$store.dispatch('auth/get')
    }
})

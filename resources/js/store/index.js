import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import project from './modules/project'
import notifications from './modules/notifications'

Vue.use(Vuex)

export default new Vuex.Store({
    strict: true,
    modules: {
        project,
        notifications,
        auth
    },

    state: {
        routerLoading: false,
    },

    mutations: {
        setRouterLoading (state, routerLoading)
        {
            state.routerLoading = routerLoading
        },
    },
})

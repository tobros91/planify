import Vue from 'vue'
import Vuex from 'vuex'

import project from './modules/project'
import notifications from './modules/notifications'

Vue.use(Vuex)

export default new Vuex.Store({
    strict: true,
    modules: {
        project,
        notifications
    }
})

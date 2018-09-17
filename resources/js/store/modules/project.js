export default {

    namespaced: true,

    state: {
        project: {},
        user: {}
    },

    mutations: {
        setProject (state, project)
        {
            state.project = project
        },
        setUser (state, user)
        {
            state.user = user
        }
    },

    getters: {

        authIsOwner (state, getters, rootState)
        {
            return state.project.user_id === rootState.auth.user.id
        }

    },

    actions: {

        get ({commit}, project_id)
        {
            return new Promise((resolve, reject) => {
                axios.get('/data/projects/'+project_id)
                .then((response) => {
                    console.log('get project')
                    console.log(response.data);
                    commit('setProject', response.data.project)
                    commit('setUser', response.data.user)
                    resolve(response.data.project)
                })
                .catch((error) =>{
                    console.log(error)
                    reject(error)
                })
            })
        }

    }

}

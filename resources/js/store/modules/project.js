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

        filterTasks: (state) => (filter) => {

            if (!filter.user_id) {
                return state.project.tasks
            }

            return state.project.tasks.filter((task) => {
                return task.team.map(o => o['id']).indexOf(filter.user_id) !== -1
            })
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

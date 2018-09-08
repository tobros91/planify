export default {

    namespaced: true,

    state: {
        project: {}
    },

    mutations: {
        set (state, project)
        {
            state.project = project
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
                    console.log(response);
                    commit('set', response.data.project)
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

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

    actions: {

        get ({commit}, project_id)
        {
            return new Promise((resolve, reject) => {
                axios.get('/data/projects/'+project_id)
                .then((response) => {
                    console.log(response);
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

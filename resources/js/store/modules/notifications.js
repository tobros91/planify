export default {

    namespaced: true,

    state: {
        all: []
    },

    mutations: {
        set (state, notifications)
        {
            state.all = notifications
        }
    },

    actions: {

        get ({commit})
        {
            return new Promise((resolve, reject) => {
                axios.get('/data/notifications/')
                .then((response) => {
                    console.log(response);
                    commit('set', response.data)
                    resolve(response.data)
                })
                .catch((error) =>{
                    console.log(error)
                    reject(error)
                })
            })
        }

    }

}

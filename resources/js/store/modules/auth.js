export default {

    namespaced: true,

    state: {
        user: {}
    },

    mutations: {
        setUser (state, user)
        {
            state.user = user
        },
    },

    actions: {

        get ({commit})
        {
            return new Promise((resolve, reject) => {
                axios.get('/data/settings')
                .then((response) => {
                    console.log('get user')
                    console.log(response.data);
                    commit('setUser', response.data)
                })
                .catch((error) =>{
                    console.log(error)
                    reject(error)
                })
            })
        }

    }

}

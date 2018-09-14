<template>
<div class="container" v-if="user">

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <img class="card-img-top" :src="user.image_url">
                    </div>
                </div>

                <div class="col">
                    <h5 class="card-title">{{ user.name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ user.email }}</h6>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>

    export default {

        data ()
        {
            return {
                user: undefined,
                jointProjects: [],
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            fetch ()
            {
                const user_id = this.$route.params.user_id ? this.$route.params.user_id : ''

                axios.get('/data/profile/'+user_id)
                .then((response) => {
                    console.log(response.data);
                    this.user = response.data.user
                    this.jointProjects = response.data.jointProjects
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

<template>
<div class="container" v-if="user">
    <h3>Profile</h3>
    {{ user }}
</div>
</template>

<script>

    export default {

        data ()
        {
            return {
                user: undefined,
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
                    console.log(response);
                    this.user = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

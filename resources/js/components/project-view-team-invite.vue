<template>
<div class="container">
    <h1>Invite user</h1>

    <div class="card">

        <div class="card-body">

            <input-text
                type="text"
                name="email"
                label="E-mail"
                v-model="email"
                :error="errors.email"
            />

            <input-text
                type="textarea"
                name="message"
                label="Message"
                v-model="message"
                :error="errors.message"
            />


            <button type="submit" class="btn btn-primary float-right" @click="invite()">Send invitation</button>

        </div>

    </div>
</div>
</template>

<script>

    import inputText from './form/input-text'

    export default {

        components: {
            inputText
        },

        data ()
        {
            return {
                email: '',
                message: '',
                errors: {},
            }
        },

        computed: {

            project ()
            {
                return this.$store.state.project.project
            }

        },

        methods: {

            invite ()
            {
                axios.post('/data/projects/'+this.project.id+'/invite', {
                    email: this.email,
                    message: this.message,
                })
                .then((response) => {
                    console.log(response);

                    this.email = ''
                    this.message = {}
                    this.errors = {}
                    this.$store.dispatch('project/get', this.project.id)
                    this.$router.push({ name: 'project-view-team-list' })
                    bus.$emit('flash', 'The user got invited.')
                })
                .catch((error) => {
                    console.log(error);

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }

                });
            },

        }

    }

</script>

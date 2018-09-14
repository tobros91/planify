<template>
<div class="container">

    <div class="row">
        <div class="col">
            Team
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" :class="{ 'is-invalid': error }" placeholder="E-mail" v-model="email">
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ error }}</strong>
                    </span>
                </div>
                <div class="col">
                    <div class="btn btn-primary btn-sm float-right" @click="invite()">
                        Invite user
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="user in project.team">
            <div class="row">
                 <div class="col-1">
                    <img class="img-fluid avatar" :src="user.image_url">
                </div>
                <div class="col">
                    {{ user.name }}
                    <i class="fas fa-clock" title="Pending" v-if="!user.pivot.accepted_at && !user.pivot.rejected_at"></i>
                </div>
                <div class="col">
                    {{ user.email }}
                </div>
                <div class="col">
                    <span class="badge badge-dark" title="Tasks in project">
                        {{ user.tasks.length }}
                    </span>
                </div>
                <div class="col">
                    <div class="btn btn-danger btn-sm float-right" @click="kick(user.id)">
                        Kick
                    </div>
                </div>
            </div>
        </li>
    </ul>

</div>
</template>

<script>

    export default {

        data ()
        {
            return {
                email: '',
                error: '',
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
                axios.post('/data/projects/'+this.project.id+'/teams', {
                    email: this.email,
                })
                .then((response) => {
                    console.log(response);

                    this.email = '';
                    this.error = '';
                    this.$store.dispatch('project/get', this.project.id)
                    bus.$emit('flash', 'The user got invited.')
                })
                .catch((error) => {
                    console.log(error);

                    if (error.response && error.response.status === 422) {
                        console.log('validation error')
                        console.log(error.response)

                        this.error = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0]
                    }

                });
            },

            kick (user_id)
            {
                if (!confirm('Are you sure?')) {
                    return;
                }

                axios.delete('/data/projects/'+this.project.id+'/teams/'+user_id)
                .then((response) => {
                    console.log(response);
                    this.$store.dispatch('project/get', this.project.id)
                    bus.$emit('flash', 'The user got kicked.')
                })
                .catch((error) => {

                });
            }

        }

    }

</script>

<template>
<div class="container">

    <div class="row">
        <div class="col">
             <input type="text" class="form-control" placeholder="Search team members" v-model="filter.text">
        </div>
        <div class="col">
            <div class="btn btn-primary btn-sm float-right" @click="create()">
                Invite user
            </div>
        </div>
    </div>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="user in filteredTeam">
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
                    <div class="btn btn-danger btn-sm float-right" @click="kick(user.id)" v-if="authIsOwner && user.id != auth.user.id">
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
                filter: {
                    text: '',
                }
            }
        },

        computed: {

            project ()
            {
                return this.$store.state.project.project
            },

            authIsOwner ()
            {
                return this.$store.getters['project/authIsOwner']
            },

            filteredTeam ()
            {
                const text = this.filter.text.toLowerCase()

                return this.project.team.filter((user) => {
                    return user.name.toLowerCase().indexOf(text) !== -1
                           ||
                           user.email.toLowerCase().indexOf(text) !== -1
                })
            },

        },

        methods: {

            create ()
            {
                this.$router.push({ name: 'project-view-team-invite' })
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

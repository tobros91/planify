<template>
<div v-if="hasLoaded">

    <div class="container">
        <h1>{{ project.title }}</h1>
    </div>

    <div class="row no-gutters mt-3 mb-3">
        <div class="col border-bottom">
            <div class="container">
                <ul class="nav nav-tabs border-bottom-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'projects.view' }" class="nav-link" exact-active-class="active">
                            Overview
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'projects.view.tasks' }" class="nav-link" exact-active-class="active">
                            Tasks
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'projects.view.calendar' }" class="nav-link" exact-active-class="active">
                            Calendar
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'projects.view.team' }" class="nav-link" exact-active-class="active">
                            Team
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div v-if="user.pivot.accepted_at">
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>

    <div class="container" v-if="!user.pivot.accepted_at">
        <div class="row">
            <div class="col">

                <h3>Please respond to the invitation.</h3>

                <button class="btn btn-success" @click="respond('accept')">Accept</button>
                <button class="btn btn-danger" @click="respond('deny')">Deny</button>
            </div>
        </div>
    </div>

</div>
</template>

<script>

    export default {

        computed: {

            project ()
            {
                return this.$store.state.project.project
            },
            user ()
            {
                return this.$store.state.project.user
            },
            hasLoaded ()
            {
                return Object.keys(this.project).length > 0 && Object.keys(this.user).length > 0
            }

        },

        created ()
        {
            this.$store.dispatch('project/get', this.$route.params.project_id)
        },

        methods: {

            respond (action)
            {
                axios.post('/data/projects/'+this.$route.params.project_id+'/teams/respond', {
                    action: action,
                })
                .then((response) => {
                    console.log(response.data);

                    if (action == 'accept') {
                        this.$router.push({ name: 'projects.view', params: { project_id: this.$route.params.project_id }})
                        return
                    }

                })
                .catch((error) => {
                    console.log(error.data);
                });
            }

        }

    }

</script>

<template>
<div v-if="project">

    <div class="container mt-3">
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

    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>

</div>
</template>

<script>

    export default {

        computed: {

            project ()
            {
                return this.$store.state.project.project
            }

        },

        created ()
        {
            this.$store.dispatch('project/get', this.$route.params.project_id)
            .then((project) => {
                this.$store.commit('project/set', project)
            })
        },

        methods: {

            fetch ()
            {
                axios.get('/data/projects/'+this.$route.params.project_id)
                .then((response) => {
                    console.log(response);
                    this.project = response.data.project
                })
                .catch((error) =>{
                    console.log(error);
                });
            }

        }

    }

</script>

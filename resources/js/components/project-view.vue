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
                        <router-link :to="{ name: 'project-view' }" class="nav-link" exact-active-class="active">
                            Overview
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'project-view-task-list' }" class="nav-link" active-class="active">
                            Tasks
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'project-view-calendar' }" class="nav-link" active-class="active">
                            Calendar
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'project-view-team-list' }" class="nav-link" active-class="active">
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
            this.fetch()
        },

        methods: {

            fetch ()
            {
                this.$store.dispatch('project/get', this.$route.params.project_id)
            },

        }

    }

</script>

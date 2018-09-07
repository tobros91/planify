<template>
<div class="container">

    <div class="row">
        <div class="col">
            Team
        </div>
        <div class="col">
            <div class="btn btn-primary btn-sm float-right" @click="create()">
                Invite user
            </div>
        </div>
    </div>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="user in project.team">
            <div class="row">
                <div class="col">{{ user.name }}</div>
                <div class="col">{{ user.email }}</div>
                <div class="col">
                    <span class="badge badge-dark" title="Tasks in project">
                        {{ user.tasks.length }}
                    </span>
                </div>
                <div class="col">
                    <div class="btn btn-danger btn-sm float-right">
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

        computed: {

            project ()
            {
                return this.$store.state.project.project
            }

        },

        methods: {



        }

    }

</script>

<template>
<div class="container">

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" placeholder="Search all tasks" v-model="filter.text">
        </div>
        <div class="col">
            <select class="form-control" v-model="filter.user_id">
                <option :value="null">User</option>
                <option v-for="user in project.team" :value="user.id">{{ user.name }}</option>
            </select>
        </div>
        <div class="col">
            <div class="btn btn-primary btn-sm float-right" @click="create()">
                Create task
            </div>
        </div>
    </div>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="task in tasks">
            <div class="row">
                <div class="col">{{ task.title }}</div>
                <div class="col">
                    <span v-for="user in task.team">{{ user.name }}</span>
                </div>
                <div class="col">
                    <div class="btn btn-primary btn-sm float-right" @click="view(task.id)">
                        View
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
                    user_id: null
                }
            }
        },

        computed: {

            project ()
            {
                return this.$store.state.project.project
            },

            tasks ()
            {
                return this.$store.getters['project/filterTasks'](this.filter)
            }

        },

        methods: {

            view (task_id)
            {
                this.$router.push({ name: 'tasks-view', params: { task_id: task_id }})
            }

        }

    }

</script>

<template>
<div class="container">

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" placeholder="Search tasks" v-model="filter.text">
        </div>
        <div class="col">
            <select class="form-control" v-model="filter.user_id">
                <option :value="null">Filter assignee</option>
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
        <li class="list-group-item" v-if="project.tasks.length === 0">
            No tasks
        </li>
        <li class="list-group-item" v-if="project.tasks.length > 0">
            <div class="row">
                <div class="col"></div>
                <div class="col-3">
                    Assignees
                </div>
            </div>
        </li>
        <li class="list-group-item" v-for="task in filteredTasks">
            <div class="row">
                <div class="col">
                    <router-link :to="{ name: 'project-view-task-view', params: { task_id: task.id }}" class="h4">{{ task.title }}</router-link>
                </div>
                <div class="col-3">
                    <span v-for="user in task.team">
                        <img class="img-fluid avatar assignee" :src="user.image_url" :title="user.name">
                    </span>
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

            filteredTasks ()
            {
                let tasks = this.project.tasks

                if (this.filter.user_id) {
                    tasks = tasks.filter((task) => {
                        return task.team.map(o => o['id']).indexOf(this.filter.user_id) !== -1
                    })
                }

                if (this.filter.text) {
                    tasks = tasks.filter((task) => {
                        return task.title.toLowerCase().indexOf(this.filter.text.toLowerCase()) !== -1
                    })
                }

                return tasks
            }

        },

        methods: {

            create ()
            {
                this.$router.push({ name: 'project-view-task-create' })
            },

            view (task_id)
            {
                this.$router.push({ name: 'project-view-task-view', params: { task_id: task_id }})
            }

        }

    }

</script>

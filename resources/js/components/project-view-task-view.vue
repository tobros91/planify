<template>
<div class="container" v-if="task">
    <h3>
        {{ task.title }}
        <div class="btn btn-primary btn-sm float-right" @click="edit()">
            Edit
        </div>
    </h3>
    <div class="row mt-3">
        <div class="col">
            <div class="row mb-3" v-for="comment in task.comments">
                <div class="col-1">
                    <img class="img-fluid avatar" :src="comment.user.image_url">
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            {{ comment.user.name}}
                        </div>
                        <div class="card-body">
                            {{ comment.body }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-1">
                    <img class="img-fluid avatar" :src="auth.user.image_url">
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" rows="5" placeholder="Leave a comment"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right" @click="submit()">Store</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-3">
            <div class="row">
                <div class="col">
                    <b @click="showAssign = !showAssign">Assignees <i class="fas fa-user-cog"></i></b>
                    <div class="row" v-for="user in task.team" v-if="!showAssign">
                        <div class="col">{{ user.name }}</div>
                    </div>
                    <ul class="list-group" v-if="!showAssign">
                        <li class="list-group-item d-flex justify-content-between align-items-center pl-0 pr-0" v-for="user in project.team" @click="assign(user)">

                            <span>
                                <img class="avatar" width="50" :src="user.image_url">
                                {{ user.name }}
                            </span>

                            <i class="fas fa-check" v-if="isAssignedToTask(user)"></i>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    export default {

        data ()
        {
            return {
                task: undefined,
                showAssign: false,
            }
        },

        created ()
        {
            this.fetch()
        },

        computed: {

            project ()
            {
                return this.$store.state.project.project
            },

        },

        methods: {

            isAssignedToTask (user)
            {
                return this.task.team.find((team) => {
                    return team.id == user.id
                })
            },

            assign (user)
            {
                const action = this.isAssignedToTask(user) ? 'kick' : 'assign'

                axios.post('/tasks/'+this.task.id+'/'+action, {
                    user_id: user.id,
                })
                .then((response) => {
                    console.log('got assign response')
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            edit ()
            {
                this.$router.push({ name: 'tasks.edit', params: { task_id: this.$route.params.task_id }})
            },

            fetch ()
            {
                axios.get('/data/projects/'+this.$route.params.project_id+'/tasks/'+this.$route.params.task_id)
                .then((response) => {
                    console.log('got task')
                    console.log(response.data);
                    this.task = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

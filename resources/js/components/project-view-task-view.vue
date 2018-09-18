<template>
<div class="container" v-if="task">
    <h3>
        {{ task.title }}
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
                            {{ comment.user.name }} - <span class="text-muted">{{ comment.created_at.substr(0, 16) }}</span>
                        </div>
                        <div class="card-body">
                            {{ comment.body }}
                        </div>
                    </div>
                </div>
            </div>

            <write-comment :task="task" @submited="fetch()"></write-comment>

        </div>
        <div class="col-3">
            <div class="row">
                <div class="col">
                    <b class="d-flex justify-content-between align-items-center" style="cursor: pointer;" @click="showAssign = !showAssign">Assignees <i class="fas fa-user-cog"></i></b>
                    <div class="row" v-for="user in task.team" v-if="!showAssign">
                        <div class="col"><img class="avatar" width="25" :src="user.image_url"> {{ user.name }}</div>
                    </div>
                    <ul class="list-group" v-if="showAssign">
                        <li class="list-group-item d-flex justify-content-between align-items-center pl-1 pr-1" style="cursor: pointer;" v-for="user in project.team" @click="assign(user)">

                            <span>
                                <img class="avatar" width="25" :src="user.image_url">
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

    import writeComment from './project-view-task-view-comment'

    export default {

        components: {
            writeComment,
        },

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

                axios.post('/data/projects/'+this.project.id+'/tasks/'+this.task.id+'/'+action, {
                    user_id: user.id,
                })
                .then((response) => {
                    console.log('got assign response')
                    console.log(response.data);
                    this.fetch()
                })
                .catch((error) => {
                    console.log(error);
                });
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

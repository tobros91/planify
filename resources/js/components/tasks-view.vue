<template>
<div class="container" v-if="task">
    <h3>
        {{ task.title }}
        <div class="btn btn-primary btn-sm float-right" @click="edit()">
            Edit
        </div>
    </h3>
    <p>{{ task.description }}</p>
</div>
</template>

<script>

    export default {

        data ()
        {
            return {
                task: undefined,
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            edit ()
            {
                this.$router.push({ name: 'tasks.edit', params: { task_id: this.$route.params.task_id }})
            },

            fetch ()
            {
                axios.get('/data/projects/'+this.$route.params.project_id+'/tasks/'+this.$route.params.task_id+'/edit')
                .then((response) => {
                    console.log(response);
                    this.task = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

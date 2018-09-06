<template>
<div v-if="project">
    <div class="card">
        <div class="card-header">
            {{ project.title }}
        </div>

        <div class="card-body">
            {{ project.description }}
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Tasks
        </div>

        <div class="card-body">
            <div class="row" v-for="task in project.tasks">
                <div class="col">{{ task.title }}</div>
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
                project: undefined
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            fetch ()
            {
                axios.get('/data/projects/'+this.$route.params.id)
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

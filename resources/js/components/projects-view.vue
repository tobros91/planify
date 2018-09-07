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

    <calendar :tasks="project.tasks" />

</div>
</template>

<script>

    import calendar from './tasks-calendar'

    export default {

        components: {
            calendar,
        },

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

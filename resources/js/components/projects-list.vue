<template>
<div class="card">
    <div class="card-header">
        Projects
        <div class="btn btn-primary btn-sm float-right" @click="create()">
            Create project
        </div>
    </div>

    <div class="card-body">
        <div class="row" v-for="project in projects">
            <div class="col">
                <router-link :to="{ name: 'projects.view', params: { id: project.id }}">{{ project.title }}</router-link>
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
                projects: []
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            fetch ()
            {
                axios.get('/data/projects')
                .then((response) => {
                    console.log(response);
                    this.projects = response.data.projects
                })
                .catch((error) =>{
                    console.log(error);
                });
            },

            create ()
            {
                this.$router.push({ name: 'projects.create' })
            }

        }

    }

</script>

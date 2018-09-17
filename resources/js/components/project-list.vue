<template>
<div class="container">

    <h1>
        Projects

        <div class="btn btn-primary btn-sm float-right" @click="create()">
            Create project
        </div>

    </h1>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="project in projects">
            <div class="row">
                <div class="col">
                    <router-link :to="{ name: 'project-view', params: { project_id: project.id }}" class="h5">{{ project.title }}</router-link>
                </div>
            </div>
        </li>
         <li class="list-group-item" v-if="projects.length === 0">
            No projects
        </li>
    </ul>

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
                this.$router.push({ name: 'project-create' })
            }

        }

    }

</script>

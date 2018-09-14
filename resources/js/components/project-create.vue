<template>
<div class="container">

    <h1>Create Project</h1>

    <div class="card">

        <div class="card-body">

            <input-text
                type="text"
                name="title"
                label="Title"
                v-model="project.title"
                :error="errors.title"
            />

            <input-text
                type="textarea"
                name="description"
                label="Description"
                v-model="project.description"
                :error="errors.description"
            />


            <button type="submit" class="btn btn-primary float-right" @click="store()">Store</button>

        </div>

    </div>
</div>
</template>

<script>

    import inputText from './form/input-text'

    export default {

        components: {
            inputText
        },

        data ()
        {
            return {
                project: {
                    title: '',
                    description: ''
                },
                errors: {}
            }
        },

        methods: {

            store ()
            {
                axios.post('/data/projects',
                    this.project
                )
                .then((response) => {
                    console.log(response);

                    this.$router.push({ name: 'project-view', params: { project_id: response.data.id }})
                })
                .catch((error) => {
                    console.log(error.response);

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }

                });
            }

        }

    }

</script>

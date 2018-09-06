<template>
<div class="card">
    <div class="card-header">
        Create project
    </div>

    <div class="card-body">
        <div class="form-group row">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="title" placeholder="Title" v-model="project.title">
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="description" placeholder="Description" v-model="project.description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" @click="store()">Store</button>
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
                project: {
                    title: '',
                    description: ''
                }
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

                    this.$router.push({ name: 'projects.view', params: { id: response.data.id }})
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

<template>
<div class="container" v-if="user">
    <h3>Settings</h3>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <uploader />
                        <img class="card-img-top" :src="user.image_url">
                    </div>
                </div>

                <div class="col">

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="Name" v-model="user.name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" placeholder="E-mail" v-model="user.email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="visibility" class="col-sm-2 col-form-label">Profile visibility</label>
                        <div class="col-sm-10">
                            <select class="form-control" v-model="user.visibility">
                                <option value="public">Public</option>
                                <option value="auth">Auth</option>
                                <option value="team">Team</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <button type="submit" class="btn btn-primary float-right" @click="update()">Update</button>
                </div>
            </div>

        </div>
    </div>
</div>
</template>

<script>

    import uploader from './uploader'

    export default {

        components: {

            uploader

        },

        data ()
        {
            return {
                user: undefined,
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            fetch ()
            {
                axios.get('/data/settings')
                .then((response) => {
                    console.log(response);
                    this.user = response.data
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            update ()
            {
                axios.post('/data/settings', {
                    name: this.user.name,
                    email: this.user.email,
                    visibility: this.user.visibility,
                })
                .then((response) => {
                    console.log('update settings')
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);

                    if (error.response) {
                        console.log(error.response)
                    }
                });
            },
        }

    }

</script>

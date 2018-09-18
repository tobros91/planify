<template>
<div class="container" v-if="user">
    <h3>Settings</h3>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <uploader @change="refreshImage()" />
                        <img class="card-img-top" :src="user.image_url">
                    </div>
                </div>

                <div class="col">

                    <input-text
                        type="text"
                        name="name"
                        label="Name"
                        v-model="user.name"
                        :error="errors.name"
                    />

                    <input-text
                        type="email"
                        name="email"
                        label="E-mail"
                        v-model="user.email"
                        :error="errors.email"
                    />

                    <!-- <input-select
                        name="visibility"
                        label="Profile visibility"
                        v-model="user.visibility"
                        :error="errors.visibility"
                        :options="[
                            {
                                value: 'public', text: 'Public'
                            },
                            {
                                value: 'auth', text: 'Auth'
                            },
                            {
                                value: 'team', text: 'Team'
                            },
                        ]"
                    /> -->

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
    import inputText from './form/input-text'
    import inputSelect from './form/input-select'

    export default {

        components: {
            uploader,
            inputText,
            inputSelect
        },

        data ()
        {
            return {
                user: undefined,
                errors: {}
            }
        },

        created ()
        {
            this.fetch()
        },

        methods: {

            refreshImage ()
            {
                console.log('do i run?')
                this.user.image_url = this.user.image_url+'?'+moment().unix()
            },

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
                    bus.$emit('flash', 'Your profile has been updated.')
                })
                .catch((error) => {
                    console.log(error.response);

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                });
            },
        }

    }

</script>

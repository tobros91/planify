<template>
<div class="row">
    <div class="col-1">
        <img class="img-fluid avatar" :src="auth.user.image_url">
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <textarea class="form-control" :class="{ 'is-invalid': errors.body }" rows="5" placeholder="Leave a comment" v-model="body"></textarea>
                    <div class="invalid-feedback" v-if="errors.body && errors.body[0]">
                        {{ errors.body[0] }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-right" :disabled="submited" @click="submit()">Comment</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>

    export default {

        props: {
            task: {}
        },

        data ()
        {
            return {
                body: '',
                submited: false,
                errors: {}
            }
        },

        methods: {

            submit ()
            {
                if (this.submited) {
                    return
                }

                this.submited = true
                this.errors = {}

                axios.post('/data/tasks/'+this.task.id+'/comment', {
                    body: this.body,
                })
                .then((response) => {
                    this.body = ''
                    this.submited = false
                    bus.$emit('flash', 'Comment posted')
                    this.$emit('submited')
                })
                .catch((error) => {
                    this.submited = false
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                });
            },

        }

    }

</script>

<template>
<div class="row">
    <div class="col">
        <div class="row mt-3">
            <div class="col-1">
                <img class="img-fluid avatar" :src="notification.data.user.image_url">
            </div>
            <div class="col">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <b>{{ notification.data.user.name }}</b> invited you to join their project {{ notification.data.project.title }}
                        </h5>

                        <h5 class="card-subtitle text-muted">"{{ notification.data.message }}"</h5>
                    </div>
                    <div class="card-body" v-if="notification.data.canRespond">
                        <button class="btn btn-success" @click="respond('accept')">Accept</button>
                        <button class="btn btn-danger" @click="respond('deny')">Deny</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</template>

<script>

    export default {

        props: {

            notification: {
                required: true
            }

        },

        data ()
        {
            return {

            }
        },

        methods: {

            respond (action)
            {
                axios.post('/data/projects/'+this.notification.data.project.id+'/respondToInvitation', {
                    action: action,
                })
                .then((response) => {
                    console.log(response.data);

                    if (action == 'accept') {
                        bus.$emit('flash', 'You are now a member of '+this.notification.data.project.title)
                        this.$router.push({ name: 'project-view', params: { project_id: this.notification.data.project.id } })
                        return
                    }

                    bus.$emit('flash', 'You rejected the invitation')
                    this.$store.dispatch('notifications/get')
                })
                .catch((error) => {
                    console.log(error.data);
                });
            }

        }

    }

</script>

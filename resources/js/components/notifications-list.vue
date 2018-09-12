<template>
<div class="container">

    <h1>Notifications</h1>

    <ul class="list-group mt-3">
        <li class="list-group-item" v-for="notification in notifications">
            <div class="row">
                <div class="col">
                    <h3>Invited to project {{ notification.data.project.title }} by user {{ notification.data.project.user_id }}</h3>

                    <div class="row" v-if="!notification.action_at">
                        <div class="col">
                            <button class="btn btn-success" @click="respond(notification, 'accept')">Accept</button>
                            <button class="btn btn-danger" @click="respond(notification, 'deny')">Deny</button>
                        </div>
                    </div>

                </div>
            </div>
        </li>
    </ul>
</div>
</template>

<script>

    export default {

        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            }

        },

        methods: {

            respond (notification, action)
            {
                axios.post('/data/projects/'+notification.data.project.id+'/teams/respond', {
                    action: action,
                    notification_id: notification.id
                })
                .then((response) => {
                    console.log(response.data);

                    if (action == 'accept') {
                        this.$router.push({ name: 'projects.view', params: { project_id: notification.data.project.id }})
                        return
                    }

                    this.$store.dispatch('notifications/get')

                })
                .catch((error) => {
                    console.log(error.data);
                });
            }

        }

    }

</script>

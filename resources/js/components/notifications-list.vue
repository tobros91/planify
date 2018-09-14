<template>
<div class="container">

    <h1>Notifications</h1>

    <ul class="list-group mt-3">

        <li class="list-group-item" v-for="notification in notifications">
            <div class="row">
                <div class="col">
                    <component :is="typeToComponent[notification.type]" :key="notification.id" :notification="notification"></component>
                </div>
                <div class="col-1">
                    <div class="btn btn-primary float-right" style="color: #fff;" title="Mark as read" @click="mark(notification)">
                        <i class="fa-bell" :class="{ 'far': notification.read_at, 'fas': !notification.read_at }"></i>
                    </div>
                </div>
            </div>
        </li>
        <li class="list-group-item" v-if="notifications.length === 0">
            No notifications
        </li>
    </ul>
</div>
</template>

<script>

    import invitedToProject from './notifications/invited-to-project'

    export default {

        components: {

            invitedToProject,

        },

        data ()
        {
            return {
                typeToComponent: {
                    'App\\Notifications\\InvitedToProject': 'invited-to-project'
                }
            }
        },

        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            }

        },

        methods: {

            mark (notification)
            {
                if (notification.read_at) {
                    return
                }

                axios.put('/data/notifications/'+notification.id+'/markAsRead')
                .then((response) => {
                    console.log('mark notification response')
                    console.log(response.data);
                    this.$store.dispatch('notifications/get')
                })
                .catch((error) => {
                    console.log(error);
                });
            }

        }

    }

</script>

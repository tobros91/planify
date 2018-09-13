<template>
<form class="form-inline">
    <div class="btn btn-primary" style="color: #fff;" :class="{ 'btn-info': onNotificationsPage }" @click="show()">
        <i class="fa-bell" :class="{ 'far': num_unread === 0, 'fas': num_unread > 0 }"></i>
    </div>
</form>
</template>

<script>

    export default {

        computed: {

            notifications ()
            {
                return this.$store.state.notifications.all
            },

            num_unread ()
            {
                return this.notifications.filter(notification => {
                    return !notification.read_at
                }).length
            },

            onNotificationsPage ()
            {
                return this.$route.name == 'notifications.list' ? true : false
            }

        },

        created ()
        {
            this.$store.dispatch('notifications/get')
        },

        methods: {

            show ()
            {
                this.$router.push({ name: 'notifications.list' })
            }

        }

    }

</script>

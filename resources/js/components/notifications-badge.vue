<template>
<form class="form-inline">
    <button type="button" class="btn btn-primary" :class="{ 'btn-info': num_unread > 0 }" @click="show()">
        <i class="fas fa-bell"></i>
    </button>
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

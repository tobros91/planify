<template>
<div class="row">
    <div class="col">
        <h3>Comment posted in task {{ notification.data.task.title }}</h3>
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



        }

    }

</script>

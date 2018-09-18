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
                            <b>{{ notification.data.user.name }}</b> kicked you from {{ notification.data.project.title }}
                        </h5>
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



        }

    }

</script>

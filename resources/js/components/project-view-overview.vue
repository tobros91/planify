<template>
<div class="container">
    <div class="card">
        <div class="card-body">
            {{ project.description }}
        </div>
    </div>
</div>
</template>

<script>

    export default {

        computed: {

            project ()
            {
                return this.$store.state.project.project
            }

        },

    }

</script>

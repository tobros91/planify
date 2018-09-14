<template>
<div id="messageBar" :class="{ visible: messages.length > 0 }">
    <div class="message" v-for="message in messages">
        {{ message }}
    </div>
</div>
</template>

<script>
    export default {
        data ()
        {
            return {
                messages: [],
            }
        },
        created ()
        {
            bus.$on('flash', (text) => {
                this.messages.push(text)
                setTimeout(() => { this.messages.shift() }, 6000)
            })
        }
    }
</script>

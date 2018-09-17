<template>
<div class="list-group mt-3">

    <div class="list-group-item">
        <div class="textLoadingBar" style="width: 95%;" :style="'height: '+height+'px'"></div>
    </div>

    <div class="list-group-item">
        <div class="textLoadingBar" style="width: 60%;" :style="'height: '+height+'px'"></div>
    </div>

    <div class="list-group-item">
        <div class="textLoadingBar" style="width: 85%;" :style="'height: '+height+'px'"></div>
    </div>

    <div class="list-group-item">
        <div class="textLoadingBar" style="width: 75%;" :style="'height: '+height+'px'"></div>
    </div>

</div>
</template>

<script>

    export default {

        props: {

            height: {}

        },

    }

</script>

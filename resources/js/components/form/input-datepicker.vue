<template>
<div class="form-group row">

    <label :for="name" class="col-sm-2 col-form-label">{{ label }}</label>
    <div class="col-sm-10">

        <datepicker
            :value="value"
            @input="$emit('input', $event)"
            :disabledDates="disabledDates"
            :input-class="{ 'is-invalid': error }"
            format="yyyy-MM-dd"
            :monday-first="true"
            :bootstrap-styling="true">

            <div slot="afterDateInput" class="invalid-feedback" v-if="error">
                {{ error[0] }}
            </div>

        </datepicker>

    </div>

</div>
</template>

<script>

    import datepicker from 'vuejs-datepicker';

    export default {

        components: {
            datepicker,
        },

        props: {
            value: {},
            disabledDates: {},
            type: {},
            name: {},
            label: {},
            error: {},
        },

        computed: {

            isInvalid ()
            {
                return this.error ? 'is-invalid' : ''
            }

        }
    }

</script>

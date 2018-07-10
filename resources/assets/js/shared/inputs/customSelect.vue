<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <select class="form-control input-sm" @input="onInput" :required="required">
            <option v-for="option in options" :value="option.value" :selected="option.selected" :disabled="option.disabled" :style="option.style" >{{ option.text }}</option>
        </select>
    </div>
</template>
<script>
    export default {
        props: {
            label: '',
            required: '',
            options: {
                type: Array,
                required: true
            }
        },
        methods: {
            onInput: function (event) {
                this.$emit('input', event.target.value)
            }
        }
    }
</script>
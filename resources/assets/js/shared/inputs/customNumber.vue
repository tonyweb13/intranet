<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <input ref="input" class="form-control input-sm" type="number" :value="value" :required="required"
               @input="updateValue($event.target.value)"/>
    </div>
</template>
<script>
    export default {
        props: ['label','value','required'],
        methods: {
            updateValue: function (value) {
                var formattedValue = value.trim()
                this.$emit('input', Number(formattedValue))
            }
        }
    }
</script>
<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <textarea class="form-control input-sm" :value="value" @input="onInput" :required="required"></textarea>
    </div>
</template>
<script>
    import sharedInputMixin from '../../mixins/sharedInputMixins'

    export default {
        mixins: [ sharedInputMixin ],
    }
</script>
<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <input class="form-control input-sm" type="email" :value="value" @input="onInput" :required="required"/>
    </div>

</template>
<script>
    import sharedInputMixin from '../../mixins/sharedInputMixins'

    export default {
        mixins: [ sharedInputMixin ],
    }
</script>
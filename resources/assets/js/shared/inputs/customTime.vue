<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <input class="form-control" type="time" :value="value" @input="onInput" :required="required"/>
    </div>

</template>
<script>
    import sharedInputMixin from '../../mixins/sharedInputMixins'

    export default {
        mixins: [ sharedInputMixin ],
    }
</script>
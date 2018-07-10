<template>
    <div>
        <label>{{ label }}</label>
        <div class="form-group">
            <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-sm" :value="value" @input="onInput" :required="required" placeholder="YYYY-MM-DD">
            </div>
        </div>
    </div>
</template>
<script>
    import sharedInputMixin from '../../mixins/sharedInputMixins'

    export default {
        mixins: [ sharedInputMixin ],

    }
</script>
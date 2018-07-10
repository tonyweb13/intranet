<template>
    <input class="form-control input-sm" style="float: right; width: 350px;" type="text" id="search-element" placeholder="Search Here..." :value="value" @input="onInput"/>
</template>
<script>
    import sharedInputMixin from '../../mixins/sharedInputMixins'

    export default {
        mixins: [ sharedInputMixin ],
    }
</script>
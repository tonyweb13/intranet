<template>
    <div class="pull-right" style="margin-top: 56px; margin-left: 10px;">
        <button class="ladda-button btn btn-primary " type="submit" :disabled="disabled" data-color="mint" data-style="slide-right">Save</button>
    </div>
</template>
<script>
    export default {
        props: ['disabled']
    }
</script>

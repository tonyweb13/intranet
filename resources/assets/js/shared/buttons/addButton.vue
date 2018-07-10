<template>
    <div class="pull-right m-t-n-sm p-b-m">
        <button class='pull-left btn btn-default' @click="$emit('add')" >
            <i class="fa fa-plus"></i> Add {{ textToAdd }}
        </button>
    </div>
</template>
<script>
    export default {
        props: {
            textToAdd: {
                type: String,
                required: true,
            },
        },
    }
</script>

<template>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times"></i></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">{{ title }}</h4>
        <template v-if="note">
            <small class="font-bold">{{ note }}</small>
        </template>
        <br>
        <template v-if="description">
            <small class="font-bold">{{ description }} </small>
        </template>
    </div>
</template>
<script>
    'use strict';

    export default {
        name: 'modalHeader',
        props: {
            title: {
                type: String,
                default: ''
            },
            note: {
                type: String,
                default: ''
            },
            description: {
                type: String,
                default: ''
            }
        }
    }
</script>
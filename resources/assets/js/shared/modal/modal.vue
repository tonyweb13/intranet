<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper "  :class="modalClass">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header"/>
                    </div>
                    <div class="modal-body p-b-m">
                        <slot name="body" />
                    </div>
                    <div class="modal-footer" name="modal-footer">
                        <div class="pull-right">
                            <slot name="footer"/>
                            <button v-if="!btnProps && employee.is_default_password == 0" class="btn btn-default" @click="$emit('close')">Close </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<style scoped>
    .modal-footer .btn+.btn {
        margin-bottom: 5px !important;
    }
</style>

<script>

'use strict'

export default {
    name: 'modal',
    props: {
        btnProps: Boolean,
        modalClass : '',
    },
}

</script>
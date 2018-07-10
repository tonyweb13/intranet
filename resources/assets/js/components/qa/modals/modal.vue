<template>
    <div class="modal inmodal fade in" id="dual-list" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="height: 800px">
                <modal-header :title="title" :note="note" :positionDescription="positionDescription" />
                <modal-body :descriptions="descriptions" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary transaction">Continue . . .</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    'use strict';

    import 'bootstrap/js/modal.js';
    import ModalHeader from 'modalHeader.vue';
    import ModalBody from 'modalBody.vue';
    import Descriptions from 'descriptions';

    export default {
        name: 'modal',
        components: {ModalHeader, ModalBody},
        data() {
            return {
                descriptions: Descriptions.items,
                title: 'Descriptions',
                note: 'You can specify the applicable description for the agent accordingly.',
                positionDescription: 'Loan Agent Descriptions'
            }
        }
    }
</script>
<template>
    <div class="modal-body">
        <div class="ibox-content">
            <form class="form-horizontal">
                <input type="hidden"/>
                <select class="form-control dual_select">
                    <template v-for="(description, index) in descriptions">
                        <option value="index">{{ description }}</option>
                    </template>
                </select>
            </form>
        </div>
    </div>
</template>
<script>
    'use strict';

    export default {
        name: 'modalBody',
        props: {
            descriptions: {
                type: Array,
                required: true,
                default: () => []
            }
        }
    }
</script>
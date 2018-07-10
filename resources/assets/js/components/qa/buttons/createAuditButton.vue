<template>
    <div class="input-group-btn">
        <button class="btn btn-primary create-audit" type="button" @click="createAudit">
            <span><i class="fa fa-edit"></i></span> Create Audit Form
        </button>
    </div>
</template>
<script>
    'use strict';

    export default {
        name: 'createAuditButton',
        props: ['createAudit']
    }
</script>
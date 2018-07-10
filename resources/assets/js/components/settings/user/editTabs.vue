<template>
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-edit" aria-expanded="true"> Edit Employee</a></li>
            <li class=""><a data-toggle="tab" href="#tab-acl" aria-expanded="false">ACL Rules</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-edit" class="tab-pane active">
                <edit/>
            </div>
            <div class="clearfix"></div>

            <div id="tab-acl" class="tab-pane">
                <acl/>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</template>
<script>
    import edit from '../../../components/settings/user/edit.vue'
    // import acl from '../../../components/settings/user/acl.vue'
    import acl from '../../../components/settings/user/aclUsr.vue'
    export default {
        components:{ edit, acl },
    }
</script>
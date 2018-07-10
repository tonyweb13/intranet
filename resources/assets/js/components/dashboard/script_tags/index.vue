<template>
    <div class="ibox-content">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-script-form" aria-expanded="true">Scripting Tags</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-script-list" aria-expanded="false">List of Scripting Tags</a></li>
                </ul>
                <div class="tab-content">
                    <div class="clearfix"></div>
                    <div id="tab-script-form" class="tab-pane active">
                        <script-form/>
                    </div>
                    <div class="clearfix"></div>
                    <div id="tab-script-list" class="tab-pane">
                        <list-form/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
</template>
<script>
    import scriptForm from './form.vue'
    import listForm from './list.vue'

    export default {
        components: { scriptForm, listForm }
    }
</script>
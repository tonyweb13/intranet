<template>
    <div class="ibox-content">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <!--<li class="active"><a data-toggle="tab" href="#tab-reassignment" aria-expanded="true"> App Re-Assignment</a></li>-->
                <li class="active"><a data-toggle="tab" href="#tab-history" aria-expanded="false">Available App for Reassignment</a></li>
            </ul>
            <div class="tab-content">
                <div class="clearfix"></div>
                <!--<div id="tab-reassignment" class="tab-pane active">-->
                    <!--&lt;!&ndash;<re-assign/>&ndash;&gt;-->
                <!--</div>-->
                <div class="clearfix"></div>
                    <div id="tab-history" class="tab-pane active">
                        <list-form/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</template>
<script>
    import listForm from './list.vue'

    export default {
        components: { listForm },
        data: function () {
            return {

            }
        },
    }
</script>
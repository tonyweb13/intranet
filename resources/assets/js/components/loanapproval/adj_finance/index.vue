<template>
    <div>
        <div class="ibox-content">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-personal" aria-expanded="true"> List of Adj Finance Fee</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-employment" aria-expanded="false">Adjustments List</a></li>
                </ul>
                <div class="tab-content">
                    <div class="clearfix"></div>
                    <div id="tab-personal" class="tab-pane active">
                        <adj-finance/>
                    </div>
                    <div class="clearfix"></div>
                     <div id="tab-employment" class="tab-pane">
                         <list-form/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import adjFinance from './form.vue'
    import listForm from './list.vue'

    export default {
        components: { adjFinance, listForm },
        data: function () {
            return {

            }
        },
    }

</script>
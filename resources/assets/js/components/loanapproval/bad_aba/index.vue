<template>
    <div>
        <div class="ibox-content">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-personal" aria-expanded="true"> List of Bad ABA Number</a></li>
                </ul>
                <div class="tab-content">
                    <div class="clearfix"></div>
                    <div id="tab-personal" class="tab-pane active">
                        <aba-table/>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import abaTable from './table.vue'

    export default {
        components: { abaTable },
        data: function () {
            return {

            }
        },
    }

</script>
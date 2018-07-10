<template>
    <div>
        <div class="ibox-content">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-personal" aria-expanded="true">Ticketing Form</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-employment" aria-expanded="false">List of Tickets</a></li>
                </ul>
                <div class="tab-content">
                    <div class="clearfix"></div>
                    <div id="tab-personal" class="tab-pane active">
                        <ticket-form/>
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
    import ticketForm from './form.vue'
    import listForm from './list.vue'

    export default {
        components: { ticketForm, listForm },
        data: function () {
            return {

            }
        },
    }
</script>
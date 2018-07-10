
<template>


    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Application Form <small class="m-l-sm">Please fill in all the needed information before submit</small></h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>

            </div>
        </div>
        <div class="ibox-content">
            <div id="application_form">
                <app_form/>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="ibox-footer">

        </div>
    </div>

        <!--<div class="tabs-container">-->
        <!--<ul class="nav nav-tabs">-->
            <!--<li class="active"><a data-toggle="tab" href="#application_form">Application Form</a></li>-->
        <!--</ul>-->
        <!--<div class="tab-content">-->

            <!--<div class="clearfix"></div>-->
        <!--</div>-->
    <!--</div>-->

</template>
<script>        
    // import application_form from '../loanapproval/components/mainForm.vue'
    import app_form from '../loanapproval/components/form.vue'

    export default {
        components: { app_form},
        data(){
            return {

            }
        },       
        created() {

        },
        mounted() {

            let app_list = this.$refs;

            $('.nav-tabs').stickyTabs();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href"); // activated tab
                switch (target) {
                    case '#tab-queue' :

                        console.log('get list tab queue');
                        app_list.app_queue.getList();

                        break;
                    case '#tab-pending' :
                        console.log('get list tab pending');
                        app_list.app_pending.getList();
                        break;
                    case '#tab-approved' :
                        console.log('get list tab approved');
                        app_list.app_approved.getList();
                        break;
                    case '#tab-correction' :
                        console.log('get list tab correction');
                        app_list.app_correction.getList();
                        break;
                    case '#tab-disapproved' :
                        console.log('get list tab deny');
                        app_list.app_deny.getList();
                        break;
                }



            });
        },
    }

</script>
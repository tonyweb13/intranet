<template>
    <mainPage>
        <form @submit="deleteApplication">
            <div class="col-lg-6">
                <ibox title="Are you sure you want to delete?">
                    <custom-label label="App Number:" :p='application.app_number' />
                    <custom-label label="States:" :p='application.states' />
                    <custom-label label="Portfolio:" :p='application.portfolio' />
                    <custom-label label="Downloads:" :p='application.downloads' />
                    <custom-label label="New or Return:" :p='application.new_or_return' />
                    <custom-label label="End of Billing:" :p='application.end_of_billing' />
                    <custom-label label="Pay Type:" :p='application.pay_type' />
                    <custom-label label="Exception:" :p='application.exceptions' />
                    <delete-confirm-button/>
                    <cancel-button :to="{path: '/loanapproval/application'}"/>
                </ibox>
            </div>
            <div class="col-lg-6">
                <div class="ibox-title">
                    <h4>Verification Of Bank</h4>
                </div>
                <div class="ibox-content" style="height: 520px;">
                    <div class="col-lg-6">
                        <custom-label label="DDL 1:" :p='application.ddl1' required/>
                        <custom-label label="DDL 2:" :p='application.ddl2' />
                        <custom-label label="DDL 3:" :p='application.ddl3' />
                        <custom-label label="DDL 4:" :p='application.ddl4' />
                        <custom-label label="DDL 5:" :p='application.ddl5' />
                        <custom-label label="DDL 6:" :p='application.ddl6' />
                    </div>
                    <div class="col-lg-6">
                        <custom-label label="EOD 1:" :p='application.eod1' required/>
                        <custom-label label="EOD 2:" :p='application.eod2' />
                        <custom-label label="EOD 3:" :p='application.eod3' />
                        <custom-label label="EOD 4:" :p='application.eod4' />
                        <custom-label label="EOD 5:" :p='application.eod5' />
                        <custom-label label="EOD 6:" :p='application.eod6' />
                    </div>
                </div>
            </div>
        </form>
    </mainPage>
</template>
<script>
    import axios from 'axios'
    import mainPage from '../../mainPage.vue'
    import ibox from '../../../shared/customHtml/ibox.vue'
    import CancelButton from '../../../shared/buttons/cancelButton.vue'
    import DeleteConfirmButton from '../../../shared/buttons/deleteConfirmButton.vue'
    import CustomLabel from '../../../shared/customHtml/customLabel.vue'

    export default {
        components: { mainPage, ibox, DeleteConfirmButton, CancelButton, CustomLabel },
        data: function () {
            return {
                application: {},
            };

        },
        methods: {
            deleteApplication: function () {
                axios.delete("/api/loanapproval/application/"+this.$route.params.application_id)
                    .then(response => {
                        this.applications = response.data;
                    });
                this.$router.push('/loanapproval/application');
            }
        },
        created() {
            axios.get("/api/loanapproval/application/"+this.$route.params.application_id)
                .then(response => {
                    this.application = response.data;
                });
        },
    }
</script>
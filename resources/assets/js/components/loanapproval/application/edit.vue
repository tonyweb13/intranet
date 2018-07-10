<template>
    <mainPage>
        <form @submit="updateApplication">
            <div class="col-lg-6">
                <ibox title="Edit Application Form">
                        <custom-number label="App Number:" v-model="application.app_number" required/>
                        <custom-select label="States:" v-model="application.states" :options="selectedStates" required/>
                        <custom-select label="Portfolio:" v-model="application.portfolio" :options="selectedPortfolio" required/>
                        <custom-text label="Downloads:" v-model="application.downloads" required/>
                        <custom-select label="New or Return:" v-model="application.new_or_return" :options="selectedNewOrReturn" required/>
                        <custom-datepicker label="End of Billing:" id="addEndOfBilling" v-model="application.end_of_billing" required/>
                        <custom-select label="Pay Type:" v-model="application.pay_type" :options="selectedPayType" required/>
                        <custom-select label="Exception:" v-model="application.exceptions" :options="selectedException" required/>
                        <save-button/>
                        <cancel-button :to="{path: '/loanapproval/application'}" />
                    </ibox>
            </div>
            <div class="col-lg-6">
                    <div class="ibox-title">
                        <h4>Verification Of Bank</h4>
                    </div>
                    <div class="ibox-content" style="height: 650px;">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>DDL</label>
                            </div>
                            <custom-text v-model="application.ddl1" required/>
                            <custom-text v-model="application.ddl2" />
                            <custom-text v-model="application.ddl3" />
                            <custom-text v-model="application.ddl4" />
                            <custom-text v-model="application.ddl5" />
                            <custom-text v-model="application.ddl6" />
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>EOD</label>
                            </div>
                            <custom-text v-model="application.eod1" required/>
                            <custom-text v-model="application.eod2" />
                            <custom-text v-model="application.eod3" />
                            <custom-text v-model="application.eod4" />
                            <custom-text v-model="application.eod5" />
                            <custom-text v-model="application.eod6" />
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
    import SaveButton from '../../../shared/buttons/saveButton.vue'
    import CancelButton from '../../../shared/buttons/cancelButton.vue'
    import customText from '../../../shared/inputs/customText.vue'
    import customNumber from '../../../shared/inputs/customNumber.vue'
    import customDatepicker from '../../../shared/inputs/customDatepicker.vue'
    import customTextarea from '../../../shared/inputs/customTextarea.vue'
    import customSelect from '../../../shared/inputs/customSelect.vue'

    export default {
        components: { mainPage, ibox, SaveButton, CancelButton, customText, customNumber, customTextarea, customSelect, customDatepicker },
        data: function () {
            return {
                application: {},
                selectedStates: [],
                selectedPortfolio: [],
                selectedPayType: [],
                selectedNewOrReturn: [],
                selectedException: [],
            };
        },
        methods: {
            updateApplication: function () {
                let application = this.application;

                axios.get("/api/loanapproval/application/"+this.$route.params.application_id, {
                    params: {
                        app_number: application.app_number,
                        states: application.states,
                        portfolio: application.portfolio,
                        downloads: application.downloads,
                        new_or_return: application.new_or_return,
                        end_of_billing: application.end_of_billing,
                        pay_type: application.pay_type,
                        exceptions: application.exceptions,
                        ddl1: application.ddl1,
                        ddl2: application.ddl2,
                        ddl3: application.ddl3,
                        ddl4: application.ddl4,
                        ddl5: application.ddl5,
                        ddl6: application.ddl6,
                        eod1: application.eod1,
                        eod2: application.eod2,
                        eod3: application.eod3,
                        eod4: application.eod4,
                        eod5: application.eod5,
                        eod6: application.eod6,
                    }
                })
                    .then(response => {
                    this.application = response.data;
                });

                this.$router.push('/loanapproval/application');
            }
        },
        created() {
            axios.get("/api/loanapproval/application/"+this.$route.params.application_id+"/edit")
                .then(response => {
                    this.application = response.data;
                    if(this.application.states){
                        this.selectedStates =
                            [
                                { text: this.application.states, value: this.application.states, selected: 'selected', disabled: 'disabled', style: 'background: #ccc;'},
                                { text: 'New York', value: 'New York'},
                                { text: 'Las Vegas', value: 'Las Vegas'},
                            ];
                    }

                    if(this.application.portfolio){
                        this.selectedPortfolio =
                            [
                                { text: this.application.portfolio, value: this.application.portfolio, selected: 'selected', disabled: 'disabled', style: 'background: #ccc;'},
                                { text: 'Nortern Plains', value: 'Nortern Plains'},
                                { text: 'Send Loan', value: 'Send Loan'},
                                { text: 'Inbox Loan', value: 'Inbox Loan'},
                            ];
                    }

                    if(this.application.pay_type){
                        this.selectedPayType =
                            [
                                { text: this.application.pay_type, value: this.application.pay_type, selected: 'selected', disabled: 'disabled', style: 'background: #ccc;'},
                                { text: 'Weekly', value: 'Weekly'},
                                { text: 'Semi-Monthly', value: 'Semi-Monthly'},
                                { text: 'Monthly', value: 'Monthly'},
                            ];
                    }

                    if(this.application.new_or_return){
                        this.selectedNewOrReturn =
                            [
                                { text: this.application.new_or_return, value: this.application.new_or_return, selected: 'selected', disabled: 'disabled', style: 'background: #ccc;'},
                                { text: 'Yes', value: 'Yes' },
                                { text: 'No', value: 'No' },
                            ];
                    }

                    if(this.application.exceptions){
                        this.selectedException =
                            [
                                { text: this.application.exceptions, value: this.application.exceptions, selected: 'selected', disabled: 'disabled', style: 'background: #ccc;'},
                                { text: 'Yes', value: 'Yes' },
                                { text: 'No', value: 'No' },
                            ];
                    }
                });
        },
        mounted(){
            $("#editEndOfBilling > div.form-group > div.input-group > input[type='text']").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true
                }
            ).on(
                "changeDate", () => {
                    this.application.end_of_billing = $("#editEndOfBilling > div.form-group > div.input-group > input[type='text']").val();
                }
            );
        }
    }
</script>
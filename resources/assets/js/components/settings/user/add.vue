<template>
    <form-wizard @on-complete="onComplete" shape="circle" color="#42b983" error-color="#ff4949">
        <h2 slot="title">Add Employee</h2> 
        <tab-content title="Account details" icon="fa fa-users"
                :before-change="() => validate('firstStep')">
            <first-step ref="firstStep" @on-validate="onStepValidate"></first-step>

        </tab-content>
        <tab-content title="Personal Details" icon="fa fa-user"
                :before-change="() => validate('secondStep')">
            <second-step ref="secondStep" @on-validate="onStepValidate"></second-step>
        </tab-content>

        <tab-content title="Contact Details" icon="fa fa-wrench"
                :before-change="() => validate('thirdStep')">
            <third-step ref="thirdStep" @on-validate="onStepValidate"></third-step>
        </tab-content>

        <tab-content title="Additional Details" icon="fa fa-check"
                :before-change="() => validate('fourthStep')">
            <fourth-step ref="fourthStep" @on-validate="onStepValidate"></fourth-step>
        </tab-content>
        
        <template slot="footer" slot-scope="props">
            <div class=wizard-footer-left>
                <wizard-button @click.native="props.prevTab()" v-if="props.activeTabIndex > 0" :style="props.fillButtonStyle">Previous</wizard-button>
                <wizard-button v-else :style="props.fillButtonStyle" @click.native="exit">Cancel</wizard-button>
            </div>
            <div class="wizard-footer-right">
                <wizard-button @click.native="props.nextTab()" class="wizard-footer-right ladda-button"  data-color="mint" data-style="slide-right" :style="props.fillButtonStyle">{{props.isLastStep ? 'Submit' : 'Next'}}</wizard-button>
            </div>
        </template>
    </form-wizard>
</template>

<script>
    "use strict"
    import axios from 'axios'
    import firstStep from '../../../components/settings/user/account.vue'
    import secondStep from '../../../components/settings/user/personal.vue'
    import thirdStep from '../../../components/settings/user/contact.vue'
    import fourthStep from '../../../components/settings/user/additional.vue'
    import { FormWizard, WizardButton, TabContent } from "vue-form-wizard";
    import "vue-form-wizard/dist/vue-form-wizard.min.css";
    import "element-ui/lib/theme-chalk/index.css";
    
    export default {
        components: { Element, FormWizard, WizardButton, TabContent, firstStep, secondStep, thirdStep, fourthStep },      
        data() {
            return {
                laddabtn : '',
                finalModel: {}
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            validate(ref) {
               return this.$refs[ref].validate()
            },
            onStepValidate(validated, model){
                if(validated){
                    this.finalModel = {...this.finalModel, ...model}
                }
            },
            exit : function () {
                this.$emit('event', false);
            },           
            onComplete: function(){
                this.laddabtn.start();
                let finalModel = this.finalModel;
                axios.get("/api/settings/employee/create", {
                    params: {
                        emp_no : finalModel.emp_no,
                        user: finalModel.username,
                        password: finalModel.pass,
                        email : finalModel.email,
                        fname : finalModel.fname,
                        lname : finalModel.lname,
                        mname : finalModel.mname,
                        bday : finalModel.bday,
                        mnumber: finalModel.mnumber,
                        school: finalModel.school,
                        ygraduate: finalModel.ygraduate,
                        banktype: finalModel.banktype,
                        accountno: finalModel.accountno,
                        person_to_contact_in_case_of_emergency: finalModel.emergency,
                        contact_person_no: finalModel.cnumber,
                        relationship: finalModel.relationship
                    }
                }).then(response => {
                    this.laddabtn.stop();
                    this.$bus.$emit('init_modal', false);
                    this.finalModel = response.data;
                    swal({
                        text: 'Saved!',
                        type: "success",
                    });
                    this.$bus.$emit('updateList');
                }).catch(error => {
                    console.log(error)
                });
            },            
        },
    }
</script>
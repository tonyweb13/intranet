<template>
    <div class="panel-body">
        <div class="row col-lg-5">
            <form @submit.prevent="submitAssign">
                 <form-group label="Portfolio ID">
                    <div class="asterisk_label">*</div>
                    <vSelect name="is enable"
                            v-model="assign.portfolio"
                            :options="selectedIsEnable"
                            label="text"
                            v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('portfolio')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('portfolio')" class="help is-danger">{{ errors.first('portfolio') }}</span>
                </form-group>
                <form-group label="Loan ID">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="loan_id"  autocomplete="off" type="text" maxlength="12" v-on:change="onChange" v-model="assign.loan_id" :class="{'input': true, 'is-danger': errors.has('loan_id') }" >
                    <div class="pull-right">
                        <i v-show="errors.has('loan_id')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('loan_id')" class="help is-danger">{{ errors.first('loan_id') }}</span>
                </form-group>
                <form-group label="Current Status">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="current_status" type="text" v-model="assign.current_status" 
                    v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('current_status') }" disabled>
                    <div class="pull-right">
                        <i v-show="errors.has('current_status')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('current_status')" class="help is-danger">{{ errors.first('current_status') }}</span>
                </form-group>
                <form-group label="Current Owner">
                    <div class="asterisk_label">*</div>
                    <input class="form-control input-sm" name="current_approver" type="text" v-model="assign.current_approver" 
                    v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('current_approver') }" disabled>
                    <div class="pull-right">
                        <i v-show="errors.has('current_approver')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('current_approver')" class="help is-danger">{{ errors.first('current_approver') }}</span>
                </form-group>
                <form-group label="Reassign to Approver">
                    <div class="asterisk_label">*</div>
                     <vSelect name="reassign_approver"
                            label="full_name"
                            v-model="assign.reassign_approver"
                            :options="users"
                            value="id"
                            data-vv-as="Reassign to Approver"
                            v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('reassign_approver')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('reassign_approver')" class="help is-danger">{{ errors.first('reassign_approver') }}</span>
                </form-group>
                <save-button :disabled='!isComplete' />
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        data: function (){
            return {
                assign: {
                    portfolio: '',
                    portfolio_id: '',
                    loan_id: '',
                    current_status: '',
                    current_approver: '',
                    reassign_approver: ''
                },
                selectedIsEnable: [],
                users: [],
                laddabtn : '',
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },

        computed: {
            isComplete () {
                return this.assign.portfolio && this.assign.loan_id && 
                    this.assign.current_status && this.assign.current_approver 
                    && this.assign.reassign_approver;
            },
        },

        created() {
            this.getPorfolio();
            this.getUsers();
        },

        methods: {
            getPorfolio: function () {
                this.$constants.Settings_API.get('/portfolio/dropdown')
                    .then(response => {
                        this.selectedIsEnable  = response.data;
                    });
            },
            getUsers: function () {
                this.$constants.Settings_API.get('/employee_dropdown/dropdown')
                    .then(response => {
                        this.users  = response.data;
                    });
            },
            onChange: function () {
                console.log(this.assign.loan_id);
                if (this.assign.loan_id != '') {

                    this.$constants.LoanApp_API.get('/reassignapp/getloan/' + this.assign.loan_id)
                    .then(response => {
                        console.log(response.data.error );
                        if(response.data.error == false  ) {
                            this.assign.current_status  = response.data.status;
                            this.assign.current_approver = response.data.application_process[0].full_name;
                        } else {
                            swal({
                                text: 'Unable find Application please check the loan id',
                                type: "error",
                            });
                            this.assign.current_status = '';
                            this.assign.current_approver = '';
                        }
                    });

                }

            },
            submitAssign: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let assign = this.assign;
                        let getAxios = '';

                        getAxios = this.$constants.LoanApp_API.get("/reassignapp/create", {
                            params: {
                                portfolio_id: assign.portfolio.text,
                                loan_id: assign.loan_id,
                                current_status: assign.current_status,
                                current_approver: assign.current_approver,
                                reassign_approver: assign.reassign_approver
                            }
                        });

                        getAxios.then(response => {
                            this.laddabtn.stop();                            
                            this.$bus.$emit('getReAssign');
                            this.assign.portfolio = null;
                            this.assign.loan_id = null;
                            current_status = null;
                            current_approver = null;
                            reassign_approver = null;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                        }).then(() => {
                            this.$validator.reset();
                        }).catch(error => {
                            this.laddabtn.stop();
                            swal({
                                text: error,
                                type: "error",
                            });
                        });
                    }
                })
            }
        }
    }
</script>
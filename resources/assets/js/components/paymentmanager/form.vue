<template>   
    <form @submit.prevent="addChanges">
            <form-group label="Loan ID">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="loan id" type="text" placeholder="Loan ID"
                    v-model="changes.loan_id" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('loan id') }" >
                <div class="pull-right">
                    <i v-show="errors.has('loan id')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('loan id')" class="help is-danger">{{ errors.first('loan id') }}</span>
            </form-group>
            <form-group label="Customer Last Name">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Customer Last Name" type="text" placeholder="Customer Last Name"
                    v-model="changes.last_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Customer Last Name') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Customer Last Name')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Customer Last Name')" class="help is-danger">{{ errors.first('Customer Last Name') }}</span>
            </form-group>
            <form-group label="Request Type">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Request Type" type="text" placeholder="Request Type"
                    v-model="changes.request_type" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Request Type') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Request Type')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Request Type')" class="help is-danger">{{ errors.first('Request Type') }}</span>
            </form-group>
            <form-group label="Effective Date">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Effective Date" type="text" placeholder="Effective Date"
                    v-model="changes.effective_date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Effective Date') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Effective Date')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Effective Date')" class="help is-danger">{{ errors.first('Effective Date') }}</span>
            </form-group>
            <form-group label="Confirmed Amount">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Confirmed Amount" type="text" placeholder="Confirmed Amount"
                    v-model="changes.confirmed_amount" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Confirmed Amount') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Confirmed Amount')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Confirmed Amount')" class="help is-danger">{{ errors.first('Confirmed Amount') }}</span>
            </form-group>
            <form-group label="Confirmed Date">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Confirmed Date" type="text" placeholder="Confirmed Date"
                    v-model="changes.confirmed_date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Confirmed Date') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Confirmed Date')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Confirmed Date')" class="help is-danger">{{ errors.first('Confirmed Date') }}</span>
            </form-group>
            <form-group label="Employee Name">
                <div class="asterisk_label">*</div>
                <input class="form-control input-sm" name="Employee Name" type="text" placeholder="Employee Name"
                    v-model="changes.employee_name" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('Employee Name') }" >
                <div class="pull-right">
                    <i v-show="errors.has('Employee Name')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('Employee Name')" class="help is-danger">{{ errors.first('Employee Name') }}</span>
            </form-group>
            <form-group label="Status">
                <vSelect name="Status"
                        v-model="changes.status"
                        :options="status_"
                        label="text"
                />
            </form-group>
            <form-group label="Payment Type">
                <vSelect name="Payment Type"
                        v-model="changes.payment_type"
                        :options="paymentType"
                        label="text"
                />
            </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            changeProps: Object,
        },
        data: function () {
            return {
                changes: {
                    loan_id: '',
                    last_name: '',
                    request_type: '',
                    effective_date: '',
                    confirmed_amount: '',
                    confirmed_date: '',
                    employee_name: '',
                    status: '',
                    payment_type: ''
                },
                status_: [
                    { text: 'Completed', value: 0 },
                    { text: 'Pending', value: 1 },
                    { text: 'Rejected', value: 2 },
                ],
                paymentType: []
            }
        },
        created() {
            this.fetchPaymentType();

            if(this.changeProps.loan_id){
                this.changes.loan_id = this.changeProps.loan_id;
                this.changes.last_name = this.changeProps.last_name;
                this.changes.request_type = this.changeProps.request_type;
                this.changes.effective_date = this.changeProps.effective_date;
                this.changes.confirmed_amount = this.changeProps.confirmed_amount;
                this.changes.confirmed_date = this.changeProps.confirmed_date;
                this.changes.employee_name = this.changeProps.employee_name;
                this.changes.status = this.changeProps.status;
                this.changes.payment_type = this.changeProps.payment_type;
             
            } else {
                this.changes.loan_id = '';
                this.changes.last_name = '';
                this.changes.request_type = '';
                this.changes.effective_date = '';
                this.changes.confirmed_amount = '';
                this.changes.confirmed_date = '';
                this.changes.employee_name = '';
                this.changes.status = '';
                this.changes.payment_type = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.changes.loan_id 
                && this.changes.loan_id 
                && this.changes.last_name 
                && this.changes.request_type 
                && this.changes.effective_date 
                && this.changes.confirmed_amount
                && this.changes.confirmed_date
                && this.changes.employee_name
                && this.changes.status
                && this.changes.payment_type ;
            },
        },
        methods: {
            fetchPaymentType: function () {
                this.$constants.PaymentManager_API.get("/paymenttype/dropdown")
                    .then(response => {
                        this.paymentType = response.data;
                    });
            },
            addChanges: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let changes = this.changes;
                        let getAxios = '';

                        if(this.changeProps.loan_id){

                            getAxios = this.$constants.PaymentManager_API.get("/paymentchanges/"+this.changeProps.loan_id, {
                                params: {
                                            loan_id: changes.loan_id,
                                            last_name: changes.last_name,
                                            request_type: changes.request_type,
                                            effective_date: changes.effective_date,
                                            confirmed_amount: changes.confirmed_amount,
                                            confirmed_date: changes.confirmed_date,
                                            employee_name: changes.employee_name,
                                            status: changes.status.value,
                                            payment_type: changes.payment_type.value
                                        }
                            });

                        } else {

                            getAxios = this.$constants.PaymentManager_API.get("/paymentchanges/create", {
                                params: {
                                    loan_id: changes.loan_id,
                                    last_name: changes.last_name,
                                    request_type: changes.request_type,
                                    effective_date: changes.effective_date,
                                    confirmed_amount: changes.confirmed_amount,
                                    confirmed_date: changes.confirmed_date,
                                    employee_name: changes.employee_name,
                                    status: changes.status.value,
                                    payment_type: changes.payment_type.value
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.changes = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }
                });
            }
        }
    }
</script>
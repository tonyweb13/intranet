<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Request Form Payment Number"> 
        <input class="form-control input-sm" disabled="disabled" type="number" v-model="payment.request_number" >
        </form-group>
        <form-group label="Department">
            <div class="asterisk_label">*</div>
            <vSelect name="department_id"
                     v-model="payment.department_id"
                     :options="selectedDepartment"
                     label="text"
                     v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('department_id')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('department_id')" class="help is-danger">{{ errors.first('department_id') }}</span>
        </form-group>
        <form-group label="Supplier">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="supplier" type="text" placeholder="Supplier"
                   v-model="payment.supplier" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('supplier') }" >
            <div class="pull-right">
                <i v-show="errors.has('supplier')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('supplier')" class="help is-danger">{{ errors.first('supplier') }}</span>
        </form-group>
        <form-group label="Payee">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="payee" type="text" placeholder="Payee"
                   v-model="payment.payee" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('payee') }" >
            <div class="pull-right">
                <i v-show="errors.has('payee')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('payee')" class="help is-danger">{{ errors.first('payee') }}</span>
        </form-group>
        <form-group label="Amount">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="amount" type="number" placeholder="Amount"
                   v-model="payment.amount" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('amount') }" >
            <div class="pull-right">
                <i v-show="errors.has('amount')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('amount')" class="help is-danger">{{ errors.first('amount') }}</span>
        </form-group>
        <form-group label="Due Date">
            <div class="asterisk_label">*</div>
            <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-sm" id="duedate" name="due date" placeholder="MM/DD/YYYY" v-model="payment.due_date"
                       v-validate="'required|date_format:MM/DD/YYYY'" :class="{'input': true, 'is-danger': errors.has('due date') }">
            </div>
            <div class="pull-right">
                <i v-show="errors.has('due date')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('due date')" class="help is-danger">{{ errors.first('due date') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="payment.description" />
        </form-group>
        <form-group label="Requested By">
            <div class="asterisk_label">*</div>
            <vSelect name="requested by"
                      v-model="payment.requested_id"
                      :options="selectedRequest"
                      label="text"
                      v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('requested by')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('requested by')" class="help is-danger">{{ errors.first('requested by') }}</span>
        </form-group>
        <form-group label="Noted By">
            <div class="asterisk_label">*</div>
            <vSelect name="noted by"
                      v-model="payment.noted_id"
                      :options="selectedNoted"
                      label="text"
                      v-validate="'required'" />
            <div class="pull-right">
                <i v-show="errors.has('noted by')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('noted by')" class="help is-danger">{{ errors.first('noted by') }}</span>
        </form-group>
        <form-group label="Approved By">
            <div class="asterisk_label">*</div>
            <vSelect name="approved by"
                     v-model="payment.approved_id"
                     :options="selectedApproved"
                     label="text"
                     v-validate="'required'"/>
            <div class="pull-right">
                <i v-show="errors.has('approved by')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('approved by')" class="help is-danger">{{ errors.first('approved by') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            paymentProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                payment: {
                    request_number: Math.ceil(Math.random() * 1000000) + 1000000,
                    department_id: this.paymentProps.dep_name,
                    supplier: this.paymentProps.supplier,
                    payee: this.paymentProps.payee,
                    amount: this.paymentProps.amount,
                    due_date: this.paymentProps.due_date,
                    description: this.paymentProps.description,
                    requested_id: this.paymentProps.requested_name,
                    noted_id: this.paymentProps.noted_name,
                    approved_id: this.paymentProps.approved_name,
                },
                selectedDepartment: [],
                selectedRequest: [],
                selectedNoted: [],
                selectedApproved: [],
            };
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            $("#duedate").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'mm/dd/yyyy'
                }
            ).on(
                "changeDate", () => {
                    this.payment.due_date = $("#duedate").val();
                }
            );
        },
        created(){
            if(this.paymentProps.payment_id){
                this.payment.request_number = this.paymentProps.request_number;
                this.payment.department_id = this.paymentProps.dep_name;
                this.payment.supplier = this.paymentProps.supplier;
                this.payment.payee = this.paymentProps.payee;
                this.payment.amount = this.paymentProps.amount;
                this.payment.due_date = this.paymentProps.due_date;
                this.payment.description = this.paymentProps.description;
                this.payment.requested_id = this.paymentProps.requested_name;
                this.payment.noted_id = this.paymentProps.noted_name;
                this.payment.approved_id = this.paymentProps.approved_name;
            } else {
                this.payment.request_number = Math.ceil(Math.random() * 1000000) + 1000000;
                this.payment.department_id = '';
                this.payment.supplier = '';
                this.payment.payee = '';
                this.payment.amount = '';
                this.payment.due_date = '';
                this.payment.description = '';
                this.payment.requested_id = '';
                this.payment.noted_id = '';
                this.payment.approved_id = '';
            }

            this.$constants.Settings_API.get("/department/dropdown")
                .then(response => {
                   this.selectedDepartment = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/requestedby")
                .then(response => {
                    this.selectedRequest = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/assistant")
                .then(response => {
                    this.selectedNoted = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/supervisor")
                .then(response => {
                    this.selectedApproved = response.data;
                });
        },
        computed: {
            isComplete () {
                return this.payment.request_number &&
                this.payment.department_id &&
                this.payment.supplier &&
                this.payment.payee &&
                this.payment.amount &&
                this.payment.due_date &&
                this.payment.requested_id &&
                this.payment.noted_id &&
                this.payment.approved_id;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let payment = this.payment;
                        let getAxios = '';

                        if(this.paymentProps.payment_id){
                            getAxios = this.$constants.ADMIN_API.get("/request_payment/"+this.paymentProps.payment_id, {
                                params: {
                                    request_number: payment.request_number,
                                    department_id: payment.department_id.value,
                                    supplier: payment.supplier,
                                    payee: payment.payee,
                                    amount: payment.amount,
                                    due_date: payment.due_date,
                                    description: payment.description,
                                    requested_id: payment.requested_id.value,
                                    noted_id: payment.noted_id.value,
                                    approved_id: payment.approved_id.value,
                                }
                            });

                        } else {
                            getAxios = this.$constants.ADMIN_API.get("/request_payment/create", {
                                params: {
                                    request_number: payment.request_number,
                                    department_id: payment.department_id.value,
                                    supplier: payment.supplier,
                                    payee: payment.payee,
                                    amount: payment.amount,
                                    due_date: payment.due_date,
                                    description: payment.description,
                                    requested_id: payment.requested_id.value,
                                    noted_id: payment.noted_id.value,
                                    approved_id: payment.approved_id.value,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.payment = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }
                });
            },
        },
    }
</script>
<template>
    <div class="row">
        <div class="ibox-content col-lg-12">
            <ibox class="col-lg-6" title="Request Payment Form" 
                asterisk='<i>Required Fields ( <span class="required_asterisk">*</span> )</i>'>
                <form @submit.prevent="eventUpdate">
                    <form-group>
                    <label class="col-lg-4">Request Form Payment Number</label>   
                    <input class="form-control input-sm" disabled="disabled" type="number" v-model="payment.request_number" >
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
                    <div class="pull-right">
                        <button class="btn btn-default" type="submit" @click="resetForm">Clear</button>
                        <button class="ladda-button btn btn-primary" type="submit" :disabled='!isComplete' data-color="mint" data-style="slide-right">Save</button>
                    </div>
                </form>
            </ibox>

            <ibox class="col-lg-6" title="List of Request Payment">
                <v-client-table :data="rows" :columns="columns" :options="options" />
            </ibox>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                laddabtn : '',
                payment: {
                    request_number: Math.ceil(Math.random() * 1000000) + 1000000,
                    supplier: '',
                    payee: '',
                    amount: '',
                    due_date: '',
                    description: '',
                },
                selectedNoted: [],
                selectedApproved: [],
                columns: ['request_number', 'supplier', 'due_date', 'noted_name', 'assistant_remark', 'approved_name', 'supervisor_remark' ],
                rows: [],
                options: {
                    headings: {
                        request_number: 'Request No.',
                        noted_name: 'Noted By',
                        assistant_remark: 'Admin Assistant',
                        approved_name: 'Approved By',
                        supervisor_remark: 'Admin Supervisor',
                    },
                    sortable: ['request_number', 'supplier'],
                    filterable: ['request_number', 'supplier'],
                },
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
        computed: {
            isComplete () {
                return this.payment.supplier &&
                       this.payment.payee &&
                       this.payment.amount &&
                       this.payment.due_date
            },
        },
        created(){

            this.getList(); 
            this.$bus.$on('updateList', this.getList);

            this.$constants.ADMIN_API.get("/dropdown/assistant")
                .then(response => {
                    this.selectedNoted = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/supervisor")
                .then(response => {
                    this.selectedApproved = response.data;
                });
        },
        methods: {
            getList: function () {
                this.$constants.ADMIN_API.get("/request_payment/requestor")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            resetForm() {
                this.payment = {
                    request_number: Math.ceil(Math.random() * 1000000) + 1000000,
                    supplier: '',
                    payee: '',
                    amount: '',
                    due_date: '',
                    description: '',
                };
                this.$validator.reset();
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let payment = this.payment;

                        this.$constants.ADMIN_API.get("/request_payment/create", {
                                params: {
                                    request_number: payment.request_number,
                                    department_id: this.employee.department_id,
                                    supplier: payment.supplier,
                                    payee: payment.payee,
                                    amount: payment.amount,
                                    due_date: payment.due_date,
                                    description: payment.description,
                                    requested_id: this.employee.id,
                                }
                            }).then(response => {
                                this.laddabtn.stop();
                                this.payment = response.data;
                                swal({
                                    title: 'Saved!',
                                    text: 'Please remember your request number '+ this.payment.request_number,
                                    type: "success",
                                });
                                this.$bus.$emit('updateList');
                                this.resetForm();
                        });

                    }
                });
            },
        },
    }
</script>
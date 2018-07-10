<template>
    <div class="row" >
        <div class="ibox-content col-lg-12">
            <ibox class="col-lg-6" title="Purchasing Supplies Form" 
            asterisk='<i>Required Fields ( <span class="required_asterisk">*</span> )</i>' >
                
                <form @submit.prevent="eventUpdate">         
                        <form-group>
                            <label class="col-lg-4">Control Number</label>    
                            <input class="form-control input-sm" disabled="disabled" type="number" v-model="supply.control_number" >
                        </form-group>
                        <form-group label="Order Quantity">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="order quantity" type="number" placeholder="Order Quantity"
                                   v-model="supply.order_quantity" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('order quantity') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('order quantity')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('order quantity')" class="help is-danger">{{ errors.first('order quantity') }}</span>
                        </form-group>
                        <form-group label="Item Code">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="item code" type="text" placeholder="Item Code"
                                   v-model="supply.item_code" v-validate="'required|alpha_num'" :class="{'input': true, 'is-danger': errors.has('item code') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('item code')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('item code')" class="help is-danger">{{ errors.first('item code') }}</span>
                        </form-group>
                        <form-group label="Item Description">
                            <div class="asterisk_label">*</div>
                            <textarea class="form-control input-sm" name="item description" placeholder="Item Description"
                                   v-model="supply.item_description" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('item description') }" />
                            <div class="pull-right">
                                <i v-show="errors.has('item description')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('item description')" class="help is-danger">{{ errors.first('item description') }}</span>
                        </form-group>
                        <form-group label="Unit">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="unit" type="text" placeholder="Unit"
                                   v-model="supply.unit" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('unit') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('unit')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('unit')" class="help is-danger">{{ errors.first('unit') }}</span>
                        </form-group>
                        <form-group label="Amount">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="amount" type="number" placeholder="Amount"
                                   v-model="supply.amount" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('amount') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('amount')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('amount')" class="help is-danger">{{ errors.first('amount') }}</span>
                        </form-group>
                        <form-group label="Total Amount">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="total amount" type="number" placeholder="Total Amount"
                                   v-model="supply.total_amount" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('total amount') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('total amount')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('total amount')" class="help is-danger">{{ errors.first('total amount') }}</span>
                        </form-group>
                        <form-group label="Issued Quantity">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="issued quantity" type="number" placeholder="Issued Quantity"
                                   v-model="supply.issued_quantity" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('issued quantity') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('issued quantity')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('issued quantity')" class="help is-danger">{{ errors.first('issued quantity') }}</span>
                        </form-group>
                        <form-group label="Issued Date Received">
                            <div class="asterisk_label">*</div>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control input-sm" id="addIssuedDateReceived" name="issued date received" placeholder="MM/DD/YYYY" v-model="supply.issued_date_received"
                                       v-validate="'required|date_format:MM/DD/YYYY'" :class="{'input': true, 'is-danger': errors.has('issued date received') }">
                            </div>
                            <div class="pull-right">
                                <i v-show="errors.has('issued date received')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('issued date received')" class="help is-danger">{{ errors.first('issued date received') }}</span>
                        </form-group>
                        <form-group label="Pending Order Quantity">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="pending order quantity" type="number" placeholder="Pending Order Quantity"
                                   v-model="supply.pending_order_quantity" v-validate="'required|numeric'" :class="{'input': true, 'is-danger': errors.has('pending order quantity') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('pending order quantity')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('pending order quantity')" class="help is-danger">{{ errors.first('pending order quantity') }}</span>
                        </form-group>
                        <form-group label="Pending Date Received">
                            <div class="asterisk_label">*</div>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control input-sm" id="addPendingDateReceived" name="pending date received" placeholder="MM/DD/YYYY" v-model="supply.pending_date_received"
                                       v-validate="'required|date_format:MM/DD/YYYY'" :class="{'input': true, 'is-danger': errors.has('pending date received') }">
                            </div>
                            <div class="pull-right">
                                <i v-show="errors.has('pending date received')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('pending date received')" class="help is-danger">{{ errors.first('pending date received') }}</span>
                        </form-group>
                    <!-- </div> -->
                     <div class="pull-right">
                        <button class="btn btn-default" type="submit" @click="resetForm">Clear</button>
                        <button class="ladda-button btn btn-primary" type="submit" :disabled='!isComplete' data-color="mint" data-style="slide-right">Save</button>
                    </div>
                </form>
            </ibox>
            <ibox class="col-lg-6" title="List of Purchasing Supplies Request">
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
                supply: {
                    control_number: Math.ceil(Math.random() * 100000000) + 100000000,
                    order_quantity: '',
                    item_code: '',
                    item_description: '',
                    unit: '',
                    amount: '',
                    total_amount: '',
                    issued_quantity: '',
                    issued_date_received: '',
                    pending_order_quantity: '',
                    pending_date_received: '',
                },
                columns: ['control_number', 'issued_date_received', 'pending_date_received', 'supplies_received_name','assistant_remark', 'approved_name', 'supervisor_remark' ],
                rows: [],
                options: {
                    headings: {
                        control_number: 'Control No.',
                        issued_date_received: 'Issued Date',
                        pending_date_received: 'Pending Date',
                        supplies_received_name: 'Received By',
                        assistant_remark: 'Assistant',
                        approved_name: 'Approved By',
                        supervisor_remark: 'Supervisor',
                    },
                    sortable: ['control_number', 'issued_date_received', 'pending_date_received'],
                    filterable: ['control_number', 'issued_date_received', 'pending_date_received'],
                },
            };
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            $("#addIssuedDateReceived").datepicker(
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
                    this.supply.issued_date_received = $("#addIssuedDateReceived").val();
                }
            );

            $("#addPendingDateReceived").datepicker(
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
                    this.supply.pending_date_received = $("#addPendingDateReceived").val();
                }
            );
        },
        created(){
            this.getList(); 
            this.$bus.$on('updateList', this.getList);

            // this.$constants.ADMIN_API.get("/dropdown/assistant")
            //     .then(response => {
            //         this.selectedSupplies = response.data;
            //     });

            // this.$constants.ADMIN_API.get("/dropdown/supervisor")
            //     .then(response => {
            //         this.selectedApproved = response.data;
            //     });
        },
        computed: {
            isComplete () {
                return this.supply.order_quantity &&
                this.supply.item_code &&
                this.supply.unit &&
                this.supply.amount &&
                this.supply.total_amount &&
                this.supply.issued_quantity &&
                this.supply.pending_order_quantity &&
                this.supply.pending_date_received &&
                this.supply.issued_date_received;
            }
        },
        methods: {
            getList: function () {
                this.$constants.ADMIN_API.get("/purchasing_supplies/requestor")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            resetForm() {
                this.supply = {
                    control_number: Math.ceil(Math.random() * 100000000) + 100000000,
                    order_quantity: '',
                    item_code: '',
                    item_description: '',
                    unit: '',
                    amount: '',
                    total_amount: '',
                    issued_quantity: '',
                    issued_date_received: '',
                    pending_order_quantity: '',
                    pending_date_received: '',
                };
                this.$validator.reset();
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let supply = this.supply;

                        this.$constants.ADMIN_API.get("/purchasing_supplies/create", {
                                params: {
                                    control_number: supply.control_number,
                                    department_id: this.employee.department_id,
                                    location_id: this.employee.work_location_id,
                                    order_quantity: supply.order_quantity,
                                    item_code: supply.item_code,
                                    item_description: supply.item_description,
                                    unit: supply.unit,
                                    amount: supply.amount,
                                    total_amount: supply.total_amount,
                                    issued_quantity: supply.issued_quantity,
                                    issued_date_received: supply.issued_date_received,
                                    pending_order_quantity: supply.pending_order_quantity,
                                    pending_date_received: supply.pending_date_received,
                                    requested_id: this.employee.id,
                                    request_received_id: this.employee.id
                                }

                            }).then(response => {
                            this.laddabtn.stop();
                            this.supplies = response.data;
                            console.log("this.supplies==");
                            console.log(this.supplies);
                            swal({
                                title: 'Saved!',
                                text: 'Please remember your control number '+ this.supplies.control_number,
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
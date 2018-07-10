<template>
    <div class="row">      
        <form @submit.prevent="eventUpdate">
            <div class="col-lg-6">
                <form-group label="Control Number">
                    <input class="form-control input-sm" disabled="disabled" type="number" v-model="supply.control_number" >
                </form-group>
                <form-group label="Department">
                    <div class="asterisk_label">*</div>
                    <vSelect name="department_id"
                             v-model="supply.department_id"
                             :options="selectedDepartment"
                             label="text"
                             v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('department_id')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('department_id')" class="help is-danger">{{ errors.first('department_id') }}</span>
                </form-group>
                <form-group label="Location">
                    <div class="asterisk_label">*</div>
                    <vSelect name="location_id"
                             v-model="supply.location_id"
                             :options="selectedLocation"
                             label="text"
                             v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('location_id')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('location_id')" class="help is-danger">{{ errors.first('location_id') }}</span>
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
                           v-model="supply.unit" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('unit') }" >
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
            </div>

            <div class="col-lg-6">
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
                <form-group label="Requested By">
                    <div class="asterisk_label">*</div>
                    <vSelect name="requested by"
                             v-model="supply.requested_id"
                             :options="selectedRequest"
                             label="text"
                             v-validate="'required'" />
                    <div class="pull-right">
                        <i v-show="errors.has('requested by')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('requested by')" class="help is-danger">{{ errors.first('requested by') }}</span>
                </form-group>
                <form-group label="Request Received By">
                    <div class="asterisk_label">*</div>
                    <vSelect name="request received by"
                             v-model="supply.request_received_id"
                             :options="selectedReceived"
                             label="text"
                             v-validate="'required'"/>
                    <div class="pull-right">
                        <i v-show="errors.has('request received by')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('request received by')" class="help is-danger">{{ errors.first('request received by') }}</span>
                </form-group>
                <form-group label="Supplies Issued By">
                    <div class="asterisk_label">*</div>
                    <vSelect name="supplies issued by"
                             v-model="supply.supplies_issued_id"
                             :options="selectedSupplySupplies"
                             label="text"
                             v-validate="'required'"/>
                    <div class="pull-right">
                        <i v-show="errors.has('supplies issued by')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('supplies issued by')" class="help is-danger">{{ errors.first('supplies issued by') }}</span>
                </form-group>
                <form-group label="Supplies Received By">
                    <div class="asterisk_label">*</div>
                    <vSelect name="supplies received by"
                             v-model="supply.supplies_received_id"
                             :options="selectedSupplyReceived"
                             label="text"
                             v-validate="'required'"/>
                    <div class="pull-right">
                        <i v-show="errors.has('supplies received by')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('supplies received by')" class="help is-danger">{{ errors.first('supplies received by') }}</span>
                </form-group>
                <form-group label="Approved By">
                    <div class="asterisk_label">*</div>
                    <vSelect name="approved by"
                             v-model="supply.approved_id"
                             :options="selectedApproved"
                             label="text"
                             v-validate="'required'"/>
                    <div class="pull-right">
                        <i v-show="errors.has('approved by')" class="input_warning_icon fa fa-warning"></i>
                    </div>
                    <span v-show="errors.has('approved by')" class="help is-danger">{{ errors.first('approved by') }}</span>
                </form-group>
            </div>
            <div class="pull-right" style="margin-bottom: -160px; margin-top: 60px; margin-right: 1px; background-color: #fff;     width: 125px;">
                <button class="btn btn-default" type="button" @click="closeModal()">Close </button>
                <button class="ladda-button btn btn-primary " type="submit" :disabled="!isComplete" data-color="mint" data-style="slide-right">Save</button>
            </div>
        </form>
    </div>
</template>
<style scoped>
    .modal-footer{
        display: none;
    }
</style>
<script>
    export default {
        props: {
            purchasingProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                supply: {
                    control_number: Math.ceil(Math.random() * 100000000) + 100000000,
                    department_id: this.purchasingProps.dep_name,
                    location_id: this.purchasingProps.loc_name,
                    order_quantity: this.purchasingProps.order_quantity,
                    item_code: this.purchasingProps.item_code,
                    item_description: this.purchasingProps.item_description,
                    unit: this.purchasingProps.unit,
                    amount: this.purchasingProps.amount,
                    total_amount: this.purchasingProps.total_amount,
                    issued_quantity: this.purchasingProps.issued_quantity,
                    issued_date_received: this.purchasingProps.issued_date_received,
                    pending_order_quantity: this.purchasingProps.pending_order_quantity,
                    pending_date_received: this.purchasingProps.pending_date_received,
                    requested_id: this.purchasingProps.requested_name,
                    approved_id: this.purchasingProps.approved_name,
                    request_received_id: this.purchasingProps.request_received_name,
                    supplies_issued_id: this.purchasingProps.supplies_issued_name,
                    supplies_received_id: this.purchasingProps.supplies_received_name,
                },
                selectedDepartment: [],
                selectedLocation: [],
                selectedRequest: [],
                selectedApproved: [],
                selectedReceived: [],
                selectedSupplySupplies: [],
                selectedSupplyReceived: [],
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
            if(this.purchasingProps.pur_id){
                this.supply.control_number = this.purchasingProps.control_number;
                this.supply.department_id = this.purchasingProps.dep_name;
                this.supply.location_id = this.purchasingProps.loc_name;
                this.supply.order_quantity = this.purchasingProps.order_quantity;
                this.supply.item_code = this.purchasingProps.item_code;
                this.supply.item_description = this.purchasingProps.item_description;
                this.supply.unit = this.purchasingProps.unit;
                this.supply.amount = this.purchasingProps.amount;
                this.supply.total_amount = this.purchasingProps.total_amount;
                this.supply.issued_quantity = this.purchasingProps.issued_quantity;
                this.supply.issued_date_received = this.purchasingProps.issued_date_received;
                this.supply.pending_order_quantity = this.purchasingProps.pending_order_quantity;
                this.supply.pending_date_received = this.purchasingProps.pending_date_received;
                this.supply.requested_id = this.purchasingProps.requested_name;
                this.supply.approved_id = this.purchasingProps.approved_name;
                this.supply.request_received_id = this.purchasingProps.request_received_name;
                this.supply.supplies_issued_id = this.purchasingProps.supplies_issued_name;
                this.supply.supplies_received_id = this.purchasingProps.supplies_received_name;
            } else {
                this.supply.control_number = Math.ceil(Math.random() * 100000000) + 100000000;
                this.supply.department_id = '';
                this.supply.location_id = '';
                this.supply.order_quantity = '';
                this.supply.item_code = '';
                this.supply.item_description = '';
                this.supply.unit = '';
                this.supply.amount = '';
                this.supply.total_amount = '';
                this.supply.issued_quantity = '';
                this.supply.issued_date_received = '';
                this.supply.pending_order_quantity = '';
                this.supply.pending_date_received = '';
                this.supply.requested_id = '';
                this.supply.approved_id = '';
                this.supply.request_received_id = '';
                this.supply.supplies_issued_id = '';
                this.supply.supplies_received_id = '';
            }

            this.$constants.Settings_API.get("/department/dropdown")
                .then(response => {
                    this.selectedDepartment = response.data;
                });

            this.$constants.Settings_API.get("/officelocation/dropdown")
                .then(response => {
                    this.selectedLocation = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/requestedby")
                .then(response => {
                    this.selectedRequest = response.data;
                    this.selectedReceived = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/assistant")
                .then(response => {
                    this.selectedSupplyReceived = response.data;
                    this.selectedSupplySupplies = response.data;
                });

            this.$constants.ADMIN_API.get("/dropdown/supervisor")
                .then(response => {
                    this.selectedApproved = response.data;
                });
        },
        computed: {
            isComplete () {
                return this.supply.department_id &&
                this.supply.location_id &&
                this.supply.order_quantity &&
                this.supply.item_code &&
                this.supply.unit &&
                this.supply.amount &&
                this.supply.total_amount &&
                this.supply.issued_quantity &&
                this.supply.pending_order_quantity &&
                this.supply.requested_id &&
                this.supply.approved_id &&
                this.supply.pending_date_received &&
                this.supply.issued_date_received &&
                this.supply.request_received_id &&
                this.supply.supplies_issued_id &&
                this.supply.supplies_received_id;
            }
        },
        methods: {
            closeModal(){
                window.location.href = "/admin/supplies";
            },
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let supply = this.supply;
                        let getAxios = '';

                        if(this.purchasingProps.pur_id){
                            getAxios = this.$constants.ADMIN_API.get("/purchasing_supplies/"+this.purchasingProps.pur_id, {
                                params: {
                                    control_number: supply.control_number,
                                    department_id: supply.department_id.value,
                                    location_id: supply.location_id.value,
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
                                    requested_id: supply.requested_id.value,
                                    approved_id: supply.approved_id.value,
                                    request_received_id: supply.request_received_id.value,
                                    supplies_issued_id: supply.supplies_issued_id.value,
                                    supplies_received_id: supply.supplies_received_id.value,
                                }
                            });

                        } else {
                            getAxios = this.$constants.ADMIN_API.get("/purchasing_supplies/create", {
                                params: {
                                    control_number: supply.control_number,
                                    department_id: supply.department_id.value,
                                    location_id: supply.location_id.value,
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
                                    requested_id: supply.requested_id.value,
                                    approved_id: supply.approved_id.value,
                                    request_received_id: supply.request_received_id.value,
                                    supplies_issued_id: supply.supplies_issued_id.value,
                                    supplies_received_id: supply.supplies_received_id.value,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.supplies = response.data;
                            console.log("this.supplies==");
                            console.log(this.supplies);
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
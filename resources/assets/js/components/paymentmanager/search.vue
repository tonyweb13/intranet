<template>
    <ibox title="Search Payment">

        <div class="row">
            <form id="payment_form" v-on:submit.prevent >
                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                </th>
                                <th>
                                    <label class="text-center"> Input Value </label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="text-center"> Portfolio ID </label>
                                </td>
                                <td>
                                    <select class="form-control input-sm"
                                            v-model="search.portfolio"
                                            name="portfolio"
                                            v-validate="'required'"
                                            :class="{'input': true, 'is-danger': errors.has('portfolio') }"

                                            data-vv-as="Portfolio">
                                        <option selected> </option>4
                                        <option value="COMET">Comet Loans - (COMET)</option>
                                        <option value="IBC">Inbox Credit - (IBC)</option>
                                    </select>
                                    <span v-show="errors.has('portfolio')" class="help is-danger">{{ errors.first('portfolio') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <label class="text-center"> Loan ID </label>
                                </td>
                                <td>
                                    <input class="form-control input-sm" name="loan id" type="text" placeholder="Loan ID"
                                        v-model="search.loan_id"  v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('loan id') }" >
                                    <div >
                                        <i v-show="errors.has('loan id')" class="input_warning_icon fa fa-warning"></i>
                                    </div>
                                    <span v-show="errors.has('loan id')" class="help is-danger">{{ errors.first('loan id') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <label class="text-center">  PIF Date </label>
                                </td>
                                <td>
                                    <div class="input-group date pifdate">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" v-model="search.pifdate" ref="date" name="pifdate" class="form-control" placeholder="YYYY-MM-DD"  autocomplete="off" >
                                    </div>
                                    <div class="pull-right">
                                        <i v-show="errors.has('pif_date')" class="input_warning_icon fa fa-warning"></i>
                                    </div>
                                    <span v-show="errors.has('pif_date')" class="help is-danger">{{ errors.first('pif_date') }}</span>
                                </td>


                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                </th>
                                <th>
                                    <label class="text-center"> Output Value </label>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="30%">
                                   <label class="text-center"> PIF Finance Fee </label>
                                </td>
                                <td class="text-success">
                                    <strong>{{payments.pif_finance_fee}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <label class="text-center">  Outstanding Principal </label>
                                </td>
                                <td class="text-success">
                                    <strong>{{payments.remaining}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="text-center"> Total PIF Amount</label>
                                </td>
                                <td class="text-success">
                                    <strong>{{payments.total_pif_amount}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="text-center"> Loan Status</label>
                                </td>
                                <td class="text-warning">
                                    <strong>{{payments.loan_status_output_info}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                <label class="text-center"> 1</label>
                            </th>
                            <th>
                                 <label class="text-center"> 2</label>
                            </th>
                            <th>
                                 <label class="text-center"> 3</label>
                            </th>
                            <th>
                                 <label class="text-center"> 4</label>
                            </th>
                            <th>
                                 <label class="text-center"> 5</label>
                            </th>
                            <th>
                                 <label class="text-center"> 6</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:10%">
                                <label class="text-center"> Effective Date</label>
                            </td>

                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate1" ref="date" name="pifdate1" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate2" ref="date" name="pifdate2" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate3" ref="date" name="pifdate3" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate4" ref="date" name="pifdate4" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate5" ref="date" name="pifdate5" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                            <td>
                                <div class="input-group date effectiveDate">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" v-model="search.pifdates.pifdate6" ref="date" name="pifdate6" class="form-control input-sm" placeholder="YYYY-MM-DD">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:10%">
                                <label class="text-center"> Pay Down Amount</label>
                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount1" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount1" ></div>

                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount2" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount2" ></div>
                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount3" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount3" ></div>
                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount4" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount4" ></div>
                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount5" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount5" ></div>
                            </td>
                            <td>
                                <div class="input-group m-b"><span class="input-group-addon">$</span> <input class="form-control input-sm input_amount" name="pay_down_amount6" type="text" placeholder="Amount" v-model="search.pay_down_amounts.amount6" ></div>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <button class="ladda-button btn btn-info searchpayment" data-color="mint" @click="fetchManager" data-style="slide-right">Search Payment</button>

            </div>

            <div class="col-lg-12">
                <div style="overflow: scroll;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <label class="text-center text-info">Effective Date</label>
                            </th>
                            <th>
                                <label class="text-center text-info">Adding Pay down</label>
                            </th>
                            <th>
                                <label class="text-center">Loan ID</label>
                            </th>
                            <th>
                                <label class="text-center">Line No.</label>
                            </th>
                            <th>
                                <label class="text-center">Origination Date</label>
                            </th>
                            <th>
                                <label class="text-center">Effective Date</label>
                            </th>
                            <th>
                                <label class="text-center">P</label>
                            </th>
                            <th>
                                <label class="text-center">NF</label>
                            </th>
                            <th>
                                <label class="text-center">LT</label>
                            </th>
                            <th>
                                <label class="text-center">Status (1)</label>
                            </th>
                            <th>
                                <label class="text-center">MODE</label>
                            </th>
                            <th>
                                <label class="text-center">RC</label>
                            </th>
                            <th>
                                <label class="text-center">P</label>
                            </th>
                            <th>
                                <label class="text-center">FF</label>
                            </th>
                            <th>
                                <label class="text-center">A</label>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="data_body">
                    <tr v-for="(item, index) in payments.rows">
                        <td>
                            <label class="text-center text-danger">{{item.new_effective_date}}</label>
                        </td>
                        <td>
                            <label class="text-center text-danger">{{item.new_adding_pay_down}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.loan_number}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.line_number}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.origination_date}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.effective_date}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.p_1}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.nf}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.lt}}</label>
                        </td>
                        <td>
                            <label class="text-center " :class="(item.status1 == 'Checked') ? 'text-info' : 'text-danger'"> {{item.status1}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.mode}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.rc}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.p_2}}</label>
                        </td>
                        <td>
                            <label class="text-center"> {{item.ff}}</label>
                        </td>

                        <td>
                            <label class="text-center"> {{item.a}}</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            </form>
        </div>
    </ibox>
</template>
<style scoped>
    .data_body  tr:nth-child(even) {
        background-color: #eeeeee;
    }

    .searchpayment {
        width:100% !important;
        margin-bottom:50px;
    }
</style>
<script>
    import Inputmask from "inputmask"

    export default {
        components: {Inputmask},
        data: function () {
            return {
                search: {
                    portfolio : '',
                    loan_id: '',
                    pifdate: '',
                    pifdates : {
                        pifdate1 : '',
                        pifdate2 : '',
                        pifdate3 : '',
                        pifdate4 : '',
                        pifdate5 : '',
                        pifdate6 : '',
                    },
                    pay_down_amounts  :{
                        amount1 : 0,
                        amount2 : 0,
                        amount3 : 0,
                        amount4 : 0,
                        amount5 : 0,
                        amount6 : 0,
                    }
                },
                data_calculate : {
                    sum_p : '',
                    remaining : '',
                    last_date : '',
                    sum_a : '',
                    loans : '',
                },
                columns: ['text'],
                rows: [
                    { text: 'Effective Date' },
                    { text: 'Pay Down Amount' }
                ],
                options: {
                    
                },
                columns2: ['payment_id',
                            'loan_number', 
                            'payment_line_type', 
                            'line_number',
                            'origination_date',
                            'effective_date',
                            'p_1',
                            'nf_1',
                            'nf_2',
                            'lt',
                            'ff',
                            'uff',
                            'p_2',
                            'a',
                            'mode',
                            'status1',
                            'rc',
                            'r_d',
                            'new_id',
                            'note',
                            'status2',
                            'rr',
                            'is_makeup',
                            'c_date',
                            'end_date',],
                rows2: [],
                options2: {
                    headings: {
                        payment_id: 'payment_id',
                        loan_number: 'loan_number',
                        payment_line_type: 'payment_line_type',
                        line_number : 'line_number',
                        origination_date : 'origination_date',
                        effective_date : 'effective_date',
                        p_1 : 'p_1',
                        nf_1 : 'nf_1',
                        nf_2 : 'nf_2',
                        lt : 'lt',
                        ff : 'ff',
                        uff : 'uff',
                        p_2 : 'p_2',
                        a : 'a',
                        mode : 'mode',
                        status1 : 'status1',
                        rc : 'rc',
                        r_d : 'r_d',
                        new_id : 'new_id',
                        note : 'note',
                        status2 : 'status2',
                        rr : 'rr',
                        is_makeup : 'is_makeup',
                        c_date : 'c_date',
                        end_date : 'end_date',
                    },
                },
                payments: {}
            }
        },
        created() {
            // this.fetchManager();
            Inputmask({alias: "decimal", integerDigits: 9, digits: 2, allowMinus: true}).mask(document.querySelectorAll("#app_form .input_amount"));
        },
        computed: {
            isComplete () {
                return this.search.loan_id;
            }
        },
        mounted() {
            let vob_component = this.$parent;

            $('#payment_form .date').datepicker({
                format: 'yyyy-mm-dd',
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
            //
            let searchpif_date = this.search;
            $('#payment_form .pifdate').datepicker().on('change', function (ev) {
                console.log($('input[name="pifdate"]').val());
                searchpif_date.pifdate = $('input[name="pifdate"]').val();
            });

            $('#payment_form .effectiveDate').datepicker().on('change', function (ev) {
                /* check this as the change event called twice */
                searchpif_date.pifdates.pifdate1 = $('input[name="pifdate1"]').val();
                searchpif_date.pifdates.pifdate2 = $('input[name="pifdate2"]').val();
                searchpif_date.pifdates.pifdate3 = $('input[name="pifdate3"]').val();
                searchpif_date.pifdates.pifdate4 = $('input[name="pifdate4"]').val();
                searchpif_date.pifdates.pifdate5 = $('input[name="pifdate5"]').val();
                searchpif_date.pifdates.pifdate6 = $('input[name="pifdate6"]').val();
            });

            Inputmask({alias: "decimal", integerDigits: 9, digits: 2, allowMinus: true}).mask(document.querySelectorAll("#payment_form .input_amount"));
        },
        methods: {
            fetchManager: function () {
                let ld = Ladda.create(event.target);
                ld.start();
                this.$constants.PaymentManager_API.get("/search", {params : this.search })
                    .then(response => {
                        if(response.data == '') {
                            swal({
                                type: 'info',
                                allowOutsideClick: false,
                                title: '',
                                timer: 20000,
                                html: 'Unable to find payment on database'
                              });
                            this.payments = [];
                        } else {
                             this.payments= response.data;
                        }
                        ld.stop();
                    }).catch(e => {
                    swal({
                        type: 'error',
                        allowOutsideClick: false,
                        title: '',
                        timer: 20000,
                        html: 'Unable to find payment on database'
                    });
                    ld.stop();
                });

            },
            searchManager: function () {

            }
        }
    }
</script>
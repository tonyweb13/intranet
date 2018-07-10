
<template>
    <div class="panel-body col-lg-12 ">

            <form v-model="form_name" id="app_form" v-on:submit.prevent>
                <input type="hidden" name="app_id" v-model="frm_fields.items.app_id">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Loan ID <span class="required_fields">*</span></label>
                            <div class="control has-icon has-icon-right" :class="{'input-group': frm_transition.is_view ? false : true  }">
                                <input type="text"
                                       name="loan_id"
                                       v-model="frm_fields.items.loan_id"
                                       placeholder="Load Id"
                                       class="form-control input-sm"
                                       v-validate="'required'"
                                       :class="{'input': true, 'is-danger': errors.has('loan_id')}"
                                       :readonly="frm_transition.is_view"
                                       data-vv-as="Load Id" >
                                <span class="input-group-addon" style="padding: 0px 5px;" v-if="frm_transition.is_view === false">
                                    <button type="button" class="btn btn-primary btn-xs ladda-button" name="verify" @click="verifyApp" v-if="verify_btn">
                                        Verify
                                    </button>
                                </span>
                            </div>
                            <span v-show="errors.has('loan_id')" class="help is-danger">
                                {{ errors.first('loan_id') }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label>First Name <span class="required_fields">*</span></label>
                            <input type="text" name="first_name" v-model="frm_fields.items.first_name" class="form-control input-sm" value="--" :readonly="verify_btn"
                                   :class="{'input': true, 'is-danger': errors.has('first_name') }"
                                   v-validate="verify_btn ? '' : 'required'"
                                   data-vv-as="First Name"
                            >
                            <span v-show="errors.has('first_name')" class="help is-danger">
                                {{ errors.first('first_name') }}
                            </span>
                        </div>
                        <div class="form-group" >
                            <label>E-mail <span class="required_fields">*</span></label>
                            <input type="text" name="email" v-model="frm_fields.items.email" class="form-control input-sm" value="--" :readonly="verify_btn"
                                   :class="{'input': true, 'is-danger': errors.has('email') }"
                                   v-validate="verify_btn ? '' : 'required'"
                                   data-vv-as="E-mail"
                            >

                            <span v-show="errors.has('email')" class="help is-danger">
                                {{ errors.first('email') }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label>State <span class="required_fields">*</span></label>{{frm_transition.is_view}}
                            <div class="clearfix"/>
                            <vSelect name="state"
                                     v-model="frm_fields.items.state"
                                     label="alpha-2"
                                     :disabled="verify_btn"
                                     :options="us_states"
                                     data-vv-as="State"
                                     v-validate="'required'">
                            </vSelect>
                           <span v-show="errors.has('state')" class="help is-danger">
                               {{ errors.first('state') }}
                           </span>
                        </div>
                        <div class="form-group">
                            <label>Decision Logic <span class="required_fields">*</span></label>
                            <input type="text" name="dl_id" v-model="frm_fields.items.dl_id" placeholder="Request Code" class="form-control input-sm"
                                   :class="{'input': true, 'is-danger': errors.has('dl_id') }"
                                   v-validate="'required'"
                                   data-vv-as="Request Code">
                            <span v-show="errors.has('dl_id')" class="help is-danger">
                                {{ errors.first('dl_id') }}
                            </span>
                        </div>
                        <div class="form-group">
                            <fieldset>
                                <legend>Verification of Employment <span class="required_fields">*</span></legend>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks" style="margin-left: 10px;">
                                    <label>
                                        Regular Voe &nbsp;&nbsp;
                                        <input type="radio" value="regular voe" checked="checked" v-model="frm_fields.items.voe_ret"  name="voe_ret" v-validate="'required'" data-vv-as="Verification of Employment">
                                    </label>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 i-checks">
                                    <label>
                                        No Voe&nbsp;&nbsp;
                                        <input type="radio" value="no voe" name="voe_ret" v-model="frm_fields.items.voe_ret">
                                    </label>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks">
                                    <label>
                                        Strong Voe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" value="strong voe" name="voe_ret" v-model="frm_fields.items.voe_ret">
                                    </label>
                                </div>
                                <span v-show="errors.has('voe_ret')" class="help is-danger">
                                {{ errors.first('voe_ret') }}
                        </span>
                            </fieldset>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Portfolio <span class="required_fields">*</span></label>
                            <select class="form-control input-sm"
                                    v-model="frm_fields.items.portfolio"
                                    name="portfolio"
                                    :readonly="frm_transition.is_view"
                                    v-validate="'required'"
                                    :class="{'input': true, 'is-danger': errors.has('portfolio') }"
                                    @change="onChangePortfolio"
                                    data-vv-as="Portfolio">
                                <option selected> </option>
                                <option  v-for="option in portfolios_vps" :value="option.name">{{ option.description  }}</option>

                                <!--<option value="INBX">Inbox Loan - (INBX)</option>-->
                                <!--&lt;!&ndash;<option value="SLS">Send Loan - (SLS)</option>&ndash;&gt;-->
                                <!--<option value="SOF">Solid Oak Finance - (SOF)</option>-->
                                <!--<option value="COMET">Comet Loans - (COMET)</option>-->
                                <!--<option value="IBC">Inbox Credit - (IBC)</option>-->
                                <!--<option value="NPF">Northern Plains Funding - (NPF)</option>-->
                            </select>
                            <span v-show="errors.has('portfolio')" class="help is-danger">
                                {{ errors.first('portfolio') }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label>Last Name <span class="required_fields">*</span></label>
                            <input type="text" name="last_name" v-model="frm_fields.items.last_name" class="form-control input-sm" value="--" :readonly="verify_btn"
                                   :class="{'input': true, 'is-danger': errors.has('last_name') }"
                                   v-validate="verify_btn ? '' : 'required'"
                                   data-vv-as="Last Name"
                            >
                            <span v-show="errors.has('last_name')" class="help is-danger">
                                {{ errors.first('last_name') }}
                            </span>
                        </div>
                        <div class="form-group">
                            <label>SSN <span class="required_fields">*</span></label>
                            <input type="text" name="ssn" v-model="frm_fields.items.ssn"  class="form-control input-sm" value="--" :readonly="verify_btn"
                                   :class="{'input': true, 'is-danger': errors.has('ssn') }"
                                   v-validate="verify_btn ? '' : 'required'"
                                   data-vv-as="SSN"
                            >
                            <span v-show="errors.has('ssn')" class="help is-danger">
                                {{ errors.first('ssn') }}
                            </span>

                            <input type="hidden" name="ssn_complete" v-model="frm_fields.items.ssn_complete">
                        </div>

                        <!--<div class="form-group">-->
                            <!--<label>Pay Frequency</label>-->
                            <!--<div class="clearfix"/>-->
                            <!--<vSelect name="input_pay_frequency"-->
                                     <!--v-model="frm_fields.items.input_pay_frequency"-->
                                     <!--label="description"-->
                                     <!--:options="pay_frequencys"-->
                                     <!--data-vv-as="Pay Frequency"-->
                                     <!--v-validate="'required'">-->
                            <!--</vSelect>-->
                            <!--<span v-show="errors.has('input_pay_frequency')" class="help is-danger">-->
                               <!--{{ errors.first('input_pay_frequency') }}-->
                           <!--</span>-->
                        <!--</div>-->


                        <div class="form-group">
                            <label>Pay Frequency <span class="required_fields">*</span></label>
                            <select class="form-control input-sm"
                                    v-model="frm_fields.items.input_pay_frequency"
                                    name="input_pay_frequency"
                                    v-validate="'required'"
                                    :class="{'input': true, 'is-danger': errors.has('input_pay_frequency') }"
                                    data-vv-as="Pay Frequency">
                                <option selected></option>
                                <option v-for="option in pay_frequencys" v-bind:value="option.name">
                                    {{ option.description }}
                                </option>
                            </select>
                            <span v-show="errors.has('input_pay_frequency')" class="help is-danger">
                                {{ errors.first('input_pay_frequency') }}
                            </span>
                        </div>



                        <div class="form-group">
                            <label>Ending Balance of the Day <span class="required_fields">*</span></label>
                            <div class="input-group m-b"><span class="input-group-addon">$</span>

                                <input type="text" name="ebd" v-model="frm_fields.items.ebd"  placeholder="Ending balance" class="form-control input_amount"
                                       :class="{'input': true, 'is-danger': errors.has('ebd') }"
                                       v-validate="'required'"
                                       data-vv-as="Ending Balance Amount">
                            </div>
                            <span v-show="errors.has('ebd')" class="help is-danger">
                                {{ errors.first('ebd') }}
                            </span>
                        </div>

                        <div class="form-group">
                            <fieldset>
                                <legend>New or Returning <span class="required_fields">*</span></legend>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks" style="margin-left: 10px;">
                                    <label>
                                        New&nbsp;&nbsp;&nbsp;
                                        <input type="radio" checked="checked" value="new" v-model="frm_fields.items.new_ret"  name="new_ret"  v-validate="'required'" data-vv-as="New or Returning">
                                    </label>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6 i-checks">
                                    <label>
                                        Returning&nbsp;&nbsp;&nbsp;
                                        <input type="radio" value="returning" v-model="frm_fields.items.new_ret"   name="new_ret">
                                    </label>
                                </div>
                                <span v-show="errors.has('new_ret')" class="help is-danger">
                                {{ errors.first('new_ret') }}
                                 </span>
                            </fieldset>
                        </div>
                    </div>
                </div>

             <!--Correction Notes-->
                <div class="row">
                    <div class="col-lg-6">

                        <fieldset>
                            <legend class="text-warning">Corrections : </legend>
                            <div class="corrections">
                                <ul>
                                    <li v-for="(item, key) in correction_data">
                                        <label>Date : {{ item.created_at }} </label>

                                        <ol>
                                            <li v-for="(c_item, c_key) in JSON.parse(item.description).correction_text">
                                                 {{ c_item.correction_name }}
                                            </li>
                                            <li v-if="JSON.parse(item.description).correction_request.others">
                                                <strong>Others :</strong> "{{JSON.parse(item.description).correction_request.others}}
                                            </li>
                                        </ol>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>

                            </div>
                        </fieldset>

                    </div>
                    <div class="col-lg-6">
                        <fieldset>
                            <legend>Notes / Activity : </legend>
                        </fieldset>
                    </div>
                </div>


            </div>

            <div class="col-lg-6">
                <div class="clearfix"/>
                <div class="form-group">
                    <label>VOB Session ID <span class="required_fields">*</span></label>
                    <input type="text" name="vob_session_id" v-model="frm_fields.items.vob_session_id"  placeholder="VOB Session ID" class="form-control input-sm"
                           :class="{'input': true, 'is-danger': errors.has('vob_session_id') }"

                           data-vv-as="VOB Session ID">
                    <span v-show="errors.has('vob_session_id')" class="help is-danger">
                                {{ errors.first('vob_session_id') }}
                            </span>
                </div>
                <div class="clearfix"/>
                <!--{{frm_fields}}-->
                <!--input_date_name="vob_date[]" input_dd_name="vob_dd[]" input_eod_name="vob_eod[]"-->
                <vob_inputs v-bind:view_data="frm_fields.items.vob" ref="vobInput" />
                <div class="form-group">
                    <div id="loanmatrix" >
                        <fieldset>
                            <legend>Loan Matrix <span class="required_fields">*</span></legend>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>No.# of Open Loans</label>
                                        <input type="text" name="num_of_open_of_loans" v-model="frm_fields.items.num_of_open_of_loans"
                                               v-validate="'required|numeric'"
                                               class="form-control input-sm" value="--"
                                               data-vv-as="Open Loans"
                                        >
                                        <span v-show="errors.has('num_of_open_of_loans')" class="help is-danger">
                                               {{ errors.first('num_of_open_of_loans') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">

                                    <label>Open Loan Amount</label>
                                    <div class="form-group">

                                            <div class="input-group m-b">
                                                <span class="input-group-addon">$</span>
                                                <input type="text" name="open_loan_amount" v-model="frm_fields.items.open_loan_amount"
                                                       v-validate="'required|decimal'"  class="form-control input-sm" value="--"
                                                       data-vv-as="Open Loans Amount"
                                                >
                                            </div>
                                        <span v-show="errors.has('open_loan_amount')" class="help is-danger">
                                               {{ errors.first('open_loan_amount') }}
                                        </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>No.# of Pd Off Loans</label>
                                        <input type="text" name="num_of_paid_of_loans" v-model="frm_fields.items.num_of_paid_of_loans"
                                               v-validate="(frm_fields.items.new_ret == 'new')  ? '' : 'required'"  :readonly="(frm_fields.items.new_ret == 'new')"  class="form-control input-sm" value="--"
                                               data-vv-as="Paid off Loans">
                                        <span v-show="errors.has('num_of_paid_of_loans')" class="help is-danger">
                                               {{ errors.first('num_of_paid_of_loans') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <!--<div class="form-group">-->
                                        <!--<input type="text" name="is_exception" v-model="frm_fields.items.is_exception"-->
                                               <!--v-validate="'required'"-->
                                               <!--class="form-control input-sm" value="&#45;&#45;"-->
                                               <!--data-vv-as="Is Exception">-->
                                        <!--<span v-show="errors.has('is_exception')" class="help is-danger">-->
                                               <!--{{ errors.first('is_exception') }}-->
                                        <!--</span>-->
                                    <!--</div>-->

                                    <div class="form-group">
                                        <label>Is Exception</label>
                                        <div class="clearfix" />
                                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks" style="margin-left: 10px;">
                                                <label>
                                                    YES <input type="radio" checked="checked" value="1" v-model="frm_fields.items.is_exception"  name="is_exception"  v-validate="'required'" data-vv-as="Is Exception">
                                                </label>
                                            </div>
                                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks">
                                                <label>
                                                    NO <input type="radio" value="0" v-model="frm_fields.items.is_exception"   name="is_exception">
                                                </label>
                                            </div>
                                        <span v-show="errors.has('is_exception')" class="help is-danger">
                                               {{ errors.first('is_exception') }}
                                        </span>
                                    </div>

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Negative Balance</label>
                                        <input type="text" name="negative_balance" v-model="frm_fields.items.negative_balance"
                                               v-validate="'required|numeric'"  class="form-control input-sm" value="--"
                                               data-vv-as="Negative Balance">
                                        <span v-show="errors.has('negative_balance')" class="help is-danger">
                                               {{ errors.first('negative_balance') }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="form-group">
                    <div class="monthly_income">
                        <fieldset>
                            <p>* This will auto calculate the monthly income and approved loan amount base on the input data given.</p>
                            <legend>Calculate Monthly Income</legend>
                            <div class="form-group">
                                <div class="input-group m-b">
                                    <span class="input-group-addon">$</span>
                                    <input type="text"
                                           name="monthly_income"
                                           v-model="frm_fields.items.monthly_income"
                                           class="form-control"
                                           readonly="true"
                                           style="cursor: copy; text-align: left; font-weight:bolder;">
                                    <!--<span class="input-group-addon" style="padding: 0px 5px;" >-->
                                    <!--<button type="button" class="btn btn-primary ladda-button" name="calculate" @click="calculate"  >-->
                                        <!--<i class="fa fa-calculator"></i>Calculate-->
                                    <!--</button>-->
                                    <!--</span>-->
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="font-size:14px;">Approved Loan Amount</label>
                                <div class="input-group m-b">
                                    <span class="input-group-addon">$</span>
                                    <input type="text"
                                           name="approved_loan_amount"
                                           v-model="frm_fields.items.approved_loan_amount"
                                           class="form-control"
                                           readonly="true"
                                           style="cursor: copy; text-align: left; font-weight:bolder; font-size:16px; background-color:#eef2c4;">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="clearfix"/>
            <hr class="hr">
             <div class="pull-left btntriggers">
                <button class="btn btn-info " type="submit" @click="SubmitApplication" name="submit" v-bind:disabled="frm_fields.items.submitDisable" v-if="frm_transition.is_view === false" ><i class="fa fa-check"></i>&nbsp;Submit to Underwriting</button>
                <div v-if="frm_transition.is_view || frm_fields.items.status != 0">
                    <button class="btn btn-default" v-if="rulesActions.update_app" type="button" name="update" @click="UpdateApplication"><i class="fa fa-check-square-o-up"></i>Update</button>
                    <button class="btn btn-primary" v-if="rulesActions.approve_app && frm_fields.items.status != 4 && frm_fields.items.status != 3" type="button" @click="Approved" name="approve" ><i class="fa fa-check"></i>Approve</button>
                    <button class="btn btn-info" v-if="rulesActions.return_app && frm_fields.items.status == 4" type="button" @click="ReturnBtn" name="return"><i class="fa fa-reply"></i>Return For Approval</button>
                    <button class="btn btn-warning" v-if="rulesActions.correction_app" type="button" @click="Correction" name="correction"><i class="fa fa-exclamation-triangle"></i>Correction</button>
                    <button class="btn btn-danger" v-if="rulesActions.deny_app && frm_fields.items.status != 5"  type="button" @click="DenyBtn" name="deny"><i class="fa fa-ban"></i>Deny</button>
                </div>
            </div>
            </form>
        <form id="correction_form" v-on:submit.prevent>
        <modal v-if="openModal" @close="openModal = false" :modalClass="'modal-lg'">
            <h3 slot="header">Corrections</h3>

            <corrections @corrections="correctionHandleData($event)" ref="corrections" slot="body"/>
            <button slot="footer" class="btn btn-primary" @click="Correction"> Return For Correction </button>&nbsp;

        </modal>
        </form>
    </div>

</template>
<style scoped>
    .corrections ul {
        margin-left: 0px;
        padding-left: 20px;
    }
    .corrections ul li{
        margin-bottom:10px;
        list-style: none !important;
    }
    .corrections ul ol{
        margin-bottom:10px;
    }
    .monthly_income {
        margin-top:10px;
    }
    button i {
        margin-right:5px;
    }
    fieldset {
        padding: .35em .625em .75em;
        border: 1px solid #e5e5e5;
    }
    .btntriggers {
        position : fixed;
        bottom: 50px;
    }

    input[readonly] {
        cursor : not-allowed;
    }

    #loanmatrix label {
        font-size:10px;
    }

    fieldset legend {
        margin-bottom: 5px;
        width:auto;
        font-size: 13px;
        color: #676a6c;
        font-weight: 700;
        border-bottom: 0px solid #e5e5e5;
    }

</style>
<script>
    'use strict';
    import vob_inputs from '../../loanapproval/components/vob.vue'
    import corrections from '../../loanapproval/components/corrections.vue'
    import Inputmask from 'inputmask'
    import { Validator } from 'vee-validate'
    import vSelect from 'vue-select'
    import ajaxMixins from '../../../mixins/ajaxMixins'
    import loanApproval from '../../../mixins/loanApprovalMixins'

    export default {
        mixins : [ajaxMixins, loanApproval],
        components: { vob_inputs, Inputmask, vSelect, Validator, corrections},
        // $_veeValidate: {
        //     errorBagName: 'errors',
        // },
        data() {
            return {
                frm_validation_msg : {
                    custom: {
                        ebd : {
                            required : 'Please choose New or Returning Customer'
                        },
                        voe_ret : {
                            required : 'Please choose Employment Verification'
                        },
                        // loan_id: {
                        //     required: 'Required Loan ID' // messages can be strings as well.
                        // },
                    }
                },
            }
        },
        created () {
            this.loadFormData();
            this.loadGrabApp();
        },
        render(h) {
            return h('ul', this.pod.map(pea => h('li', pea.name)));
        },
        watch : {
            'frm_fields.items': {
                handler: function() {
                    this.calculate();
                },
                deep: true
            },
            // call again the method if the route changes
            '$route': 'loadFormData'
        },

        mounted(){

            $('#toggleSpinners').on('click', function(){

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                $('#ibox2').children('.ibox-content').toggleClass('sk-loading');

            });

            let fields = this.frm_fields;
            $('[type=checkbox], [type=radio]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('input[name=new_ret]').on('ifChanged', function(event){
                fields.items.new_ret =  event.target.value;
            });

            $('input[name=is_exception]').on('ifChanged', function(event){
                fields.items.is_exception =  event.target.value;
            });

            $('input[name=voe_ret]').on('ifChanged', function(event){
                fields.items.voe_ret =  event.target.value;
            });

            $('#app_form .date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            Inputmask({alias: "decimal", integerDigits: 9, digits: 2, allowMinus: true}).mask(document.querySelectorAll("#app_form .input_amount"));

            $(".state").select2({
                allowClear: true
            });


        },

        methods: {
            loadFormData: function () {
                if (this.$route.params.action == 'view')
                {
                    let fields = this.frm_fields;

                    this.frm_transition.is_view = true;
                    this.$constants.LoanApp_API.get('/application/'+this.$route.params.id).then(response => {
                        // response.data.vob = JSON.parse(response.data.vob);
                        // this.frm_fields.data = response.data;
                        fields.items.app_id = response.data.id;
                        fields.items.loan_id = response.data.loan_no;
                        fields.items.portfolio = response.data.portfolio;
                        fields.items.first_name = response.data.first_name;
                        fields.items.last_name = response.data.last_name;
                        fields.items.email = response.data.email;
                        fields.items.ssn = '******' + response.data.ssn.substring(5,9);
                        fields.items.ssn_complete =  response.data.ssn;
                        fields.items.state = response.data.state;
                        fields.items.dl_id = response.data.request_code;
                        fields.items.ebd = response.data.ending_balance;
                        fields.items.new_ret = response.data.new_or_returning;
                        fields.items.voe_ret = response.data.voe;
                        fields.items.vob_session_id = response.data.vob_session_id;
                        fields.items.input_pay_frequency = response.data.pay_frequency;
                        fields.items.vob = JSON.parse(response.data.vob);

                        fields.items.num_of_open_of_loans = response.data.num_of_open_of_loans;
                        fields.items.open_loan_amount = response.data.open_loan_amount;
                        fields.items.num_of_paid_of_loans = response.data.num_of_paid_of_loans;
                        fields.items.is_exception = response.data.is_exception;
                        fields.items.negative_balance = response.data.negative_balance;
                        fields.items.monthly_income = response.data.monthly_income;
                        fields.items.approved_loan_amount = response.data.approved_loan_amount;

                        fields.items.status = response.data.status;

                        this.correction_data = response.data.application_process;


                        fields.items.submitDisable = false;

                        $(':radio[name=new_ret][value="'+response.data.new_or_returning+'"]').iCheck('check');
                        $(':radio[name=voe_ret][value="'+response.data.voe+'"]').iCheck('check');
                        $(':radio[name=is_exception][value="'+response.data.is_exception+'"]').iCheck('check');

                    }).catch(e => {
                        console.log(e);
                        swal({type: 'error', title: 'Unable to Retrieve Application', html:  'Please Check the Application ID : '+this.$route.params.id+'<br>' + e,});
                    });

                    // this.frm_fields.items.loan_id = '0000000';
                }

            },

            monthlyIncome() {
                let _return = [];
                let loop_ddAmount = 6, ddAmount = 0, division = 0, dd_date = [], vobs = [], loop = 0;

                // Approved Loan Amount
                let sum_of_eod_amount = 0, List = [], in_list_count = 0;

                for (var i=1; i < loop_ddAmount + 1; i++) {

                    let cnt;

                    if(parseInt($('input[name="view_data['+i+'][ddAmount]').val())) {

                        if($('input[name="vob['+i+'][eodAmount]').val() != '') {
                            in_list_count++;
                            List.push(parseInt($('input[name="view_data['+i+'][eodAmount]').val()));
                            // console.log(List);
                        }

                        sum_of_eod_amount += ($('input[name="view_data['+i+'][eodAmount]').val() != '') ? parseInt($('input[name="view_data['+i+'][eodAmount]').val()) : 0 ; // for Approved Loan Amount

                        vobs[loop] = {'date' : $('input[name="view_data['+i+'][date]').val(), 'dd_amount' : $('input[name="view_data['+i+'][ddAmount]').val(), 'dd_eod' : $('input[name="view_data['+i+'][eodAmount]').val()};
                        division += 1;
                        loop++;
                    }
                }


                vobs.sort(function(a,b){
                    return new Date(b.date) - new Date(a.date);
                });

                let last3 = vobs.slice(0, 3);

                let calc1_avg = 0 , calc1 = 0, calc2= 0;
                last3.forEach( function(item, index){
                    calc1_avg += parseFloat(item.dd_amount);
                });

                calc1 = parseFloat(calc1_avg/3);

                let last2 = vobs.slice(0, 2), dd_amount_array = [];
                last2.forEach( function(item, index){
                    dd_amount_array.push(parseFloat(item.dd_amount));
                });

                calc2 = parseFloat(Math.min(...dd_amount_array));

                let the_min = Math.min(calc1, calc2);
                let the_max = Math.max(calc1, calc2);
                let factor = the_max / the_min;
                let take_home_pay = factor > 1.3 ? the_min : the_max;

                let payfrequency, net_monthly_income = 0;

                    switch (this.frm_fields.items.input_pay_frequency) {
                        case 'B':
                            payfrequency = this.$constants.AVERAGE_NUMBER_OF_DAYS_PER_MONTH / (2 * this.$constants.DAYS_PER_WEEK);
                            break;
                        case 'W':
                            payfrequency = this.$constants.AVERAGE_NUMBER_OF_DAYS_PER_MONTH / this.$constants.DAYS_PER_WEEK;
                            break;
                        case 'S' :
                        case 'M' :
                            payfrequency = 2;
                            break;
                    }

                // monthly income
                this.frm_fields.items.monthly_income = parseFloat(take_home_pay * payfrequency).toFixed(2);

                /*
                 Calculate Approved Loan Amount
                */
                // console.log(sum_of_eod_amount);
                // console.log(loop);

                let counts = 0;

                let EndingB = 9000;

                if (loop !== 0) {
                    console.log(loop);
                    if (loop > 1) {

                        console.log('With Eod List Count ' + in_list_count);


                       if(in_list_count == 1) {
                            console.log('In list = 1');
                           let remove_max_eod = eval(List.join("+")); //sum the array

                           EndingB = parseFloat(parseInt(remove_max_eod)) / 1;

                       } else {
                           console.log('In list > 1');

                           var i = List.indexOf(Math.max(...List));

                           if(i != -1) {
                               List.splice(i, 1);
                           }

                           console.log('> 1 ccount : ' + List);

                           let remove_max_eod = eval(List.join("+")); //sum the array

                           EndingB = parseFloat(parseInt(remove_max_eod)) / parseFloat(parseInt(in_list_count - 1));
                       }

                       console.log(EndingB);

                    } else {

                       EndingB = parseFloat(parseInt(sum_of_eod_amount)) / parseFloat(parseInt(loop));

                    }
                }


                let payFrequency = this.frm_fields.items.input_pay_frequency;
                let final_ending_balance = 0;
                // console.log(payFrequency);

                if (payFrequency == 'W' && (EndingB / 1.5 / 0.15) >= 200) {

                    final_ending_balance = EndingB / 1.5 / 0.15;

                } else if ((payFrequency == 'B' || payFrequency == 'S') && (EndingB / 1.5 / 0.3) >= 200) {

                    final_ending_balance = EndingB / 1.5 / 0.3;

                } else {
                    final_ending_balance = EndingB / 1.5 / 0.3;
                    this.frm_fields.items.approved_loan_amount = "Not Qualify";
                    return;
                }
                // this.frm_fields.items.approved_loan_amount = "Not Qualify";

                // console.log(final_ending_balance);


                let number_of_open_loans = this.frm_fields.items.num_of_open_of_loans;


                // console.log(EndingB);

                let annualInterestRate = this.frm_fields.items.monthly_income;
                let loanAmount = this.frm_fields.items.open_loan_amount;
                let DL =(this.frm_fields.items.dl_id)  ? 1 : 0;
                let Port = this.frm_fields.portfolio;
                let loan = (this.frm_fields.items.new_ret == 'new')  ? 0 : this.frm_fields.items.num_of_paid_of_loans;
                let EXP = this.frm_fields.items.is_exception;
                let negative_balance = this.frm_fields.items.negative_balance;
                let state_rate = this.matrix_states.rate;

                let final_ending_balance_with_state_rate = (final_ending_balance*state_rate);


                let state_rate_25 = (0.25*state_rate);
                let state_rate_30 = (0.30*state_rate);
                let state_rate_35 = (0.35*state_rate);
                let state_rate_40 = (0.40*state_rate);
                let state_rate_45 = (0.45*state_rate);


                switch (Port){
                    case 'SOF' :
                            if (number_of_open_loans <= 3) {
                                if (loan == 0 && EXP == 1) {

                                    if (DL == 0 && (annualInterestRate * (0.22 * state_rate) - loanAmount) >= 200 && Math.min((annualInterestRate * (0.22 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * (0.22 * state_rate) - loanAmount), 200), 600), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else if (DL == 1 && (annualInterestRate * (0.30 * state_rate) - loanAmount) >= 200 && Math.min((annualInterestRate * (0.22 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount =  Math.min(Math.round(Math.min(Math.max((annualInterestRate * (0.22 * state_rate) - loanAmount), 200), 600), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));
                                    } else {
                                        this.frm_fields.items.approved_loan_amount = 'Not Qualify';
                                    }

                                } else if (loan == 0 && EXP == 0) {
                                    if (DL == 0 && (annualInterestRate * (0.30 * state_rate) - loanAmount) >= 500 && Math.min((annualInterestRate * (0.30 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * (0.22 * state_rate) - loanAmount), 500), 600), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else if (DL == 0 && (annualInterestRate * (0.30 * state_rate) - loanAmount) < 500 && Math.min((annualInterestRate * (0.30 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance) && (annualInterestRate * (0.30 * state_rate) - loanAmount) >= 200) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round((annualInterestRate * (0.30 * state_rate) - loanAmount), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));


                                    } else if (DL == 1 && (annualInterestRate * (0.30 * state_rate) - loanAmount) >= 500 && Math.min((annualInterestRate * (0.31 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * (0.31 * state_rate) - loanAmount), 500), 600), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else if (DL == 1 && (annualInterestRate * (0.30 * state_rate) - loanAmount) < 500 && Math.min((annualInterestRate * (0.31 * state_rate) - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 600) / 2 >= Math.abs(negative_balance) && (annualInterestRate * (0.31 * state_rate) - loanAmount) >= 200) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round((annualInterestRate * (0.31 * state_rate) - loanAmount), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else {
                                        this.frm_fields.items.approved_loan_amount = 'Not Qualify';
                                    }

                                } else if (loan == 1 && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && (
                                    Math.min(Math.max(annualInterestRate * (0.35 * state_rate) - loanAmount, 200), 1000)) / 2 >= Math.abs(negative_balance) && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) >= 700) {

                                    this.frm_fields.items.approved_loan_amount =  Math.round(Math.min(Math.max(annualInterestRate * (0.35 * state_rate) - loanAmount, 200), 1000), 2);

                                } else if (loan == 1 && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && (
                                    Math.min(Math.max(annualInterestRate * 0.25 - loanAmount, 700), 1000)) / 2 >= Math.abs(negative_balance) && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) >= 700) {

                                    this.frm_fields.items.approved_loan_amount =  Math.round(Math.min(Math.max(annualInterestRate * (0.24 * state_rate)- loanAmount, 700), 1000), 2);

                                } else if (loan > 1 && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) >= 200 && numberOfYears <= 3 && DL == 1 && (
                                    Math.min(Math.max(annualInterestRate * (0.40 * state_rate) - loanAmount, 200), 1000)) / 2 >= Math.abs(negative_balance) && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) >= 700) {

                                    this.frm_fields.items.approved_loan_amount =  Math.round(Math.min(Math.max(annualInterestRate * (0.40 * state_rate) - loanAmount, 200), 1000), 2);

                                } else if (loan > 1 && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) >= 200 && numberOfYears <= 3 && DL == 0 && Math.min(
                                    Math.max(annualInterestRate * (0.30 * state_rate) - loanAmount, 700), 1000) / 2 >= Math.abs(negative_balance) && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) >= 700) {

                                    this.frm_fields.items.approved_loan_amount =  Math.round(Math.min(Math.max(annualInterestRate * (0.30 * state_rate) - loanAmount, 700), 1000), 2);

                                } else if (loan == 1 && (annualInterestRate * (0.35 * state_rate) - loanAmount) >= 200 && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) <= 700 && (
                                    annualInterestRate * (0.35 * state_rate) - loanAmount) / 2 >= Math.abs(negative_balance) && numberOfYears <= 3) {

                                    this.frm_fields.items.approved_loan_amount = Math.round((annualInterestRate * (0.35 * state_rate) - loanAmount), 2);

                                } else if (loan > 1 && (annualInterestRate * (0.40 * state_rate) - loanAmount) >= 200 && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) <= 700 && (
                                    annualInterestRate * (0.40 * state_rate) - loanAmount) / 2 >= Math.abs(negative_balance) && numberOfYears <= 3) {

                                    this.frm_fields.items.approved_loan_amount = Math.round((annualInterestRate * (0.40 * state_rate) - loanAmount), 2);

                                } else {
                                    this.frm_fields.items.approved_loan_amount = "Not Qualify";

                                }

                            } else {
                                this.frm_fields.items.approved_loan_amount = "Not Qualify";
                            }
                        break;
                    default :
                            if (number_of_open_loans <= 3) {

                                if (loan == 0 && EXP == 1) {

                                    if (DL == 0 && (annualInterestRate * state_rate_25 - loanAmount) >= 200 && Math.min((annualInterestRate * state_rate_25 - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1000) / 2 >= Math.abs(negative_balance)) {

                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * state_rate_25 - loanAmount), 200), 1000), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else if ((DL == 1 && (annualInterestRate * state_rate_35 - loanAmount) >= 200 && Math.min((annualInterestRate * state_rate_25  - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1500) / 2 >= Math.abs(negative_balance))) {

                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * state_rate_25  - loanAmount), 200), 1500), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));

                                    } else {
                                        this.frm_fields.items.approved_loan_amount = 'Not Qualify';
                                    }

                                } else if (loan == 0 && EXP == 0) {


                                    if (DL == 0 && (annualInterestRate * state_rate_35 - loanAmount) >= 700 && Math.min((annualInterestRate * state_rate_35 - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1000) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * state_rate_25 - loanAmount), 700), 1000), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));


                                    } else if (DL == 0 && (annualInterestRate * state_rate_35 - loanAmount) < 700 && Math.min((annualInterestRate * state_rate_35 - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1000) / 2 >= Math.abs(negative_balance) && (annualInterestRate * state_rate_35 - loanAmount) >= 200) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round((annualInterestRate * state_rate_35 - loanAmount), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));


                                    } else if (DL == 1 && (annualInterestRate * state_rate_35 - loanAmount) >= 700 && Math.min((annualInterestRate * state_rate_35 - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1500) / 2 >= Math.abs(negative_balance)) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round(Math.min(Math.max((annualInterestRate * state_rate_35 - loanAmount), 700), 1500), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));


                                    } else if (DL == 1 && (annualInterestRate * state_rate_35 - loanAmount) < 700 && Math.min((annualInterestRate * state_rate_35 - loanAmount), Math.round((final_ending_balance_with_state_rate - loanAmount), 2), 1500) / 2 >= Math.abs(negative_balance) && (annualInterestRate * state_rate_35 - loanAmount) >= 200) {
                                        this.frm_fields.items.approved_loan_amount = Math.min(Math.round((annualInterestRate * state_rate_35- loanAmount), 2), Math.round((final_ending_balance_with_state_rate - loanAmount), 2));


                                    } else {
                                        this.frm_fields.items.approved_loan_amount = 'Not Qualify';

                                    }

                                } else if (loan == 1
                                    && (annualInterestRate * state_rate_40 - loanAmount) >= 200
                                    && number_of_open_loans <= 3
                                    && DL == 1
                                    // && Port == 'INBX'
                                    && (Math.min(Math.max(annualInterestRate * state_rate_40 - loanAmount, 200), 2500)) / 1.5 >= Math.abs(negative_balance)
                                    && (annualInterestRate * state_rate_40 - loanAmount) >= 1100)
                                {
                                    // console.log('pass 1');
                                    this.frm_fields.items.approved_loan_amount = Math.round(Math.min(Math.max(annualInterestRate * state_rate_40 - loanAmount, 200), 5000), 2);


                                } else if (loan == 1
                                    && (annualInterestRate * state_rate_40 - loanAmount) >= 200
                                    && number_of_open_loans <= 3
                                    && DL == 0
                                    && (Math.min(Math.max(annualInterestRate * state_rate_30 - loanAmount, 1100), 5000)) / 1.5 >= Math.abs(negative_balance)
                                    && (annualInterestRate * state_rate_40 - loanAmount) >= 1100)
                                {

                                    this.frm_fields.items.approved_loan_amount = Math.round(Math.min(Math.max(annualInterestRate * state_rate_30 - loanAmount, 1100), 5000), 2);

                                } else if (loan > 1
                                    && (annualInterestRate * state_rate_45 - loanAmount) >= 200
                                    && number_of_open_loans <= 3
                                    && DL == 1
                                    && (Math.min(Math.max(annualInterestRate * state_rate_45 - loanAmount, 200), 5000)) / 1.5 >= Math.abs(negative_balance)
                                    && (annualInterestRate * state_rate_45 - loanAmount) >= 1100)
                                {
                                    // console.log('pass 2');
                                    this.frm_fields.items.approved_loan_amount = Math.round(Math.min(Math.max(annualInterestRate * state_rate_45 - loanAmount, 200), 5000), 2);


                                } else if (loan > 1
                                    && (annualInterestRate * state_rate_45 - loanAmount) >= 200
                                    && number_of_open_loans <= 3
                                    && DL == 0
                                    && Math.min(Math.max(annualInterestRate * state_rate_35 - loanAmount, 1100), 5000) / 1.5 >= Math.abs(negative_balance)
                                    && (annualInterestRate * state_rate_45 - loanAmount) >= 1100)
                                {
                                    this.frm_fields.items.approved_loan_amount = Math.round(Math.min(Math.max(annualInterestRate * state_rate_35 - loanAmount, 1100), 5000), 2);


                                } else if (loan == 1
                                    && (annualInterestRate * state_rate_40 - loanAmount) >= 200
                                    && (annualInterestRate * state_rate_40 - loanAmount) <= 1100
                                    && (annualInterestRate * state_rate_40 - loanAmount) / 1.5 >= Math.abs(negative_balance)
                                    && number_of_open_loans <= 3)
                                {
                                    // console.log('pass 3');

                                    this.frm_fields.items.approved_loan_amount = Math.round((annualInterestRate * state_rate_40 - loanAmount), 2);

                                } else if (loan > 1
                                    && (annualInterestRate * state_rate_45 - loanAmount) >= 200
                                    && (annualInterestRate * state_rate_45 - loanAmount) <= 1100
                                    && (annualInterestRate * state_rate_45 - loanAmount) / 1.5 >= Math.abs(negative_balance)
                                    && number_of_open_loans <= 3) {

                                    // console.log('pass 4');
                                    this.frm_fields.items.approved_loan_amount = Math.round((annualInterestRate * state_rate_45 - loanAmount), 2);

                                } else {
                                    this.frm_fields.items.approved_loan_amount = 'Not Qualify';
                                }


                            } else {
                                this.frm_fields.items.approved_loan_amount = "Not Qualify";
                            }
                        break;
                }


                if (final_ending_balance < 200) {
                    this.frm_fields.items.approved_loan_amount = "Not Qualify";
                }

                return;
            },
            /* End Calculation of monthly income and Approved loan amount */
            calculate(event) {

                var i, loop_val = 1, cnt_vl = 0;
                for (i = 1; i < loop_val + 1; i++) {
                    cnt_vl += ($('input[name="view_data['+i+'][date]').val().length > 0 ? 1 : 0);
                    cnt_vl += $('input[name="view_data['+i+'][ddAmount]').val().length > 0 ? 1 : 0;
                    cnt_vl += $('input[name="view_data['+i+'][eodAmount]').val().length > 0 ? 1 : 0;
                }

                let fields = this.frm_fields;

                let new_ret_validation = {};
                if(fields.items.new_ret == 'new') {
                    new_ret_validation = { 'input_pay_frequency': fields.items.input_pay_frequency,
                        'num_of_open_of_loans': fields.items.num_of_open_of_loans,
                        'open_loan_amount': fields.items.open_loan_amount,
                        'is_exception': fields.items.is_exception,
                        'negative_balance': fields.items.negative_balance
                    }

                } else {

                    new_ret_validation = { 'input_pay_frequency': fields.items.input_pay_frequency,
                        'num_of_open_of_loans': fields.items.num_of_open_of_loans,
                        'open_loan_amount': fields.items.open_loan_amount,
                        'num_of_paid_of_loans': fields.items.num_of_paid_of_loans,
                        'is_exception': fields.items.is_exception,
                        'negative_balance': fields.items.negative_balance
                    }

                }

                this.frm_fields.items.state = (typeof this.frm_fields.items.state == "object") ? this.frm_fields.items.state['alpha-2'] : this.frm_fields.items.state;

                this.$validator.validateAll(new_ret_validation).then((result) => {
                    if (result) {

                        let states = vps.settings.states;

                        for (var i = 0; i < states.length; i++){
                            if (states[i].code == this.frm_fields.items.state){
                                this.matrix_states = states[i];
                                console.log(states[i].name + ' - rate :' + states[i].rate);
                                this.monthlyIncome();
                                return;
                            }
                        }

                    }
                });

            },

            onChangePortfolio(event) {
                let fields = this.frm_fields;

                fields.items.first_name = '';
                fields.items.last_name = '';
                fields.items.email = '';
                fields.items.ssn = '';
                fields.items.state = '';

                switch (this.frm_fields.items.portfolio) {
                    case 'SOF':
                       this.verify_btn = false;
                       return;
                    default :
                        this.verify_btn = true;
                        return;

                }

            },

            verifyApp(event) {

                let fields = this.frm_fields;

                this.$validator.validateAll({ 'loan_id': fields.items.loan_id, 'portfolio': fields.items.portfolio })
                    .then(result => {

                        if (!result) {
                            return;
                        }

                        document.body.style.cursor='wait';
                        let ld = Ladda.create(event.target);
                        ld.start();

                        switch (this.frm_fields.items.portfolio) {
                            case 'IBC':
                            case 'COMET':
                                this.verify_links = this.$constants.LMS.get(fields.items.portfolio+'/verifyCustomer', {params : {'portfolio' : this.frm_fields.items.portfolio,'app_no': this.frm_fields.items.loan_id}});
                                break;
                            default :
                                this.verify_links = this.$constants.Epic_API.get(fields.items.portfolio+'/prod/verifyCustomer', {params : {'app_no': this.frm_fields.items.loan_id}});
                                break;
                        }

                        this.verify_links.then(response => {
                                ld.stop();
                            document.body.style.cursor='pointer';

                            if (response.data.error) {
                                swal({
                                    type: 'error',
                                    title: 'Verification Error',
                                    html:  'Unable to Verify App ID Error : ' + response.data.message,
                                });

                                return;
                            }

                            fields.items.first_name = response.data.firstName;
                            fields.items.last_name = response.data.lastName;
                            fields.items.email = response.data.emailAddress;
                            fields.items.ssn =  '******' + response.data.ssn.substring(5,9);
                            fields.items.ssn_complete =  response.data.ssn;
                            fields.items.state = response.data.state;
                            fields.items.submitDisable = false;

                        }).catch(e => {
                            ld.stop();
                            document.body.style.cursor='auto';
                        })

                    }).catch(() => {
                        swal({
                            type: 'error',
                            title: 'Verification Error',
                            html:  'Please try again after 60sec \n\n Unable to Verify data from Epic \n\n Error : ' + response.data.message,
                        });
                    ld.stop();
                    });

            },

            SubmitApplication(submitEvent) {

                submitEvent.preventDefault();
                let fields = this.frm_fields;

                var frm = document.getElementById('app_form');
                let formData = new FormData(frm);
                // console.log(fields.items.state);
                formData.append('state', (typeof this.frm_fields.items.state == "object") ? this.frm_fields.items.state['alpha-2'] : this.frm_fields.items.state);
                formData.append('pay_frequency', fields.items.input_pay_frequency);

                // this.frm_fields.items.approved_loan_amount = "Not Qualify";


                this.$validator.validateAll(fields.items).then((result) => {
                    if (result) {

                        if(this.frm_fields.items.approved_loan_amount === "Not Qualify" || this.frm_fields.items.approved_loan_amount === '') {
                            swal({
                                type: 'warning',
                                title: '',
                                html: '<strong>Application Approved loan amount is Not Qualified</strong>',
                            });
                            return;
                        }

                        document.body.style.cursor='wait';
                        let ld = Ladda.create(event.target);
                        ld.start();

                        this.$constants.LoanApp_API.post('/application', formData, {
                            validateStatus: function (status) {
                                return status >= 200 && status < 424; // default
                            },})
                            .then(response => {

                                let errors_lenght = (response.data.errors == null) ? 0 : Object.keys(response.data.errors).length;
                                // console.log(errors_lenght);

                                if(errors_lenght >= 1) {
                                    this.alertErrorList(response.data);
                                } else {
                                    swal({
                                        type: 'success',
                                        title: '',
                                        html: response.data.message,
                                    });
                                    frm.reset();

                                    this.frm_fields = inititaeForm();

                                }


                        }).catch(e => {
                            console.log(e);
                        });
                        ld.stop();
                        document.body.style.cursor='auto';

                        return;

                    }
                });
            },

        },

    }
</script>

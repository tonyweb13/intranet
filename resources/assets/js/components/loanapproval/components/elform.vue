<template>
    <div class="panel-body col-lg-12">

        <el-form :model="app_frm" :rules="rules" ref="app_frm"  :label-position="'top'">
            <div class="col-lg-6">

                <div class="row">
                    <div class="col-lg-6">
                        <el-form-item label="Loan ID" prop="loan_id"  >
                            <el-input  v-model="app_frm.loan_id" placeholder="Load ID"></el-input>
                        </el-form-item>

                        <el-form-item label="First Name" >
                            <el-input v-model="app_frm.first_name" :readonly="true"></el-input>
                        </el-form-item>

                        <!--<div class="form-group">-->
                            <!--<label>First Name</label>-->
                            <!--<input type="text" name="c" class="form-control input-sm" readonly>-->
                        <!--</div>-->
                        <el-form-item label="E-mail" >
                            <el-input v-model="app_frm.email" :readonly="true"></el-input>
                        </el-form-item>

                        <div class="form-group">
                            <label>State</label>
                            <div class="clearfix"/>
                            <select class="form-control input-sm state" name="state">
                                <option></option>
                                <option v-for="items in us_states" v-bind:value="items['alpha-2']" >{{ items['alpha-2'] }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <fieldset>
                                <legend>New or Returning</legend>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks" style="margin-left: 10px;">
                                    <label>
                                        New&nbsp;&nbsp;&nbsp;
                                        <input type="radio" checked="checked" value="new"  name="new_ret">
                                    </label>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6 i-checks">
                                    <label>
                                        Returning&nbsp;&nbsp;&nbsp;
                                        <input type="radio" value="returning" name="new_ret">
                                    </label>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <el-form-item label="Portfolio">
                            <el-select  v-model="app_frm.portfolio" placeholder="Please Select Portfolio"  >
                                <el-option label="Inbox Loan - (INBX)" value="INBX"></el-option>
                                <el-option label="Send Loan - (SLS)" value="SLS"></el-option>
                                <el-option label="Northern Plains Funding - (NPF)" value="NPF"></el-option>
                                <el-option label="Solid Oak Finance - (SOF)" value="SOF"></el-option>
                            </el-select>
                        </el-form-item>
                        <!--<div class="form-group">-->
                            <!--<label>Portfolio</label>-->
                            <!--<select class="form-control input-sm" name="portfolio">-->
                                <!--<option selected></option>-->
                                <!--<option value=""></option>-->
                                <!--<option value="SLS">Send Loan - (SLS)</option>-->
                                <!--<option value="INBX">Inbox Loan - (INBX)</option>-->
                                <!--<option value="SOF">c</option>-->
                            <!--</select>-->
                        <!--</div>-->

                        <el-form-item label="Last Name" >
                            <el-input v-model="app_frm.last_name" :readonly="true" ></el-input>
                        </el-form-item>
                        <el-form-item label="SSN" >
                            <el-input v-model="app_frm.ssn" :readonly="true" ></el-input>
                        </el-form-item>

                        <div class="form-group">
                            <label>Decision Logic</label>
                            <input type="text" name="dl_id" placeholder="Request Code" class="form-control input-sm">
                        </div>

                        <div class="form-group">
                            <label>Ending Balance of the Day</label>
                            <input type="text" name="ebd" placeholder="Ending balance" class="form-control input-sm">
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <fieldset>
                        <legend>Verification of Employment</legend>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4 i-checks" style="margin-left: 10px;">
                            <label>
                                Regular Voe &nbsp;&nbsp;
                                <input type="radio" checked="checked" value="regular voe"  name="voe_ret">
                            </label>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 i-checks">
                            <label>
                                No Voe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="no voe" name="voe_ret">
                            </label>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 i-checks">
                            <label>
                                Strong Voe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" value="strong voe" name="voe_ret">
                            </label>
                        </div>
                    </fieldset>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="clearfix"/>
                <vob_inputs input_date_name="vob_date[]" input_dd_name="vob_dd[]" input_eod_name="vob_eod[]" />
            </div>
            <div class="clearfix"/>
            <hr class="hr">
            <button class="btn btn-info " type="button"><i class="fa fa-check"></i>&nbsp;Submit</button>

        </el-form>
    </div>
</template>
<style>
    .el-form-item__content,
    .el-form-item__label {
        line-height: 20px !important;
        clear:both;
        with:100%;
    }
    .el-select {
        width: 100%;
    }
    .el-input input[readonly] {
        cursor: not-allowed !important;
    }
    .el-select input[readonly] {
        cursor:auto !important;
    }
    fieldset {
        padding: .35em .625em .75em;
        border: 1px solid #e5e5e5;
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
    import Inputmask from "inputmask"

    export default {
        components: { constants, vob_inputs, Inputmask},
        data(){
            return {
                us_states : this.$constants.us_states,
                app_frm: {
                    loan_id : '',
                    first_name : '--',
                    last_name : '--',
                    email : '--',
                    ssn : '--',
                    portfolio  : '',
                    state   : '',
                    decision_logic : '',
                    ending_balance: '',
                },
                rules: {
                    loan_id: [
                        { required: true, message: 'Please input Load ID', trigger: 'blur' },
                    ],


                }
            }
        },
        methods: {
            greet: function (event) {
                if (event) {
                    alert(event.target.tagName)
                }
            },
        },
        mounted(){
            // // console.log(VeeValidate);
            // $('.i-checks').iCheck({
            //     checkboxClass: 'icheckbox_square-green',
            //     radioClass: 'iradio_square-green',
            // });
            //
            $('#application_form .date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

            Inputmask({alias: "decimal", integerDigits: 9, digits: 2, allowMinus: false}).mask(document.querySelectorAll("#application_form .input_amount"));

            $(".state").select2({
                placeholder: "Select a state",
                allowClear: true
            });

            window.onbeforeunload = function() {
                return "Data will be lost if you leave the page, are you sure?";
            };
        }
    }
</script>

<template>
 <div>
    <!--{{view_data}}-->

     <!--<div class="row" v-for="(item, index) in view_data ">-->
     <!--&lt;!&ndash;<div class="row" v-for="items in loop_fields ">&ndash;&gt;-->
         <!--{{item}} {{index}}-->
         <!--<input  @change="" type="text" v-model="index.date" class="form-control" placeholder="MM/DD/YYYY" >-->

     <!--</div>-->

    <label>Verification of Bank ( VOB )</label>
    <div class="clearfix"/>

    <div class="row" v-for="(items, index) in view_data">

        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <div class="form-group">
                <div class="input-group date">
                    <span class="input-group-addon">{{parseInt(index) + 1}}. <i class="fa fa-calendar"></i></span>
                    <input type="text" v-model="items.date" :ref="'date' + index " :name="'view_data[' + index +'][date]'" v-bind:ref="'vob['+ index +'][date]'"  class="form-control" placeholder="MM/DD/YYYY">
                    <!--<input type="text" v-model="itemsdata[items].date"  :name="'vob[' + items +'][date]'" v-bind:ref="'vob['+items+'][date]'"  class="form-control" placeholder="MM/DD/YYYY" >-->
                    <!--{{test[items][date]}}-->
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <div class="form-group">
                <div class="input-group m-b"><span class="input-group-addon">$</span>
                    <input type="text"  v-model="items.ddAmount" :name="'view_data[' + index +'][ddAmount]'" v-bind:ref="'vob['+ index +'][ddAmount]'" class="form-control input_amount" placeholder="DD Amount" >
                    <!--<input type="text" v-model="itemsdata[items].ddAmount" :name="'vob[' + items +'][ddAmount]'" v-bind:ref="'vob['+items+'][ddAmount]'" class="form-control input_amount" placeholder="DD Amount">-->
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
            <div class="form-group">
                <div class="input-group m-b"><span class="input-group-addon">$</span>
                    <input   type="text"  v-model="items.eodAmount" :name="'view_data[' + index +'][eodAmount]'"  v-bind:ref="'vob['+ index +'][eodAmount]'" class="form-control input_amount" placeholder="EOD Amount">
                    <!--<input   type="text" v-model="itemsdata[items].eodAmount" :name="'vob[' + items +'][eodAmount]'"  v-bind:ref="'vob['+items+'][eodAmount]'" class="form-control input_amount" placeholder="EOD Amount">-->
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    'use strict';

    export default {
        data() {
            return {
                vob : {
                    0 : { date: "", ddAmount: 0, eodAmount: 0 },
                    1 : { date: "", ddAmount: 0, eodAmount: 0 },
                    2 : { date: "", ddAmount: 0, eodAmount: 0 },
                    3 : { date: "", ddAmount: 0, eodAmount: 0 },
                    4 : { date: "", ddAmount: 0, eodAmount: 0 },
                    5 : { date: "", ddAmount: 0, eodAmount: 0 }
                },
            }
        },
        props : {
            input_date_name : {
                type: String,
                required : false,
            },
            input_dd_name : {
                type: String,
                required: false,
            },
            input_eod_name : {
                type: String,
                required: false,
            },
            loop_fields: {
                type: Number,
                required: false,
                default : 6,
            },
            view_data : {
                type: Object,
                required: true,
            }
        },
        created: function () {

        },
        computed: {

        },
        watch : {

        },
        methods: {

        },
        mounted() {
            let vob_component = this.$parent;

            $('#app_form .date').datepicker().on('changeDate', function(e) {
                vob_component.uptDate();
                // console.log(e.format());
                // for (let i = 0; i < 6 ; i++) {
                //     vobs[i].date = $('input[name="view_data['+i+'][date]').val();
                // }
            });

            // // console.log(vobs);

        }
    }
</script>



<
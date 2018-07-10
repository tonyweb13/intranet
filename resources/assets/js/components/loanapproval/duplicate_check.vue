
<template>
     <div >
         <div class="panel panel-primary" style="margin-top:20px;">
             <div class="panel-heading">
                 <h3>
                     <span class="label label-danger pull-left"></span>&nbsp;&nbsp;<strong>Duplicate Portfolio</strong>
                 </h3>
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-md-4">
                         <p>Please fill in the fields to validate.</p>
                         <form id="dedupcheck_frm" name="dedupcheck_frm" action="" method="post" role="form" v-on:submit.prevent>
                             <div class="form-group">
                                 <label>Portfolio <span class="required_fields">*</span></label>
                                 <select class="form-control input-sm"
                                         v-model="fields.portfolio"
                                         name="portfolio"
                                         v-validate="'required'"
                                         :class="{'input': true, 'is-danger': errors.has('portfolio') }"
                                         data-vv-as="Portfolio">
                                     <option selected> </option>
                                     <option value="INBX">Inbox Loan - (INBX)</option>
                                     <!--&lt;!&ndash;<option value="SLS">Send Loan - (SLS)</option>&ndash;&gt;-->
                                     <option value="SOF">Solid Oak Finance - (SOF)</option>
                                     <option value="COMET">Comet Loans - (COMET)</option>
                                     <option value="IBC">Inbox Credit - (IBC)</option>
                                     <!--<option value="NPF">Northern Plains Funding - (NPF)</option>-->
                                 </select>
                                 <span v-show="errors.has('portfolio')" class="help is-danger">
                                {{ errors.first('portfolio') }}
                            </span>
                         </div>
                             <p>* Note : The selected portfolio from the dropdown will be excluded from the duplicate check</p>
                        <div class="form-group">
                         <label>SSN No. #</label>
                         <input name='ssn_num' v-model="fields.ssn_no"  autocomplete="off" type="text" placeholder=""  class="form-control" data-validation="croscheck">
                         </div>
                         <div class="form-group">
                         <label>Bank Account No. #</label>
                         <input name='bank_num' v-model="fields.bank_account_no"  autocomplete="off" type="text" placeholder=""   class="form-control" data-validation="croscheck">
                         </div>
                         <div class="form-group">
                         <label>Email</label>
                         <input name='emailaddress' v-model="fields.email"  autocomplete="off" type="email" placeholder=""   class="form-control" data-validation="croscheck" data-validation-error-msg="Email required if Loan ID or First name & Last name not provided">
                         </div>
                         <div class="form-group">
                         <label>First Name</label>
                         <input name='fname' v-model="fields.fname" autocomplete="off" type="text" placeholder=""  class="form-control" data-validation="croscheck">
                         </div>
                         <div class="form-group">
                         <label>Last Name</label>
                         <input name='lname' v-model="fields.lname" autocomplete="off" type="text" placeholder=""   class="form-control" data-validation="croscheck">
                         </div>


                         <div class="clearfix" style="margin:20px"></div>
                         <button id="check_duplicate" class="ladda-button btn-lg btn-primary" @click="checkDuplicate" data-style="expand-right" type="submit"><strong>Check Duplicate</strong></button>
                         <!--<button id="btnsubmit" class="ladda-button btn-lg btn-default pull-right" data-style="expand-left" type="submit" disabled><strong>Submit</strong></button>-->
                         </form>

                     </div>


                     <div class="col-md-7 pull-right result_div" >
                         <ul class="sortable-list connectList agile-list ui-sortable" id="list_duplicates">

                         </ul>
                         <div id="divresult" class="divresult">
                         <div>
                     </div>
                 </div>
             </div>
         </div>
             </div>
         </div>
    </div>
</template>
<style>
    .tbl_result td {
        padding:5px 10px !important;
    }
    h3 {
        margin:0px 0px 0px 0px !important;
    }
    .sortable-list .ui-sortable-handle h3 {
        margin-bottom:10px !important;
    }

    .td{
        padding: 10px 10px !important;
    }
    .divresult {
        margin-bottom: 20px;
    }
    .result_div {
        margin-right:30px;
    }


</style>
<script>
    import app_form from '../loanapproval/components/form.vue'
    import statusCode from '../loanapproval/statusCode.vue'

    export default {
        components: {app_form, statusCode },
        data(){
            return {
                fields : {
                    portfolio : '',
                    ssn_no : '',
                    bank_account_no : '',
                    email : '',
                    fname : '',
                    lname : '',
                },
                portfolios_vps : vps.settings.portfolios,
            }
        },

        mounted(){

        },
        methods: {
            viewResultToUser : function () {
                $("#divresult").append(htmlData);
            },
            getResult : function (portfolio) {
                /*
                * Note : I did use the jquery append rather than the natural way of pushing data to array and bind the data and print as html due to effects for fadeout in removing the loader
                * */
                $("#list_duplicates").empty();
               let add_loader = '<div id="loading_'+portfolio+'" style="text-align:center;margin-bottom:50px;">\n' +
                    '                             <div class="h1 m-t-xs text-navy">\n' +
                    '                                 <span class="loading open-circle"></span>\n' +
                    '                             </div>\n' +
                    '                             <h4>Please wait Checking Duplicate on <span class="text-warning">'+portfolio+'</span></h4>\n' +
                    '                         </div>';
                $("#divresult").append(add_loader);

                this.$constants.LoanApp_API.get('/check_portfolios/', {'params' : {'fields' : this.fields, 'check' : portfolio},}, {
                    validateStatus: function (status) {
                        return status >= 200 && status < 424; // default
                    },})
                    .then(response => {

                        if(response.data.error){
                            $('#loading_'+portfolio).fadeOut('slow');
                            $("#list_duplicates").append('<li class="success-element ui-sortable-handle">\n' +
                                '                                <div class="agile-detail">\n' +
                                '                                <h3>No duplicate result on portfolio : <strong class="text-success">'+portfolio+'</strong></h3>\n' +
                                '                            </div>\n' +
                                '                  </li>');
                            return;
                        }

                        if(response.data.msg == null) {
                            $('#loading_'+portfolio).fadeOut('slow');
                            $("#list_duplicates").append('<li class="success-element ui-sortable-handle">\n' +
                                '                                <div class="agile-detail">\n' +
                                '                                <h3>No duplicate result on portfolio : <strong class="text-success">'+portfolio+'</strong></h3>\n' +
                                '                            </div>\n' +
                                '                  </li>');
                            return;
                        }

                        let results_data = response.data.msg;

                        let link_url = '';
                        switch (portfolio) {
                            case 'INBX' :
                                link_url = 'https://inbx.epicloansystems.com/Employee/ClientDashboard/Default.aspx?cid='+results_data.id
                                break;
                            case 'SOF' :
                                link_url = 'https://inbx.epicloansystems.com/Employee/ClientDashboard/Default.aspx?cid='+results_data.id
                                break;
                            case 'IBC' :
                                link_url = 'https://inbox-credit.vertical.arbcalls.com/lead/'+results_data.id
                                break;
                            case 'COMET' :
                                link_url = 'http://comet.vertical.arbcalls.com/lead/'+results_data.id
                                break;


                        }

                        $("#divresult").append(' <div id="divresult" class="divresult">\n' +
                            '                              <ul class="sortable-list connectList agile-list ui-sortable" id="list_duplicates">\n' +
                            '                                 <li class="danger-element ui-sortable-handle" id="task4">\n' +
                            '                                     <h3 style="margin-bottom:20px;">Duplicate found in Portfolio : <strong class="text-success">'+portfolio+'</strong></h3>\n' +
                            '                                     <table class="table table-bordered">\n' +
                            '                                         <tbody>\n' +
                            '                                         <tr>\n' +
                            '                                             <td class="col-md-4"><strong>FIRST NAME</strong></td>\n' +
                            '                                             <td>'+results_data.first_name+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         <tr>\n' +
                            '                                             <td><strong>LAST NAME</strong></td>\n' +
                            '                                             <td>'+results_data.last_name+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         <tr>\n' +
                            '                                             <td><strong>E-MAIL</strong></td>\n' +
                            '                                             <td>'+results_data.email+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         <tr>\n' +
                            '                                             <td><strong>SSN</strong></td>\n' +
                            '                                             <td>'+results_data.ssn+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         <tr>\n' +
                            '                                             <td><strong>ACCOUNT</strong></td>\n' +
                            '                                             <td>'+results_data.customer_account+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         <tr>\n' +
                            '                                             <td><strong>STATUS</strong></td>\n' +
                            '                                             <td>'+results_data.status+'</td>\n' +
                            '                                         </tr>\n' +
                            '                                         </tbody>\n' +
                            '                                     </table>\n' +
                            '                                     <div class="agile-detail">\n' +
                            '                                         <p>Application Link : <a href='+link_url+' target="_blank">'+link_url+'</a></p>\n' +
                            '                                     </div>\n' +
                            '                                 </li>\n' +
                            '                              </ul>\n' +
                            '                         <div>\n' +
                            '\n' +
                            '                     </div>\n' +
                            '                 </div>');

                        $('#loading_'+portfolio).fadeOut('slow');

                    }).catch(e => {
                    swal({type: 'error', title: '', html: 'Error : '.e,});
                });
            },
            checkDuplicate: function () {

                this.html_loading = [];
                let count_empty = 0;
                for (let index in this.fields) {    // don't actually do this

                    if(index != 'portfolio') {
                        if (this.fields[index] == 0) {
                            count_empty++;
                        }
                    }
                }

                if(count_empty == 5) {
                    swal({type: 'warning',
                        allowOutsideClick : false ,
                        timer: 20000,
                        html: 'Please fill in the fields to validate' ,
                    });
                    return;
                }

                this.$validator.validateAll({ 'portfolio' : this.fields.portfolio}).then((result) => {
                    if (result) {
                        document.body.style.cursor='wait';
                        let ld = Ladda.create(event.target);
                        ld.start();
                        $('#loadspinner').css('display:block');
                        $("#divresult").empty();
                        for (let reference in this.portfolios_vps) {
                            if(this.fields.portfolio != this.portfolios_vps[reference].name) {
                                this.getResult(this.portfolios_vps[reference].name);
                            }
                        }

                        ld.stop();
                        document.body.style.cursor='auto';

                        return;
                    }
                });



            },
        }
    }

</script>
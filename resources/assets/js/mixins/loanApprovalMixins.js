function inititaeForm () {
    return  {
        data : {
            vob : {},
        },
        items: {
            app_id : '',
                num_of_open_of_loans : '',
                open_loan_amount : '',
                num_of_paid_of_loans : '',
                is_exception : '',
                negative_balance : '',
                loan_id: '',
                first_name : '',
                last_name : '',
                email : '',
                ssn : '',
                ssn_complete : '',
                portfolio: '',
                state : '',
                input_pay_frequency : '',
                dl_id : '',
                ebd : '',
                new_ret : '',
                voe_ret : '',
                vob : {
                0 : { date: "", ddAmount: 0, eodAmount: 0 },
                1 : { date: "", ddAmount: 0, eodAmount: 0 },
                2 : { date: "", ddAmount: 0, eodAmount: 0 },
                3 : { date: "", ddAmount: 0, eodAmount: 0 },
                4 : { date: "", ddAmount: 0, eodAmount: 0 },
                5 : { date: "", ddAmount: 0, eodAmount: 0 }
            },
            vob_session_id : '',
                monthly_income : '',
                approved_loan_amount : '',
                submitDisable : false,
                status : 0,
        },
};
}

export default {
    data() {
        return {
            openModal: false,
            form_name : '',
            matrix_states : '',
            verify_btn : true,
            verify_links : '',
            correction_data : {},
            frm_fields: {
                data : {
                    vob : {},
                },
                items: {
                    app_id : '',
                    num_of_open_of_loans : '',
                    open_loan_amount : '',
                    num_of_paid_of_loans : '',
                    is_exception : '',
                    negative_balance : '',
                    loan_id: '',
                    first_name : '',
                    last_name : '',
                    email : '',
                    ssn : '',
                    ssn_complete : '',
                    portfolio: '' ,
                    state : '',
                    input_pay_frequency : '',
                    dl_id : '',
                    ebd : '',
                    new_ret : '',
                    voe_ret : '',
                    vob : {
                        0 : { date: "", ddAmount: 0, eodAmount: 0 },
                        1 : { date: "", ddAmount: 0, eodAmount: 0 },
                        2 : { date: "", ddAmount: 0, eodAmount: 0 },
                        3 : { date: "", ddAmount: 0, eodAmount: 0 },
                        4 : { date: "", ddAmount: 0, eodAmount: 0 },
                        5 : { date: "", ddAmount: 0, eodAmount: 0 }
                    },
                    vob_session_id : '',
                    monthly_income : '',
                    approved_loan_amount : '',
                    submitDisable : false,
                    status : 0,
                },
            },
            frm_transition : {
                is_view : false,
            },
            us_states : this.$constants.us_states,
            pay_frequencys : this.$constants.pay_frequency,
            form_rules : vps.settings.acl_rules.rules.loanapproval.child_rules,
            rulesActions : {
                view_app : false,
                reassign_app : false,
                process_app : false,
                update_app : false,
                correction_app : false,
                return_app : false,
                deny_app : false,
                approve_app : false,
            },
            rulesApplicationList : {
                grab_app : false,
                queue_app : false,
                pending_app : false,
                approved_app : false,
                correction_app : false,
                deny_app : false,
                approve_app : false,
            },
            portfolios : [],
            portfolios_vps : vps.settings.portfolios,
            correction_list : { checklist : [], others : ''},
        }
    },
    created(){
        this.changeActionRules();
        this.changePortfolios();
        this.changeApplicationList();

      if(this.portfolios_vps.length == 0 ) {
          swal({type: 'info',
              allowOutsideClick : false ,
              title: 'No Associated Portfolio ',
              timer: 20000,
              showCancelButton: false,
              html: 'Please Contact IT Support <br> You will not be able to submit <br>Applications or Browse Portfolio',});
      }

        this.frm_fields.items.portfolio = ((this.portfolios_vps.length == 1) ? this.portfolios_vps[0].name : '');


    },

    mounted(){
        // console.log(this.portfolios);
        // console.log(vps.settings.portfolios)
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    },

    methods: {
        uptDate: function() {
            for (let i = 0; i < 6 ; i++) {
                console.log(this.frm_fields.items.vob[i].date);
                this.frm_fields.items.vob[i].date = $('input[name="view_data['+i+'][date]').val();
            }
        },
        correctionHandleData: function(e) {
            [this.correction_list.checklist, this.correction_list.others] = e;
        },
        changeActionRules: function () {

            for (let rl in this.rulesActions) {
                // console.log(this.form_rules.applicationform.child_rules[rl]);
                let new_rules = [];
                if (this.form_rules.application_action.child_rules[rl]) {
                    this.rulesActions[rl] = this.form_rules.application_action.child_rules[rl];
                }

                if(rl == 'return_app' && this.employee.designation.name == 'Loan Agent') {
                    this.rulesActions[rl] = true;
                }
            }
            // console.log(this.rules);
        },
        changeApplicationList: function () {

            for (let rl in this.rulesApplicationList) {
                let new_rules = [];
                if (this.form_rules.application_list.child_rules[rl]) {
                    this.rulesApplicationList[rl] = this.form_rules.application_list.child_rules[rl];
                }

                if (rl == 'grab_app' && vps.settings.auth_user.designation.name == 'Loan Agent') {
                    this.rulesApplicationList[rl] = false;
                }
            }
            // console.log(this.rules);
        },
        changePortfolios: function () {
            if (vps.settings.acl_rules.rules.portfolios['is_enable']) {
                this.portfolios = vps.settings.acl_rules.rules.portfolios.child_rules || '';
            }
        },
        grabApplication : function () {

                this.$router.push({ path : "/loanapproval/applications/grab/apps"});

                console.log('App Generated');
        },
        loadGrabApp: function () {

            if (this.$route.params.action == 'grab')
            {
                let fields = this.frm_fields;

                this.frm_transition.is_view = true;
                this.$constants.LoanApp_API.get('/application/grab/'+this.$route.params.id).then(response => {

                    if ( response.data.errors ) {

                        if(response.data.queue === 0 ) {

                            swal({type: 'info',
                                allowOutsideClick : false ,
                                confirmButtonText: 'Return to Applications',
                                title: 'Unable to Grab Application',
                                timer: 20000,
                                showCancelButton: false,
                                html:  response.data.msg + '<br> Auto generate Application in  ( <strong class="swal-timer-count text-danger"> ' + 20  + '</strong> sec. ) ',})
                                .then((result) => {

                                    if (result.value) {
                                        this.$router.push({ path : "/loanapproval/applications/" });
                                    } else {
                                        this.loadGrabApp();
                                    }

                                });

                            var e = $(".swal2-content").find(".swal-timer-count");
                            var timeleft = 20;
                            var refreshTimer = setInterval(function(){
                                timeleft--;
                                e.html(timeleft);
                                if(timeleft <= 0)
                                    clearInterval(refreshTimer);
                            },1000);

                            return;
                        }

                        swal({type: 'error',
                            allowOutsideClick : false ,
                            title: 'Unable to Grab Application',
                            html:  response.data.msg + '<br> Please contact system administrator',}).then((result) => {
                            if (result.value) {
                                this.$router.push({ path : "/loanapproval/applications/" });
                            }
                        });

                        return;
                    }
                    // response.data.vob = JSON.parse(response.data.vob);
                    fields.items.app_id = response.data.id;
                    // this.frm_fields.data = response.data;
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

                    fields.items.num_of_open_of_loans = response.data.num_of_open_of_loans;
                    fields.items.open_loan_amount = response.data.open_loan_amount;
                    fields.items.num_of_paid_of_loans = response.data.num_of_paid_of_loans;
                    fields.items.is_exception = response.data.is_exception;
                    fields.items.negative_balance = response.data.negative_balance;
                    fields.items.monthly_income = response.data.monthly_income;
                    fields.items.approved_loan_amount = response.data.approved_loan_amount;

                    fields.items.vob = JSON.parse(response.data.vob);

                    fields.items.status = response.data.status;


                    $(':radio[name=new_ret][value="'+response.data.new_or_returning+'"]').iCheck('check');
                    $(':radio[name=voe_ret][value="'+response.data.voe+'"]').iCheck('check');
                    $(':radio[name=is_exception][value="'+response.data.is_exception+'"]').iCheck('check');

                }).catch(e => {
                    console.log(e);
                    swal({type: 'error',
                        allowOutsideClick : false ,
                        title: 'Unable to Grab Application',
                        html:  'Please reach out to the IT Department',}).then((result) => {
                            if (result.value) {
                                this.$router.push({ path : "/loanapproval/applications/" });
                            }
                    });
                })

                // this.frm_fields.items.loan_id = '0000000';
            }

        },

        UpdateApplication(submitEvent) {
            submitEvent.preventDefault();
            let fields = this.frm_fields;

            var frm = document.getElementById('app_form');
            let formData = new FormData(frm);
            // console.log(fields.items.state);
            formData.append('state', (typeof this.frm_fields.items.state == "object") ? this.frm_fields.items.state['alpha-2'] : this.frm_fields.items.state);
            formData.append('pay_frequency', fields.items.input_pay_frequency);

            let jsonObject = {};

            for (const [key, value]  of formData.entries()) {
                jsonObject[key] = value;
            }

            let vob = [];
            for (let i = 0; i < 6; i++) {
                vob.push({
                    'date' : $('input[name="view_data['+i+'][date]').val(),
                    'ddAmount' : $('input[name="view_data['+i+'][ddAmount]').val(),
                    'eodAmount' : $('input[name="view_data['+i+'][eodAmount]').val(),
                });
            }

            jsonObject['vob'] = vob;

            this.$validator.validateAll(fields.items).then((result) => {
                if (result) {
                    document.body.style.cursor='wait';
                    let ld = Ladda.create(event.target);
                    ld.start();

                    this.$constants.LoanApp_API.put('/application/' + fields.items.app_id, jsonObject, {
                        validateStatus: function (status) {
                            return status >= 200 && status < 424; // default
                        },})
                        .then(response => {
                            let errors_lenght = (response.data.errors == null) ? 0 : Object.keys(response.data.errors).length;
                            // console.log(errors_lenght);

                            if(errors_lenght >= 1) {
                                this.alertErrorList(response.data);
                            } else {

                                if( typeof response.data.no_update !== 'undefined' ) {
                                    toastr.info(response.data.msg);
                                    return;
                                }
                                swal({
                                    type: 'success',
                                    title: '',
                                    html: response.data.msg,
                                });

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

        Approved(submitEvent) {

            submitEvent.preventDefault();
            let fields = this.frm_fields;

            let ld = Ladda.create(event.target);
            ld.start();

            swal({type: 'warning',
                allowOutsideClick : false ,
                confirmButtonText: 'Yes, Approve',
                title: 'Approving Application',
                timer: 20000,
                showCancelButton: true,
                html: 'Please confirm approval of this application' ,
            }).then((result) => {

                if (result.value) {
                    this.$constants.LoanApp_API.patch('/approved', { 'id' : this.frm_fields.items.app_id} , {
                        validateStatus: function (status) {
                            return status >= 200 && status < 424; // default
                        },})
                        .then(response => {
                            console.log(response.data);
                            if(response.data.error) {
                                swal("Error", response.data.msg, "danger");
                            } else {
                                this.$router.push({ path : "/loanapproval/applications/"});
                            }
                            ld.stop();
                        }).catch(e => {
                        console.log(e);
                    });
                }  else {
                    ld.stop();
                }

            });

        },

        Correction(submitEvent) {
            submitEvent.preventDefault();

            if(!this.openModal) {
                 this.openModal = true;
                 return;
            }

            let fields = this.correction_list;

            let ld = Ladda.create(event.target);
            ld.start();

            let errors = 0;

            // console.log(this.correction_list.others.length);
            if(this.correction_list.others.length > 10) {
                    this.submitCorrection(ld);
            } else {
                if(this.correction_list.checklist.length >= 1) {
                    this.submitCorrection(ld);
                }else{
                    swal("Invalid Correction", "Please check atleast one reason for correction or indicate reason from Others", "warning");
                    ld.stop();
                }
            }

        },

        submitCorrection(ld) {
            console.log(this.frm_fields.items.app_id);

            this.$constants.LoanApp_API.put('/corrections/appToCorrection/', { 'corrections' : this.correction_list , 'id' : this.frm_fields.items.app_id } , {
                validateStatus: function (status) {
                    return status >= 200 && status < 424; // default
                },})
                .then(response => {
                    console.log(response.data);
                    swal({
                        type: (response.data.errors) ? 'error' : "success",
                        title: '',
                        html: response.data.msg,
                    }).then((result) => {
                        if (result.value) {

                            this.openModal = false;
                            this.$router.push({ path : "/loanapproval/applications/"});

                        }
                    });

                }).catch(e => {
                  console.log(e);
            });

            ld.stop();
        },

        ReturnBtn(submitEvent) {

            submitEvent.preventDefault();
            let fields = this.frm_fields;

            let ld = Ladda.create(event.target);
            ld.start();

            swal({type: 'warning',
                allowOutsideClick : false ,
                confirmButtonText: 'Yes, Return for Approval',
                title: 'Returning for Approval',
                timer: 20000,
                showCancelButton: true,
                html: 'Please Confirm Application is Corrected <br> This App Will Return to Underwriting Review' ,
                }).then((result) => {

                    if (result.value) {
                        this.$constants.LoanApp_API.patch('/reApproved', { 'id' : this.frm_fields.items.app_id} , {
                            validateStatus: function (status) {
                                return status >= 200 && status < 424; // default
                            },})
                            .then(response => {
                                console.log(response.data);
                                if(response.data.error) {
                                    swal("Error", response.data.msg, "danger");
                                } else {
                                    this.$router.push({ path : "/loanapproval/applications/"});
                                }
                                ld.stop();
                            }).catch(e => {
                            console.log(e);
                        });
                    }  else {
                        ld.stop();
                    }

                });

        },

        DenyBtn(submitEvent) {

            submitEvent.preventDefault();
            let fields = this.frm_fields;

            let ld = Ladda.create(event.target);
            ld.start();

            swal({type: 'error',
                allowOutsideClick : false ,
                confirmButtonText: 'Yes, Deny',
                title: 'Denying Application',
                timer: 20000,
                showCancelButton: true,
                html: 'Please confirm disapproved of this application' ,
            }).then((result) => {

                if (result.value) {
                    this.$constants.LoanApp_API.patch('/deny', { 'id' : this.frm_fields.items.app_id} , {
                        validateStatus: function (status) {
                            return status >= 200 && status < 424; // default
                        },})
                        .then(response => {
                            console.log(response.data);
                            if(response.data.error) {
                                swal("Error", response.data.msg, "danger");
                            } else {
                                this.$router.push({ path : "/loanapproval/applications/"});
                            }
                            ld.stop();
                        }).catch(e => {
                        console.log(e);
                    });
                }  else {
                    ld.stop();
                }

            });
        },

    }
}


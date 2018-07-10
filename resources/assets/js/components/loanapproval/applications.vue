
<template>
    <div class="tabs-container">
        <div id="divgrabapps">
            <button class="btn btn-lg btn-info" v-if="rulesApplicationList.grab_app"  type="button" name="update" @click="grabApplication"><i class="fab fa-get-pocket"></i> Grab Application on Queue</button>
        </div>
        <ul class="nav nav-tabs">
            <li class="active" v-if="rulesApplicationList.queue_app"><a data-toggle="tab"  href="#tab-queue">Queue</a></li>
            <li class="" v-if="rulesApplicationList.pending_app"><a data-toggle="tab"  href="#tab-pending">Pending</a></li>
            <li class="" v-if="rulesApplicationList.approved_app"><a data-toggle="tab"  href="#tab-approved">Approved</a></li>
            <li class="" v-if="rulesApplicationList.correction_app"><a data-toggle="tab"  href="#tab-correction">Correction</a></li>
            <li class="" v-if="rulesApplicationList.deny_app"><a data-toggle="tab"  href="#tab-disapproved">Disapproved</a></li>
        </ul>
        <div class="tab-content">
            <div class="clearfix"></div>

            <div id="tab-queue" v-if="rulesApplicationList.queue_app"   class="tab-pane active">
                <div class="panel-body">
                    <v-server-table url="/api/loanapproval/application/status/1"  @loaded="getList(1)" ref="appQueue" :name="'queue'" :columns="columns.queue" :options="options">
                        <button  slot="viewapp" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                            <i class="fas fa-search ladda"></i> View
                        </button>
                    </v-server-table>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-pending"  v-if="rulesApplicationList.pending_app"  class="tab-pane">
                <div class="panel-body">
                    <v-server-table url="/api/loanapproval/application/status/2" @loaded="getList(2)" ref="appPending" :name="'pending'" :columns="columns.pending" :options="options">
                        <!--<button  slot="processVerification" slot-scope="props" class='btn btn-primary btn-xs' @click="processVerificationRow(props.row.loan_no, props.row.id)">-->
                        <!--<i class="fas fa-cogs ladda"></i> {{ labels.processVerification }}-->
                        <!--</button>-->
                        <button  slot="viewapp" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                            <i class="fas fa-search ladda"></i> View
                        </button>
                        <button  slot="reassign" slot-scope="props" class='btn btn-primary btn-xs' @click="reassignApp(props.row)">
                            <i class="fas fa-hands-helping"></i> Reassign
                        </button>
                    </v-server-table>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-approved" v-if="rulesApplicationList.approved_app"  class="tab-pane">
                <div class="panel-body">
                    <v-server-table url="/api/loanapproval/application/status/3" @loaded="getList(3)" ref="appApproved" :name="'approved'" :columns="columns.approved" :options="options">
                        <button  slot="viewapp" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                            <i class="fas fa-search ladda"></i> View
                        </button>
                    </v-server-table>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-correction" v-if="rulesApplicationList.correction_app" class="tab-pane">
                <div class="panel-body">
                    <v-server-table url="/api/loanapproval/application/status/4" @loaded="getList(4)" ref="appCorrection" :name="'correction'" :columns="columns.correction" :options="options">
                        <!--<button  slot="reassign" slot-scope="props" class='btn btn-primary btn-xs' @click="reassignApp(props.row)">-->
                        <!--<i class="fas fa-hands-helping"></i> Reassign-->
                        <!--</button>-->
                        <button  slot="viewapp" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                            <i class="fas fa-search ladda"></i> View
                        </button>
                    </v-server-table>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-disapproved" v-if="rulesApplicationList.deny_app" class="tab-pane">
                <div class="panel-body">
                    <v-server-table url="/api/loanapproval/application/status/5" @loaded="getList(5)" ref="appDenied" :name="'denied'" :columns="columns.denied" :options="options">
                        <button  slot="viewapp" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                            <i class="fas fa-search ladda"></i> View
                        </button>
                    </v-server-table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- modal for reassignment -->
        <modal v-if="reassignModal" @close="reassignModal=false" >
            <h3 slot="header"><i class="fas fa-hands-helping"></i> Reassign | Loan ID: <span class="text-danger">{{ this.rowModalSelect.loan_no }}</span></h3>
            <reassignApp slot="body" ref="assignApp" :object_row="rowModalSelect"></reassignApp>
            <button  slot="footer"  class='btn btn-primary ' @click="$refs.assignApp.assignApplication()">
                <i class="fas fa-hands-helping"></i> Assign Application
            </button>
        </modal>

        <!-- modal for notes -->
        <modal v-if="notesModal" @close="notesModal=false" v-for="row in rows" v-bind:key="row.id">
            <h3 slot="header"><i class="fa fa fa-comments"></i> Notes | Loan ID: {{ row.loan_no }}</h3>
            <notes-application :notesStatus="notesProps" slot="body" />
        </modal>

    </div>

</template>
<style scoped>
    #divgrabapps {
        position:fixed;
        top:10%;
        right:3%;
    }

    #divgrabapps button{
        -webkit-box-shadow: 6px 7px 5px -5px rgba(0,0,0,0.75);
        -moz-box-shadow: 6px 7px 5px -5px rgba(0,0,0,0.75);
        box-shadow: 6px 7px 5px -5px rgba(0,0,0,0.75);

    }
</style>
<script>
    import statusCode from '../loanapproval/statusCode.vue'
    import loanApproval from '../../mixins/loanApprovalMixins'
    import reassignApp from '../../components/loanapproval/components/reassign.vue'

    export default {
        mixins : [loanApproval],
        components: { statusCode, reassignApp},
        data(){
            return {
                notesProps: {
                    status: '',
                    loan_id: '',
                    application_id: ''
                },
                notesModal: false,
                reassignModal : false,
                rowModalSelect : [],
                laddabtn: '',
                tabActive: '',
                tabpaneActive: '',
                tabNotActive: '',
                tabpaneNotActive: '',
                columns: {
                    default : [],
                    queue : [],
                    pending : [],
                    approved : [],
                    correction : [],
                    denied : [],
                },
                rows:  [],
                options: {
                    // perPage : 1,
                    // saveState : true,
                    filterByColumn: true,
                    perPageValues : [2,4,10,25,50,100],
                    footerHeadings : true,
                    pagination : { chunk:10, },
                    headings : {
                        originator_name : 'Originator',
                        underwriter_name : 'Underwriter',
                        tribe_name : 'Tribe',
                        group_date : 'Date',
                    },
                    templates: {
                        ssn: function (h, row, index) {
                            // console.log(row.ssn.length );
                            return '******' + row.ssn.substr(row.ssn.length -4);
                        },
                        // originator: function (h, row, index) {
                        //     // console.log(row.ssn.length );
                        //     return row.originator_name;
                        // },
                    },
                    params :{
                        portfolios : {}
                    },
                    sortable: ['loan_no', 'first_name', 'last_name', 'email', 'created_at'],
                    filterable: ['loan_no', 'first_name', 'last_name', 'email'],
                    groupBy :'group_date',
                },
            }
        },
        created() {
            this.$bus.$on('reloadTables', this.reload);
            this.getList();
            console.log(this.rulesActions);
        },
        methods: {
            reload: function(e) {
                switch (e) {
                    case 1 :
                        this.$refs.appQueue.refresh();
                        break;
                    case 2 :
                        this.$refs.appPending.refresh();
                        break;
                    case 3 :

                        break;
                    case 4 :
                    case 5 :

                        break;
                    case 5 :

                        break;
                    default :
                }
                // this.$refs.app_pending.getList();
            },
            getList: function(stats) {
                console.log(stats);
                this.columns.default = ['viewapp', 'loan_no' , 'portfolio', 'first_name', 'last_name', 'ssn', 'email', 'state'];

                switch (this.employee.designation.name) {
                    case 'Loan Agent' :

                        break;
                    default :
                        if( stats != 1 ) {
                            this.columns.default.push('originator_name', 'underwriter_name');
                        }

                        if( stats != 1 && stats != 2 ) {
                            this.columns.default.push( 'tribe_name');
                        }
                        break;
                }

                switch (stats) {
                    case 1 :
                        this.columns.queue = this.columns.default;
                        this.columns.queue.push('created_at', 'group_date');
                        break;
                    case 2 :
                        this.columns.pending = this.columns.default;
                        if(this.rulesActions.reassign_app) {
                            this.columns.pending.unshift('reassign');
                        }
                        this.columns.pending.push('created_at', 'group_date');
                        break;
                    case 3 :
                        this.columns.approved = this.columns.default;
                        this.columns.approved.push('created_at', 'group_date');
                        break;
                    case 4 :
                    case 6 :
                        this.columns.correction = this.columns.default;
                        this.columns.correction.push('created_at', 'group_date');
                        break;
                    case 5 :
                        this.columns.denied = this.columns.default;
                        this.columns.denied.push('created_at', 'group_date');
                        break;
                    default :
                }


            },
            viewApp: function(loan_no, rowid) {
                this.$router.push({ path : "/loanapproval/applications/view/"+rowid, query: { plan: 'private' }});
            },
            reassignApp: function(row) {
                console.log('reassign APP');
                this.rowModalSelect = row;
                this.reassignModal = true;
            },
            processVerificationRow: function(loan_no, rowid) {

                swal({
                    type: 'warning',
                    title: 'Loan ID : ' +  loan_no,
                    html:  "Are you sure you want to process this Loan?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Process'
                }).then((result) => {
                    if (result.value) {
                        // window.location.hash = '#application_form';
                        this.$router.push("/loanapproval/application/view/"+rowid);
                        // document.body.style.cursor='wait';
                        // let ld = Ladda.create(event.target);
                        // ld.start();
                        //
                        // this.$constants.LoanApp_API.put('/application/' + this.$route.params.id, jsonObject, {
                        //     validateStatus: function (status) {
                        //         return status >= 200 && status < 424; // default
                        //     },})
                        //     .then(response => {
                        //
                        //         let errors_lenght = (response.data.errors == null) ? 0 : Object.keys(response.data.errors).length;
                        //         console.log(errors_lenght);
                        //
                        //         if(errors_lenght >= 1) {
                        //             this.alertErrorList(response.data);
                        //         } else {
                        //             swal({
                        //                 type: 'success',
                        //                 title: '',
                        //                 html: response.data.message,
                        //             });
                        //         }
                        //
                        //     }).catch(e => {
                        //     console.log(e);
                        // });
                        // ld.stop();
                        // document.body.style.cursor='auto';

                    }
                });

            },

            DenyBtn(submitEvent) {


            },
            notesRow: function(notes) {
                this.notesProps.status = this.statusProps;
                this.notesProps.application_id = notes.id;
                this.notesProps.loan_id = notes.loan_no;
            },

            getApplicationForm: function(rowid) {
                this.tabActive.addClass("active");
                this.tabpaneActive.addClass("active");
                this.tabNotActive.removeClass("active");
                this.tabpaneNotActive.removeClass("active");
                this.$router.push("/loanapproval/application/view/"+rowid);
            }
        },
        mounted() {

            let app_list = this.$refs;

            if(this.rulesApplicationList.queue_app) {
                // app_list.app_queue.getList();
            }

            $('.nav-tabs').stickyTabs();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href"); // activated tab
                switch (target) {
                    case '#tab-queue' :
                        console.log('get list tab queue');
                        // app_list.app_queue.getList();
                        break;
                    case '#tab-pending' :
                        console.log('get list tab pending');
                        // app_list.app_pending.getList();
                        break;
                    case '#tab-approved' :
                        console.log('get list tab approved');
                        // app_list.app_approved.getList();
                        break;
                    case '#tab-correction' :
                        console.log('get list tab correction');
                        // app_list.app_correction.getList();
                        break;
                    case '#tab-disapproved' :
                        console.log('get list tab deny');
                        // app_list.app_deny.getList();
                        break;
                }

            });
        },
    }

</script>
<template>
    <div class="panel-body">

        <!--queue-->
        <div v-if="statusProps == 1">

            <v-server-table url="/api/loanapproval/application/status/1" ref="list_queue" @load="getList(1)" :name="'queue'" :columns="columns" :options="options">
                <button  slot="view" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                    <i class="fas fa-search ladda"></i> View
                </button>
            </v-server-table>

        </div>
        <!--pending-->
        <div v-else-if="statusProps == 2">

            <v-server-table url="/api/loanapproval/application/status/2" ref="list_pending"  @load="getList(2)" :name="'pending'" :columns="columns" :options="options">
                <button  slot="reassign" slot-scope="props" class='btn btn-primary btn-xs' @click="reassignApp(props.row)">
                    <i class="fas fa-hands-helping"></i> Reassign
                </button>
            </v-server-table>


            <modal v-if="reassignModal" @close="reassignModal=false" >
                <h3 slot="header"><i class="fas fa-hands-helping"></i> Reassign | Loan ID: <span class="text-danger">{{ this.rowModalSelect.loan_no }}</span></h3>
                <reassignApp slot="body" ref="assignApp" :object_row="rowModalSelect"></reassignApp>
                <button  slot="footer"  class='btn btn-primary ' @click="$refs.assignApp.assignApplication()">
                    <i class="fas fa-hands-helping"></i> Assign Application
                </button>
            </modal>

        </div>

        <!--approved-->
        <div v-else-if="statusProps == 3">
            <!--<v-client-table :data="rows" :columns="columns" :options="options"/>-->
            <v-server-table url="/api/loanapproval/application/status/3" ref="refs" :name="'approved'" :columns="columns" :options="options">

                <!--<button  slot="processVerification" slot-scope="props" class='btn btn-primary btn-xs' @click="processVerificationRow(props.row.loan_no, props.row.id)">-->
                    <!--<i class="fas fa-cogs ladda"></i> {{ labels.processVerification }}-->
                <!--</button>-->

                <button  slot="view" slot-scope="props" class='btn btn-primary btn-xs' @click="reassignApp(props.row.loan_no, props.row.id)">
                    <i class="fas fa-search ladda"></i> View
                </button>

            </v-server-table>
        </div>

        <!--correction-->
        <div v-else-if="statusProps == 4">
            <v-server-table url="/api/loanapproval/application/status/4" ref="refs" :columns="columns" :options="options">

                <button  slot="processVerification" slot-scope="props" class='btn btn-primary btn-xs' @click="processVerificationRow(props.row.loan_no, props.row.id)">
                    <i class="fas fa-cogs ladda"></i> {{ labels.processVerification }}
                </button>

                <button  slot="view" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                    <i class="fas fa-search ladda"></i> View
                </button>

            </v-server-table>

        </div>

        <!--disapproved-->
        <div v-else-if="statusProps == 5">
            <!--<v-client-table :data="rows" :columns="columns" :options="options">-->
                <!--<button slot="notes" slot-scope="props" class='ladda-button btn btn-primary btn-xs' @click="notesRow(props.row), notesModal = true"><i class="fa fa-comments"></i> {{ labels.notes }}</button>-->
                <!--<button slot="modify" slot-scope="props" class='ladda-button btn btn-primary btn-xs' @click="getApplicationForm(props.row.id)"><i class="fa fa-gear"></i> {{ labels.modify }}</button>-->
            <!--</v-client-table>-->
            <v-server-table url="/api/loanapproval/application/status/5" ref="refs" :name="'deny'" :columns="columns" :options="options">

                <button  slot="processVerification" slot-scope="props" class='btn btn-primary btn-xs' @click="processVerificationRow(props.row.loan_no, props.row.id)">
                    <i class="fas fa-cogs ladda"></i> {{ labels.processVerification }}
                </button>

                <button  slot="view" slot-scope="props" class='btn btn-primary btn-xs' @click="viewApp(props.row.loan_no, props.row.id)">
                    <i class="fas fa-search ladda"></i> View
                </button>

            </v-server-table>
        </div>

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
    import notesApplication from '../../components/loanapproval/components/notes.vue'
    import reassignApp from '../../components/loanapproval/components/reassign.vue'
    import loanApproval from '../../mixins/loanApprovalMixins'

    export default {
        mixins : [loanApproval],
        components: { notesApplication, reassignApp},
        props: {
            statusProps: Number,
            labels: {
                type: Object,
                default () {
                    return {
                        rules : {
                            processVerificationbtn : false,
                        },
                        processVerification: 'Process Verification',
                        view : 'viewapp',
                        notes: 'Notes',
                        pendingverify: 'Verify',
                        notes: 'Notes',
                        modify: 'Modify',
                    }
                }
            },
        },
        data() {
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
                columns: [],
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
            this.options.params.portfolios = this.portfolios;
            this.$bus.$on('reloadTables', this.reloadApp);
        },
        mounted() {

            $( ".tabs-container ul li" ).first().addClass('active');
            $( ".tabs-container .tab-pane" ).first().addClass('active');
        },
        methods: {
            reloadApp: function(e) {
                console.log(e);

                if(e  == '2') {
                    console.log('123');

                    return;
                }

            },
            getList: function(status) {
                this.columns = ['loan_no' , 'portfolio', 'first_name', 'last_name', 'ssn', 'email', 'state'];
                switch (this.employee.designation.name) {
                    case 'Loan Agent' :

                        break;
                    default :
                        if( status != 1 ) {
                            this.columns.push('originator_name', 'underwriter_name');
                        }

                        if( status != 1 && status != 2 ) {
                            this.columns.push( 'tribe_name');
                        }
                        break;
                }

                switch (status) {
                    case 1 :
                        this.columns.unshift('view');
                        break;
                    case 2 :
                        this.columns.unshift('reassign');
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

                this.columns.push('created_at', 'group_date');
                // if( this.statusProps == 1 ) {
                //
                //
                // }  else if( this.statusProps == 2 ){
                //
                //
                // } else if( this.statusProps == 4 || this.statusProps == 5 ){
                //
                //     // this.columns = ['notes', 'modify', 'loan_no', 'portfolio', 'first_name', 'last_name', 'email', 'ssn', 'state', 'request_code', 'ending_balance', 'new_or_returning', 'voe', 'created_at'];
                //     // this.headings = { notes : 'Notes', modify : '' };
                //
                // } else {
                //     // this.columns = ['loan_no', 'portfolio', 'first_name', 'last_name', 'email', 'ssn', 'state', 'request_code', 'ending_balance', 'new_or_returning', 'voe', 'created_at'];
                //     // this.headings = {};
                // }

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
                        //         return status >= 200 && status < 424; // default                         33                        //     },})
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
        }
    }
</script>
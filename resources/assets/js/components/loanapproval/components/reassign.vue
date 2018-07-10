<template>
    <div class="list">
        <p>* Please select below available underwriter to reassign the Application and Click Assign Button</p>

        <div class="form-group">
            <label class="col-sm-2 control-label">Underwriter</label>
            <div class="col-sm-10">
                <vSelect name="underwriter"
                        v-model="underwriters_select"
                        :options="underwriters"
                        label="full_name">
                </vSelect>
                <span v-show="underwriters_error" class="help is-danger">
                    Please Select Underwriter Name from the dropdown choices
                   </span>
            </div>
            <div class="clearfix"/>
        </div>


            <!--<div class="feed-element" v-for="(note, key) in notes" v-bind:key="note.id">-->
                <!--<div class="media-body">-->
                    <!--<small class="pull-right" >{{ datediff[key].original }}</small>-->
                    <!---->
                                        <!--<strong>{{ note.created_by }}</strong> -->
                    <!--posted a notes in <span class="text-info">{{ note.status == 4 ? 'Correction': 'Disapproved' }}</span> status<br>-->
                    <!--<small class="text-muted">{{ note.created_at }}</small>-->
                    <!--<div class="well">-->
                        <!--{{ note.notes }}                   -->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="panel panel-info">-->
                <!--<div class="panel-heading">-->
                    <!--<i class="fa fa-info-circle"></i> Post Notes-->
                <!--</div>-->
                <!--<div class="panel-body">-->
                    <!--<form id="fnotes" name="fnotes">-->
                        <!--<textarea name="notestext" id="notestext" v-model="form.notes" rows="3" class="form-control" data-validation="required"></textarea>-->
                        <!--<div class="clearfix"></div>-->
                     <!--</form>-->
                <!--</div>-->
            <!--</div>-->
            <!--<button data-style="slide-right" id="submitnote" @click="submitNotes" type="submit" class="ladda-button btn btn-primary pull-right">Submit Note</button>-->
    </div>
</template>
<script>
    export default {
         data() {
            return {
                underwriters_error : false,
                underwriters_select : '',
                underwriters : [],
            }
        },
        created() {
            this.fetchUnderwriters();
            // this.fetchNotes();
        },
        props :{
            object_row: Object,
        },
        mounted () {
             console.log(this.object_row);
           // / this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            fetchUnderwriters: function () {
                return this.$constants.LoanApp_API.get('/reassignapp/underwriters/')
                    .then(response => {
                        this.underwriters = response.data;
                    });
            },

            assignApplication : function () {
                console.log(this.underwriters_select);
                console.log('this assign application');
                if(this.underwriters_select == '') {
                    this.underwriters_error = true;
                    return;
                }
                swal({type: 'warning',
                    allowOutsideClick : false ,
                    confirmButtonText: 'Yes, Confirm',
                    showCancelButton: true,
                    html:  'Please confirm reassignment to : <strong>'+ this.underwriters_select.full_name + '</strong>'}).then((result) => {
                    if (result.value) {

                        this.$constants.LoanApp_API.patch('/reassignapp/underwriters/' + this.object_row.id + '/' + this.underwriters_select.id,{
                            validateStatus: function (status) {
                                return status >= 200 && status < 424; // default
                            },})
                            .then(response => {

                                if(typeof response.data.errors != 'undefined') {
                                    swal({
                                        type: 'error',
                                        title: 'Unable to Assign App',
                                        html:  response.data.msg,
                                    });
                                    return;
                                }
                                this.$bus.$emit('reloadTables', 2);
                                this.$parent.$emit('close');
                                // this.$refs.list_pending.getList(2);

                            }).catch(e => {
                            console.log(e);
                        });

                    }
                });


            },
            submitNotes() {                
                // this.laddabtn.start();
                // let form = this.form;
                //
                // this.$constants.LoanApp_API.get("/notes/create", {
                //     params: {
                //         loan_no : this.notesStatus.loan_id,
                //         status: this.notesStatus.status,
                //         application_id: this.notesStatus.application_id,
                //         notes: form.notes,
                //     }
                // })
                // .then(response => {
                //     this.department = response.data.message;
                //     this.form.notes = '';
                //     if (response.data.message) {
                //         swal('', response.data.message ,'success');
                //     } else {
                //         swal('', response.data.errors ,'error');
                //     }
                //     this.fetchNotes();
                // });
            }
        }

    }
</script>
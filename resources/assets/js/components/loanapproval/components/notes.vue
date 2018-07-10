<template>
    <div class="feed-activity-list">
            <div class="feed-element" v-for="(note, key) in notes" v-bind:key="note.id">
                <div class="media-body">
                    <small class="pull-right" >{{ datediff[key].original }}</small>
                    
                                        <strong>{{ note.created_by }}</strong> 
                    posted a notes in <span class="text-info">{{ note.status == 4 ? 'Correction': 'Disapproved' }}</span> status<br>
                    <small class="text-muted">{{ note.created_at }}</small>
                    <div class="well">
                        {{ note.notes }}                   
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-info-circle"></i> Post Notes
                </div>
                <div class="panel-body">
                    <form id="fnotes" name="fnotes">
                        <textarea name="notestext" id="notestext" v-model="form.notes" rows="3" class="form-control" data-validation="required"></textarea>
                        <div class="clearfix"></div>
                     </form>
                </div>
            </div>
            <button data-style="slide-right" id="submitnote" @click="submitNotes" type="submit" class="ladda-button btn btn-primary pull-right">Submit Note</button>
    </div>
</template>
<script>
    export default {
         data() {
            return {
                laddabtn : '',
                notes: [],
                form: {
                    notes: ''
                },
                datediff: [],
            }
        },
        created() {
            this.fetchNotes();
        },
        props :{
            notesStatus: Object,
        },
        mounted () {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            fetchNotes: function () {
                return this.$constants.LoanApp_API.get('/notes/status/' + this.notesStatus.status + '/' + this.notesStatus.loan_id)
                    .then(response => {
                        this.notes = response.data.notes;
                        this.datediff = response.data.diff;
                    });
            },
            submitNotes() {                
                this.laddabtn.start();
                let form = this.form;

                this.$constants.LoanApp_API.get("/notes/create", {
                    params: {
                        loan_no : this.notesStatus.loan_id,
                        status: this.notesStatus.status,
                        application_id: this.notesStatus.application_id,
                        notes: form.notes,
                    }
                })
                .then(response => {
                    this.department = response.data.message;
                    this.form.notes = '';
                    if (response.data.message) {
                        swal('', response.data.message ,'success');
                    } else {
                        swal('', response.data.errors ,'error');
                    }
                    this.fetchNotes();
                });
            }
        }

    }
</script>
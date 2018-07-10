<template>
    <ibox title="List of Schedules">
        <add-button @add="addEditRow()" textToAdd="Schedules"/>
        <div>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions" slot-scope="props">
                    <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                    <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">{{ headerName }}</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-edit :scheduleProps="sched_data" slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addEdit from '../../../components/tk/schedules/addEdit.vue'

    export default {

        components: { addEdit },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Schedule',
                        edit: 'Edit Schedule',
                        editBtn: 'Edit',
                        deleteBtn: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {             
                sched_data: {  
                    id: '',
                    user_id: '',
                    work_week: '',
                    sunday: '',
                    monday: '',
                    tuesday: '',
                    wednesday: '',
                    thursday: '',
                    friday: '',
                    saturday: '',
                    start_date: '',
                    end_date: '',
                },
                columns: ['actions', 'user_id', 'work_week', 'sunday','monday', 'tuesday', 'wednesday','thursday', 'friday','saturday','start_date','end_date'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        user_id: 'User ID',
                        work_week: 'Work Week',
                        sunday: 'Sunday',
                        monday: 'Monday',
                        tuesday: 'Tuesday',
                        wednesday: 'Wednesday',
                        thursday: 'Thursday',
                        friday: 'Friday',
                        saturday: 'Saturday',
                        start_date: 'Start Date',
                        end_date: 'End Date',
                    },
                    sortable: ['actions', 'user_id', 'work_week', 'sunday','monday', 'tuesday', 'wednesday','thursday', 'friday','saturday','start_date','end_date'],
                    filterable: ['actions', 'user_id', 'work_week', 'sunday','monday', 'tuesday', 'wednesday','thursday', 'friday','saturday','start_date','end_date']
                },
                headerName: '',
                openModal: false,
            };
        },
        mounted() {
            this.$emit("update", this.updatePagination);
        },
        created() {
            this.getList();
            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            getList: function () {
                this.$constants.TK_API.get("/schedules")
                    .then(response => {
                        this.rows = response.data;
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.sched_data.user_id = props_row.user_id;
                    this.sched_data.work_week = props_row.work_week_no;
                    this.sched_data.sunday = props_row.sunday;
                    this.sched_data.monday = props_row.monday;
                    this.sched_data.tuesday = props_row.tuesday;
                    this.sched_data.wednesday = props_row.wednesday;
                    this.sched_data.thursday = props_row.thursday;
                    this.sched_data.friday = props_row.friday;
                    this.sched_data.saturday = props_row.saturday;
                    this.sched_data.start_date = props_row.start_date;
                    this.sched_data.end_date = props_row.end_date;
                    this.sched_data.id = props_row.id;
                    
                } else {
                    this.headerName = this.labels.add;
                    this.sched_data.user_id = '';
                    this.sched_data.work_week = '';
                    this.sched_data.sunday = '';
                    this.sched_data.monday = '';
                    this.sched_data.tuesday = '';
                    this.sched_data.wednesday = '';
                    this.sched_data.thursday = '';
                    this.sched_data.friday = '';
                    this.sched_data.saturday = '';
                    this.sched_data.start_date = '';
                    this.sched_data.end_date = '';
                    this.sched_data.id = '';
                }
            },
             deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete ' + props_row.user_id + ' ?',
                    text: "Once deleted, you will not be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                })
                    .then((result) => {
                        if (result.value) {
                            this.$constants.TK_API.delete("/schedules/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                props_row.user_id + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                props_row.user_id + ' is safe!',
                                'error'
                            )
                        }
                    })
                
            },
        }         
    }
</script>
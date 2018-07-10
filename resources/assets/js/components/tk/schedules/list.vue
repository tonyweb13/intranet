<template>
        <ibox title="List of Schedules">
            <listheader>
                <button class='pull-left btn btn-primary' @click="addModal = true" v-text="labels.add"><i class="fa fa-plus"></i></button>
                <custom-search v-model="searchKey" />
            </listheader>
            <custom-table :columns='columnSchedules'>
                <tr v-for="(schedule, index) in filteredSchedules">
                    <td>
                        <button class='btn btn-primary btn-xs' @click="itemClicked(schedule), editModal = true" v-text="labels.edit"></button>
                        <button class='btn btn-danger btn-xs' @click="openDeleteSwal(schedule, index)" v-text="labels.delete"></button>
                    </td>
                    <td v-for="(val, key) in schedule" >
                        {{ val }}
                    </td>
                </tr>
            </custom-table>

            <custom-paginator :resource_url="pagination_url" @update="updatePagination"/>

            <modal v-if="addModal" :btnProps="hideBtn" @close="addModal = false">
                <h3 slot="header">Add schedule</h3>
               <add-schedule slot="body">
               </add-schedule>
            </modal>

            <modal v-if="editModal" :btnProps="hideBtn" @close="editModal = false">
                <h3 slot="header">Edit schedule</h3>
                <edit-schedule :scheduleProps="sched_data" slot="body">
                </edit-schedule>
            </modal>
     
        </ibox>
</template>
<script>
    "use strict"
    import axios from 'axios'
    import addSchedule from '../../../components/tk/schedules/add.vue'
    import editSchedule from '../../../components/tk/schedules/edit.vue'

    export default {

        components: { addSchedule, editSchedule },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Schedule',
                        edit: 'Edit',
                        delete: 'Delete'
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
                schedules: [],
                searchKey: '',
                addModal: false,
                editModal: false,
                hideBtn: true,
                pagination_url: "/api/tk/schedules",
            };
        }, 
        created() {
            this.fetchSchedules();
            this.$bus.$on('updateList', this.fetchSchedules);
            this.$bus.$on('init_modal', (param) => { this.addModal = param; this.editModal = param; });
        },
        methods: {
            fetchSchedules: function (){
                axios.get("/api/tk/schedules")
                    .then(response => {
                    this.schedules = response.data.data;
                });
            },
            itemClicked: function(schedule) {
                this.sched_data.id = schedule.id;
                this.sched_data.user_id = schedule.user_id;
                this.sched_data.work_week = schedule.work_week_no;
                this.sched_data.sunday = schedule.sunday;
                this.sched_data.monday = schedule.monday;
                this.sched_data.tuesday = schedule.tuesday;
                this.sched_data.wednesday = schedule.wednesday;
                this.sched_data.thursday = schedule.thursday;
                this.sched_data.friday = schedule.friday;
                this.sched_data.saturday = schedule.saturday;
                this.sched_data.start_date = schedule.start_date;
                this.sched_data.end_date = schedule.end_date;
            },
            openDeleteSwal: function (schedule, key) {
                swal({
                        title: 'Are you sure you want to delete ' +  schedule.user_id  + ' ?',
                        text: "Once deleted, you will not be able to revert this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.delete("/api/tk/schedules/"+schedule.id)
                        .then(response => {
                            this.schedule = response.data;
                            
                        });
                        swal(schedule.user_id + ' has been deleted!', {
                            icon: "success",
                        });
                        const idx = this.schedules.indexOf(schedule);
                        this.schedules.splice(idx, 1);

                    } else {
                        swal(schedule.user_id + ' is safe!');
                    }
                })
                
            },
            updatePagination(data){
                this.schedules = data
            }
        }         
    }
</script>
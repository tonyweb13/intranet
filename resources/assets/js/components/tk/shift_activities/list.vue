<template>
        <ibox title="List of Shifts Activities">
            <listheader>
                <button class='pull-left btn btn-primary' @click="addModal = true" v-text="labels.add"><i class="fa fa-plus"></i></button>
                <custom-search v-model="searchKey" />
            </listheader>
            <custom-table :columns='columnActivities'>
                <tr v-for="(activity, index) in filteredActivities">
                    <td>
                        <button class='btn btn-primary btn-xs' @click="itemClicked(activity), editModal = true" v-text="labels.edit"></button>
                        <button class='btn btn-danger btn-xs' @click="openDeleteSwal(activity, index)" v-text="labels.delete"></button>
                    </td>
                    <td v-for="(val, key) in activity" >
                        {{ val }}
                    </td>
                </tr>
            </custom-table>    

            <custom-paginator :resource_url="pagination_url" @update="updatePagination"/>       

            <modal v-if="addModal" @close="addModal = false">
                <h3 slot="header">Add Shifts Activities</h3>
               <add-activity slot="body">
               </add-activity>
            </modal>

            <modal v-if="editModal" @close="editModal = false">
                <h3 slot="header">Edit Shifts Activities</h3>
                <edit-activity :activityProps="activity_data" slot="body">
                </edit-activity>
            </modal>        
     
        </ibox>
</template>
<script>
    "use strict"
    import axios from 'axios'
    import addActivity from '../../../components/tk/shift_activities/add.vue'
    import editActivity from '../../../components/tk/shift_activities/edit.vue'

    export default {
        components: { addActivity, editActivity },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Shifts Activities',
                        edit: 'Edit',
                        delete: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {             
                activity_data: {  
                    name: '',
                    class: '',
                    label_name: '',
                    icon: '',
                    description: '',
                    id: ''               
                },
                activities: [],
                addModal: false,
                editModal: false,
                searchKey: '',
                pagination_url: "/api/tk/shiftactivities",
            };
        }, 
        created() {            
            axios.get("/api/tk/shiftactivities")
                .then(response => {                  
                    this.activities = response.data.data;                    
                });
        },
        methods: {
            itemClicked: function(activity) {
                this.activity_data.name = activity.name;
                this.activity_data.class = activity.class;
                this.activity_data.label_name = activity.label_name;
                this.activity_data.icon = activity.icon;
                this.activity_data.description = activity.description;
                this.activity_data.id = activity.id;
                
            },
            openDeleteSwal: function (activity, key) {
                swal({
                        title: 'Are you sure you want to delete ' +  activity.name  + ' ?',
                        text: "Once deleted, you will not be able to revert this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.delete("/api/tk/shiftactivities/"+activity.id)
                        .then(response => {
                            this.activity = response.data;
                            
                        });
                        swal(activity.name + ' has been deleted!', {
                            icon: "success",
                        });
                        this.activities.splice(key, 1);
                        this.$router.push('/tk/shiftactivities');

                    } else {
                        swal(activity.name + ' is safe!');
                    }
                })
                
            },
            updatePagination(data){
                this.activities = data
            }
        }         
    }
</script>
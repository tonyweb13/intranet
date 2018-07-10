<template>
        <ibox title="List of Shifts">
            <listheader>
                <button class='pull-left btn btn-primary' @click="addModal = true" v-text="labels.add"><i class="fa fa-plus"></i></button>
                <custom-search v-model="searchKey" />
            </listheader>
            <custom-table :columns='columnShifts'>
                <tr v-for="(shift, index) in filteredShifts">
                    <td>
                        <button class='btn btn-primary btn-xs' @click="itemClicked(shift), editModal = true" v-text="labels.edit"></button>
                        <button class='btn btn-danger btn-xs' @click="openDeleteSwal(shift, index)" v-text="labels.delete"></button>
                    </td>
                    <td v-for="(val, key) in shift" >
                        {{ val }}
                    </td>
                </tr>
            </custom-table>    

            <custom-paginator :resource_url="pagination_url" @update="updatePagination"/>       

            <modal v-if="addModal" @close="addModal = false">
                <h3 slot="header">Add shift</h3>
               <add-shift slot="body">
               </add-shift>
            </modal>

            <modal v-if="editModal" @close="editModal = false">
                <h3 slot="header">Edit shift</h3>
                <edit-shift :shiftProps="shift_data" slot="body">
                </edit-shift>
            </modal>        
     
        </ibox>
</template>
<script>
    "use strict"
    import axios from 'axios'
    import addShift from '../../../components/tk/shift/add.vue'
    import editShift from '../../../components/tk/shift/edit.vue'

    export default {
        components: { addShift, editShift },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add shift',
                        edit: 'Edit',
                        delete: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {             
                shift_data: {  
                    name: '',
                    desc: '',
                    start: '',
                    end: '',
                    is_enable: '',
                    id: ''               
                },
                shifts: [],
                addModal: false,
                editModal: false,
                searchKey: '',
                pagination_url: "/api/tk/shift",
            };
        }, 
        created() {            
            axios.get("/api/tk/shift")
                .then(response => {                  
                    this.shifts = response.data.data;                    
                });
        },
        methods: {
            itemClicked: function(shift) {
                this.shift_data.name = shift.name;
                this.shift_data.desc = shift.description;
                this.shift_data.end = shift.end;
                this.shift_data.start = shift.start;
                this.shift_data.is_enable = shift.is_enable;
                this.shift_data.id = shift.id;
                
            },
            openDeleteSwal: function (shift, key) {
                swal({
                        title: 'Are you sure you want to delete ' +  shift.name  + ' ?',
                        text: "Once deleted, you will not be able to revert this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.delete("/api/tk/shift/"+shift.id)
                        .then(response => {
                            this.shift = response.data;
                            
                        });
                        swal(shift.name + ' has been deleted!', {
                            icon: "success",
                        });
                        this.shifts.splice(key, 1);
                        this.$router.push('/tk/shift');

                    } else {
                        swal(shift.name + ' is safe!');
                    }
                })
                
            },
            updatePagination(data){
                this.shifts = data
            }
        }         
    }
</script>
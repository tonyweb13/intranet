<template>
    <ibox title="List of Employee">
            <listheader>
                <button class='pull-left btn btn-primary' @click="addModal = true" v-text="labels.add"><i class="fa fa-plus"></i></button>
                <custom-search v-model="searchKey" />
            </listheader>
            <custom-table :columns='columnEmployees'>
                <tr v-for="(employee, index) in filteredEmployees">
                    <td>
                        <button class='btn btn-primary btn-xs' @click="itemClicked(employee), editModal = true" v-text="labels.edit"></button>
                        <button class='btn btn-danger btn-xs' @click="openDeleteSwal(employee)" v-text="labels.delete"></button>
                    </td>
                    <td>                        
                        {{ employee.id }}                        
                    </td>
                     <td>                        
                        {{ employee.employee_no }}                        
                    </td>
                     <td>                        
                        {{ employee.username }}                        
                    </td>
                     <td>                        
                        *********
                    </td>
                     <td>                        
                        {{ employee.first_name }}                        
                    </td>
                     <td>                        
                        {{ employee.last_name }}                        
                    </td>
                     <td>                        
                        {{ employee.email_address }}                        
                    </td>
                </tr>
            </custom-table>           

            <custom-paginator :resource_url="pagination_url" @update="updatePagination"/>

            <modal v-if="addModal" :btnProps="addBtn"  @close="addModal = false">
                <h3 slot="header">Add Employee</h3>
               <add-employee slot="body" @event="handler">
               </add-employee>
            </modal>

            <modal v-if="editModal" :btnProps="cncelBtn" @close="editModal = false">
                <h3 slot="header">Edit Employee</h3>
                <edit-employee :employeeProps="user_employee" @event="cncel" slot="body">
                </edit-employee>
            </modal>        
     
        </ibox>
</template>
<script>
    "use strict"
    import axios from 'axios'
    import addEmployee from '../../../components/settings/user/add.vue'
    import editEmployee from '../../../components/settings/user/edit.vue'

    export default {
        components: { addEmployee, editEmployee },
        props: 
        {
            labels: {
                type: Object,
                default () {
                    return {
                        add: 'Add Employee',
                        edit: 'Edit',
                        delete: 'Delete'
                    }
                }
            },
            
        },
        data: function () {
            return {             
                user_employee: {  
                    emp_no: '',
                    username: '',
                    email: '',
                    fname: '',
                    lname: '',
                    id: ''
                },
                employees: [],
                searchKey: '',
                addModal: false,
                editModal: false,
                addBtn : true,
                cncelBtn: true,
                pagination_url: "/api/settings/employee",
            };
        }, 
        created() {
            this.fetchUsers(); 
        },
        methods: {
            fetchUsers: function () {
                axios.get("/api/settings/employee")
                .then(response => {                  
                    this.employees = response.data.data;                    
                });
            },
            handler (params) {
                this.addModal = params;
            },
            cncel (params) {
                this.editModal = params;
            },
            itemClicked: function(employee) {
                this.user_employee.id = employee.id;
                this.user_employee.emp_no = employee.employee_no;
                this.user_employee.username = employee.username;
                this.user_employee.email = employee.email_address;
                this.user_employee.fname = employee.first_name;
                this.user_employee.lname = employee.last_name;
            },
            openDeleteSwal: function (employee, key) {
                swal({
                        title: 'Are you sure you want to delete ' +  employee.first_name  + ' ?',
                        text: "Once deleted, you will not be able to revert this!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.delete("/api/settings/employee/"+employee.id)
                        .then(response => {
                            this.employee = response.data;
                            
                        });
                        swal(employee.first_name + ' has been deleted!', {
                            icon: "success",
                        });
                        const idx = this.employees.indexOf(employee);
                        this.employees.splice(idx, 1);
                        this.$router.push('/settings/employee');

                    } else {
                        swal(employee.first_name + ' is safe!');
                    }
                })
                
            },
            updatePagination(data){
                this.employees = data
            }
        }         
    }
</script>
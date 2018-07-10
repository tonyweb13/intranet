<template>
    <ibox title="List of Employee">
            <add-button @add="add()" textToAdd="Employee"/>

            <div>
                <v-client-table :data="rows" :columns="columns" :options="options">
                    <template slot="actions" slot-scope="props">                      
                        <button class='btn btn-primary btn-xs'><i class="fa fa-pencil"></i>
                            <router-link :to="{name: 'employee-edit', params: {employee_id: props.row.id }}" class="router_link_edit">Edit</router-link>
                        </button>
                        <button class='btn btn-danger btn-xs' @click="openDeleteSwal(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                        <button class='btn btn-info btn-xs' @click="changePass(props.row)"><i class="fa fa-gears"></i> {{ labels.changePass }}</button>
                    </template>
                    <template slot="passw" slot-scope="props">
                        ******
                    </template>
                </v-client-table>
            </div>

            <modal v-if="addModal" :btnProps="addBtn"  @close="addModal = false">
                <h3 slot="header">Add Employee</h3>
                <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
               <add-employee slot="body" @event="handler">
               </add-employee>
            </modal>

            <modal v-if="changeModal" @close="changeModal = false">
                <h3 slot="header">Change Password</h3>
                <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
               <change-pass :changePassProps="user_employee" slot="body" @event="handler"/>
            </modal>
     
        </ibox>
</template>
<script>
    import addEmployee from '../../../components/settings/user/add.vue'
    import editEmployee from '../../../components/settings/user/edit.vue'
    import changePass from '../../../components/settings/user/changePass.vue'

    export default {
        components: { addEmployee, editEmployee, changePass },
         props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            add: 'Add Employee',
                            edit: 'Edit Employee',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete',
                            changePass: 'Reset Password'
                        }
                    }
                },

            },
        data: function () {
            return {
                user_employee: {  
                    employee_no: '',
                    username: '',
                    email: '',
                    fname: '',
                    lname: '',
                    id: ''
                },
                columns: ['actions', 'employee_no', 'username', 'first_name', 'last_name', 'email_address'],
                rows: [],
                options: {
                    headings: {
                        actions: 'Actions',
                        employee_no: 'Employee ID',
                        username: 'Username',
                        first_name: 'First Name',
                        last_name: 'Last Name',
                        email_address: 'Email Address'
                    },
                    sortable: ['employee_no', 'first_name', 'last_name', 'email_address'],
                    filterable: ['employee_no','first_name', 'last_name', 'email_address']
                },
                addModal: false,
                changeModal: false,
                addBtn : true,
                cncelBtn: true,
            };
        }, 
        created() {
            this.getList();
            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.addModal = param;
                this.changeModal = param;
            });
        },
        methods: {
            getList: function () {
                this.$constants.Settings_API.get("/employee")
                .then(response => {                  
                    this.rows = response.data;                    
                });
            },
            handler (params) {
                this.addModal = params;
            },
            add() {
                this.addModal = true;
            },
            changePass(props_row) {
                this.changeModal = true;
                this.user_employee.username = props_row.username;
                this.user_employee.employee_no = props_row.employee_no;
            },
            itemClicked: function(employee) {
                this.user_employee.id = employee.id;
                this.user_employee.employee_no = employee.employee_no;
                this.user_employee.username = employee.username;
                this.user_employee.email = employee.email_address;
                this.user_employee.fname = employee.first_name;
                this.user_employee.lname = employee.last_name;
            },
            openDeleteSwal: function (employee) {
                swal({
                    title: 'Are you sure you want to delete ' + employee.first_name + ' ?',
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
                            this.$constants.Settings_API.delete("/employee/" + employee.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                employee.first_name + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                employee.first_name + ' is safe!',
                                'error'
                            )
                        }
                    })
                
            }
        }         
    }
</script>
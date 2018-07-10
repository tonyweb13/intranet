<template>
        <ibox title="Issue NTE">
            <div class="row">
                <div class="col-lg-3">
                    <form @submit.prevent="createNTE">
                        <form-group label="NTE Type">
                            <div class="asterisk_label">*</div>
                            <vSelect name="nte_type"
                                    v-model="nte.nte_type"
                                    :options="nteType"
                                    label="text"
                                    placeholder="NTE Type"
                            />
                            <div class="pull-right">
                                <i v-show="errors.has('nte_type')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('nte_type')" class="help is-danger">{{ errors.first('nte_type') }}</span>
                        </form-group>
                        <form-group label="Employee Id">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="employee_id" type="text" placeholder="Employee Id"
                                v-model="nte.employee_id" v-validate="'required|empIdExists|integer|min:8'" :class="{'input': true, 'is-danger': errors.has('employee_id') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('employee_id')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('employee_id')" class="help is-danger">{{ errors.first('employee_id') }}</span>
                        </form-group>
                        <form-group label="Date Issued">
                            <div class="asterisk_label">*</div>
                            <input class="form-control input-sm" name="date" type="date" placeholder="Date Issued"
                                v-model="nte.date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('date') }" >
                            <div class="pull-right">
                                <i v-show="errors.has('date')" class="input_warning_icon fa fa-warning"></i>
                            </div>
                            <span v-show="errors.has('date')" class="help is-danger">{{ errors.first('date') }}</span>
                        </form-group>
                        <save-button :disabled='!isComplete' />
                    </form>
                </div>
                <div class="col-lg-9">
                    <div>
                        <v-client-table :data="rows" :columns="columns" :options="options">
                            <template slot="actions" slot-scope="props">
                                <button class='btn btn-default btn-md' @click="handleEdit(props.row)"><i class="fa fa-pencil"></i> {{ labels.viewBtn }}</button>
                            </template>
                        </v-client-table>
                    </div>
                </div>
            </div>
        </ibox>
</template>
<script>
    export default {
        props:
            {
                labels: {
                    type: Object,
                    default() {
                        return {
                            viewBtn: 'View',
                        }
                    }
                },

            },
        data: function() {
            return {
                columns: ['actions', 'nte_type_name', 'employee_id', 'email', 'first_name', 'last_name', 'date', 'dep_name'],
                rows: [],                
                options: {
                    headings: {
                        actions: 'Operations',
                        nte_type: 'NTE Type',
                        employee_id: 'Employee Id',
                        email: 'Email Address',
                        first_name: 'First Name',
                        last_name: 'Last Name',
                        date: 'Date Issued',
                        department: 'Department',
                    },
                    sortable: ['nte_type', 'employee_id', 'email', 'first_name', 'last_name', 'date', 'department'],
                    filterable: ['nte_type', 'employee_id', 'email', 'first_name', 'last_name', 'date', 'department']
                },
                laddabtn : '', 
                nte: {
                    nte_type: '',
                    employee_id: '',
                    first_name: '',
                    last_name: '',
                    date: '',
                    email: '',
                    role: '',
                    department: ''
                },
                users: [],           
                nteType: [],
            }
        },
        computed: {
           isComplete () {
                return this.nte.nte_type && this.nte.employee_id && this.nte.date;
            }, 
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        created() {
            this.fetchNte();
            this.getNteFormList();
            this.getUsers();
            this.$bus.$on('updateList', this.fetchNte);
            this.$validator.extend('empIdExists', {
                getMessage: field => `Employee ID does not exists.`,
                    validate: value => {
                        var param = false;
                        let nte = this.nte;                     
                        this.users.forEach(function(element) {
                            if (element.employee_no == value) {
                                nte.first_name = element.first_name;
                                nte.last_name = element.last_name;
                                nte.email = element.email_address;
                                nte.role = element.designation_id;
                                nte.department = element.department_id;
                                param = true;
                            }
                        });
                        return param;
                    }
            });
        },
        methods: {
            resetForm() {
                 this.nte = {
                    nte_type: '',
                    employee_id: '',
                    first_name: '',
                    last_name: '',
                    date: '',
                    email: '',
                    role: '',
                    department: ''
                },
                this.$validator.reset();
            },
            getUsers: function () {
                this.$constants.Settings_API.get("/employee")
                    .then(response => {                  
                        this.users = response.data;                    
                    });
            },
            fetchNte: function() {
                this.$constants.HR_API.get('/nte')
                .then(response => {
                    return this.rows = response.data;
                });
            },
            getNteFormList: function () {
                this.$constants.HR_API.get('/nte/dropdown/nteform')
                .then(response => {
                    this.nteType = response.data;
                })
            },
            createNTE: function () {
                this.laddabtn.start();
                 this.$validator.validateAll().then((result) => {
                    if (result) {
                        let nte = this.nte;
                        this.$constants.HR_API.get("/nte/create", {
                            params: {
                                nte_type: nte.nte_type.value,
                                employee_id: nte.employee_id,
                                email: nte.email,
                                first_name: nte.first_name,
                                last_name: nte.last_name,
                                date: nte.date,
                                role: nte.role,
                                department: nte.department,
                            }
                        })
                        .then(response => {
                            this.laddabtn.stop();
                            this.nte = response.data;
                            swal({
                                title: 'Successfully Added!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                            this.resetForm();
                        });
                    } else {
                        this.laddabtn.stop();
                        return false;
                    }
                });
            },       
            handleEdit(row) {
                this.$router.push('/hr/nte/form/'+ row.id);
            }
        },        
    }
</script>
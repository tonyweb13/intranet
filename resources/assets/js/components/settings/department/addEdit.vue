<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="Name">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="name" type="text" placeholder="Name"
                   v-model="department.name" v-validate="'required|alpha'" :class="{'input': true, 'is-danger': errors.has('name') }" >
            <div class="pull-right">
                <i v-show="errors.has('name')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</span>
        </form-group>
        <form-group label="Description">
            <textarea class="form-control input-sm" name="description" placeholder="Description" v-model="department.description" />
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            departmentProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                department: {
                    name: '',
                    description: '',
                },
            };
        },
        created(){
            if(this.departmentProps.dept_id){
                this.department.name = this.departmentProps.dept_name;
                this.department.description = this.departmentProps.dept_description;
            } else {
                this.department.name = '';
                this.department.description = '';
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.department.name;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let department = this.department;
                        let getAxios = '';

                        if(this.departmentProps.dept_id){

                            getAxios = this.$constants.Settings_API.get("/department/"+this.departmentProps.dept_id, {
                                params: {
                                    name: department.name,
                                    description: department.description,
                                }
                            });

                        } else {

                            getAxios = this.$constants.Settings_API.get("/department/create", {
                                params: {
                                    name: department.name,
                                    description: department.description,
                                }
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.department = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });
                            this.$bus.$emit('updateList');
                        });
                    }
                });
            },
        },
    }
</script>
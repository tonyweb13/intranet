<template>
    <form v-on:submit.prevent="onSubmit">
        <p><strong class="text-red">Note :</strong> Providing password below fields will overide user existing password</p>
        <br/>
        <form-group label="New Password">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="password" type="password" placeholder="New Password"
                   v-model="employee.password" v-validate="'required|min:6'" :class="{'input': true, 'is-danger': errors.has('password') }" >
            <div class="pull-right">
                <i v-show="errors.has('password')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('password')" class="help is-danger">{{ errors.first('password') }}</span>
        </form-group>
        <form-group label="Confirm Password">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="confirm password" type="password" placeholder="Confirm Password"
                   v-model="employee.cpassword" v-validate="'confirmed:password'" :class="{'input': true, 'is-danger': errors.has('confirm password') }" >
            <div class="pull-right">
                <i v-show="errors.has('confirm password')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('confirm password')" class="help is-danger">{{ errors.first('confirm password') }}</span>
        </form-group>
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            changePassProps: Object,
        },
        data: function () {        
            return {
                employee: {
                    password: '',
                    cpassword: '',
                    username: '',
                },
                oldPassword:'',
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.employee.password && this.employee.cpassword;
            }
        },
        methods: {
            onSubmit: function () {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let employee = this.employee;
                        let getAxios = '';

                        getAxios = this.$constants.Settings_API.post("/employee/updatepassword", 
                            {   employee_no: this.changePassProps.employee_no, 
                                password: employee.password,
                                is_default_password: this.changePassProps.is_default_password
                            });

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);

                            this.employee = response.data;
                            swal({
                                text: 'Saved!',
                                type: "success",
                            });

                            this.$session.destroy();
                            this.$session.clear();
                            location.href = '/logout';

                            this.$bus.$emit('updateList');
                        });
                    }
                });
            },
            
        }
    }
</script>
<template>
    <el-form :model="model" status-icon label-width="200px" style="width:80%" class="demo-ruleForm" :rules="rules" ref="form">
        <el-form-item label="Employee No" prop="emp_no">
            <el-input type="number" v-model="model.emp_no"></el-input>
        </el-form-item>

        <el-form-item label="Username" prop="username">
           <el-input v-model="model.username"></el-input>
        </el-form-item>

        <el-form-item label="Password" prop="pass">
           <el-input id="pass" type="password" v-model="model.pass" auto-complete="off"></el-input>
        </el-form-item>
        
        <el-form-item label="Confirm Password" prop="checkPass">
           <el-input type="password" v-model="model.checkPass" auto-complete="off"></el-input>
        </el-form-item>

        <el-form-item label="Email Address" prop="email">
           <el-input v-model="model.email"></el-input>
        </el-form-item>
        
    </el-form>
</template>
<script>
    export default {
        data: function () {
            var validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password'));
                } else {
                    if (this.model.checkPass !== '') {
                        this.$refs.form.validateField('checkPass');
                    }
                    callback();
                }
            };
            var validatePass2 = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.model.pass) {
                    callback(new Error('Password don\'t match!'));
                } else {
                    callback();
                }
            };
            var checkEmp = (rule, value, callback) => {
                    if (!value) {
                        return callback(new Error('Employee ID is required.'));
                    }
                    setTimeout(() => {
                        if (value.toString().length < 8) {
                            callback(new Error('Employee ID must be 8 digits'));
                        } else {
                          this.users.forEach(function(element) {
                              if (element.employee_no == value) {
                                callback(new Error('Employee ID already exist.'));
                              }
                          });
                          callback();
                        }
                    }, 1000);
                };
            var checkEmail = (rule, value, callback) => {
                    if (!value) {
                        return callback(new Error('Email is required.'));
                    }
                    setTimeout(() => {                      
                        this.users.forEach(function(element) {
                            if (element.email_address == value) {
                            callback(new Error('Email address already exist.'));
                            }
                        });
                        callback();                     
                    }, 1000);
                };
            var checkUsername = (rule, value, callback) => {
                    if (!value) {
                        return callback(new Error('Username is required.'));
                    }
                    setTimeout(() => {                      
                        this.users.forEach(function(element) {
                            if (element.username == value) {
                            callback(new Error('Username already exist.'));
                            }
                        });
                        callback();                     
                    }, 1000);
                };
            return {
                model: {
                    emp_no: '',
                    username: '',
                    pass: '',
                    checkPass: '',
                    email: '',
                },
                users: [],
                rules: {
                    emp_no: [{
                        required: true,
                        validator: checkEmp,
                        trigger: 'blur'
                    }],
                    username: [{
                        required: true,
                        validator: checkUsername,
                        trigger: 'blur'
                    }],
                    pass: [{
                        required: true, validator: validatePass , trigger: 'blur' , 
                    }],
                    checkPass: [{
                         required: true, validator: validatePass2, trigger: 'blur', 
                    }],
                    email: [{
                        required: true,
                        validator: checkEmail,
                        trigger: 'blur'
                    },
                    {
                        type: 'email',
                        message: 'Invalid email',
                        trigger: 'change'
                    }],
                }
            }
        },
        created() {
            this.getList();
        },
        methods: {
            getList: function () {
                this.$constants.Settings_API.get("/employee")
                .then(response => {                  
                    this.users = response.data;                    
                });
            },
            validate() {
                return new Promise((resolve, reject) => {
                    this.$refs.form.validate((valid) => {
                    this.$emit('on-validate', valid, this.model)
                    resolve(valid);
                    });
                })
            }
       }
    }
</script>
   
<template>
    <el-form :model="model" status-icon label-width="200px" style="width:80%" class="demo-ruleForm" :rules="rules" ref="form">
        <el-form-item label="First Name" prop="fname">
            <el-input v-model="model.fname"></el-input>
        </el-form-item>

        <el-form-item label="Last Name" prop="lname">
           <el-input v-model="model.lname"></el-input>
        </el-form-item>

        <el-form-item label="Middle Name" prop="mname">
           <el-input v-model="model.mname"></el-input>
        </el-form-item>

        <el-form-item label="Birthday" prop="bday">
           <el-date-picker id="date1" v-model="model.bday" type="date" format="yyyy/MM/dd" value-format="yyyy-MM-dd" style="width: 100%;"></el-date-picker>
        </el-form-item>
        
    </el-form>
</template>
<script>
    export default {
        data: function () {
            return {
                model: {
                    fname: '',
                    lname: '',
                    mname: '',
                    bday: '',
                },
                rules: {
                    fname: [{
                        required: true,
                        message: 'First name is required.',
                        trigger: 'blur'
                    }],
                    lname: [{
                        required: true,
                        message: 'Last name is required',
                        trigger: 'blur'
                    }],
                    mname: [{
                        required: true,
                        message: 'Middle name is required',
                        trigger: 'blur'
                    }],
                    bday: [{
                        required: true,  message: 'Birthday is required.', trigger: 'change' 
                    }],          
                }
            }
        },
        methods: {
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
   
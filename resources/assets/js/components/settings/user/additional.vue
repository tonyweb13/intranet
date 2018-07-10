<template>
    <el-form :model="model" status-icon label-width="200px" style="width:80%" class="demo-ruleForm" :rules="rules" ref="form">

         <el-form-item label="School Name" prop="school">
           <el-input v-model="model.school"></el-input>
        </el-form-item>

        <el-form-item label="Year Graduated" prop="ygraduate">
           <el-date-picker type="date" id="date2" format="yyyy/MM/dd" value-format="yyyy-MM-dd" v-model="model.ygraduate" style="width: 100%;"></el-date-picker>
        </el-form-item>

         <el-form-item label="Bank Type" prop="banktype">
           <el-input v-model="model.banktype"></el-input>
        </el-form-item>

        <el-form-item label="Account Number" prop="accountno">
           <el-input type="number" v-model="model.accountno"></el-input>
        </el-form-item>
        
    </el-form>
</template>
<script>
    export default {
        data: function () {
            return {
                model: {
                    school: '',
                    ygraduate: '',
                    banktype: '',
                    accountno: '',
                },
                rules: {
                    banktype: [{
                        required: true,
                        message: 'Bank type is required',
                        trigger: 'blur'
                    }],
                    accountno: [{
                        required: true,
                        message: 'Account no required',
                        trigger: 'blur'
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
   
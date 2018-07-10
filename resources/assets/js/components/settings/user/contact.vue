<template>
    <el-form :model="model" status-icon label-width="200px" style="width:80%" class="demo-ruleForm" :rules="rules" ref="form">
        <el-form-item label="Mobile Number" prop="mnumber">
            <el-input type="number" v-model="model.mnumber"></el-input>
        </el-form-item>

       <el-form-item label="Person to contact" prop="emergency">
            <el-input v-model="model.emergency"></el-input>
        </el-form-item>

        <el-form-item label="Contact Number" prop="cnumber">
           <el-input type="number" v-model="model.cnumber"></el-input>
        </el-form-item>

        <el-form-item label="Relationship" prop="relationship">
           <el-input v-model="model.relationship"></el-input>
        </el-form-item>
        
    </el-form>
</template>
<script>
    export default {
        data: function () {
            return {
                model: {
                    mnumber: '',
                    emergency: '',
                    cnumber: '',
                    relationship: '',
                },
                rules: {
                    mnumber: [{
                        required: true,
                        message: 'Mobile number is required.',
                        trigger: 'blur'
                    }],
                    emergency: [{
                        required: true,
                        message: 'Emergency contact name is required.',
                        trigger: 'blur'
                    }],
                    cnumber: [{
                        required: true,
                        message: 'Contact number is required',
                        trigger: 'blur'
                    }],
                    relationship: [{
                        required: true,
                        message: 'Relationship is required',
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
   
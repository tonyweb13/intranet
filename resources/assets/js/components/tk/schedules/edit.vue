<template>
    <div class="row">
        <el-form ref="schedules" :model="schedule" size="medium" :rules="rules">
            <el-form-item label="User ID" class="col-lg-12" prop="user_id">
                <el-input v-model.number="schedule.user_id"></el-input>
            </el-form-item>
            <el-form-item label="Work week" class="col-lg-6" prop="work_week">
                <el-input v-model="schedule.work_week"></el-input>
            </el-form-item>
            <el-form-item label="Sunday" class="col-lg-6" prop="sunday">
                <el-input v-model.number="schedule.sunday"></el-input>
            </el-form-item>
            <el-form-item label="Monday" class="col-lg-6" prop="monday">
                <el-input v-model.number="schedule.monday"></el-input>
            </el-form-item>
            <el-form-item label="Tuesday" class="col-lg-6" prop="tuesday">
                <el-input v-model.number="schedule.tuesday"></el-input>
            </el-form-item>
            <el-form-item label="Wednesday" class="col-lg-6" prop="wednesday">
                <el-input v-model.number="schedule.wednesday"></el-input>
            </el-form-item>
            <el-form-item label="Thursday" class="col-lg-6" prop="thursday">
                <el-input v-model.number="schedule.thursday"></el-input>
            </el-form-item>
            <el-form-item label="Friday" class="col-lg-6" prop="friday">
                <el-input v-model.number="schedule.friday"></el-input>
            </el-form-item>
            <el-form-item label="Saturday" class="col-lg-6" prop="saturday">
                <el-input v-model.number="schedule.saturday"></el-input>
            </el-form-item>
            <el-form-item label="Start Date" class="col-lg-6" prop="start_date">
                <el-date-picker type="date" v-model="schedule.start_date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="End Date" class="col-lg-6" prop="end_date">
                <el-date-picker type="date" v-model="schedule.end_date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item class="col-lg-12">
                <el-button @click="closeModal('schedules')">Cancel</el-button>
                <el-button type="primary" class="ladda-button" data-color="mint" data-style="slide-right" @click="updateSchedule('schedules')">Update</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    "use strict"
    import axios from 'axios'

    export default {
        data: function () {
            var checkNumber = (rule, value, callback) => {                
                setTimeout(() => {
                if (!Number.isInteger(value)) {
                    callback(new Error('Please input digits'));
                } else {
                    callback();
                }
            }, 1000);
            };
            return {
                laddabtn : '',           
                schedule: {
                    user_id: this.scheduleProps.user_id,
                    work_week: this.scheduleProps.work_week,
                    sunday: this.scheduleProps.sunday,
                    monday: this.scheduleProps.monday,
                    tuesday: this.scheduleProps.tuesday,
                    wednesday: this.scheduleProps.wednesday,
                    thursday: this.scheduleProps.thursday,
                    friday: this.scheduleProps.friday,
                    saturday: this.scheduleProps.saturday,
                    start_date: this.scheduleProps.start_date,
                    end_date: this.scheduleProps.end_date,
                },
                 rules: {
                    user_id: [
                        { validator: checkNumber, required: true, message: 'Please input user id or must be number only', trigger: 'blur' },
                    ],
                    work_week: [
                        { required: true, message: 'Please input work wek', trigger: 'blur' },
                    ],
                    sunday: [
                        { validator: checkNumber, required: true, message: 'Please input sunday or must be number only', trigger: 'blur' },
                    ],
                    monday: [
                        { validator: checkNumber, required: true, message: 'Please input monday or must be number only', trigger: 'blur' },
                    ],
                    tuesday: [
                        { validator: checkNumber, required: true, message: 'Please input tuesday or must be number only', trigger: 'blur' },
                    ],
                    wednesday: [
                        { validator: checkNumber, required: true, message: 'Please input wednesday or must be number only', trigger: 'blur' },
                    ],
                    thursday: [
                        { validator: checkNumber, required: true, message: 'Please input thursday or must be number only', trigger: 'blur' },
                    ],
                    friday: [
                        { validator: checkNumber, required: true, message: 'Please input friday or must be number only', trigger: 'blur' },
                    ],
                    saturday: [
                        { validator: checkNumber, required: true, message: 'Please input saturday or must be number only', trigger: 'blur' },
                    ],
                    start_date: [
                        { required: true, message: 'Please pick a start date', trigger: 'change' }
                    ],
                    end_date: [
                        { required: true, message: 'Please pick a end date', trigger: 'change' }
                    ],
                }
               
            };
        },    
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        props: {
            scheduleProps: Object,
        },
        methods: {
            updateSchedule(formName) {
                this.laddabtn.start();
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let schedule = this.schedule;

                        return axios.get("/api/tk/schedules/"+this.scheduleProps.id, {
                                params: {
                                    user_id: schedule.user_id,
                                    work_week: schedule.work_week,
                                    sunday: schedule.sunday,
                                    monday: schedule.monday,
                                    tuesday: schedule.tuesday,
                                    wednesday: schedule.wednesday,
                                    thursday: schedule.thursday,
                                    friday: schedule.friday,
                                    saturday: schedule.saturday,
                                    start_date: schedule.start_date,
                                    end_date: schedule.end_date
                                }
                            }).then(response => {
                                this.laddabtn.stop();
                                this.$bus.$emit('init_modal', false);
                                swal({
                                    text: 'Updated!',
                                    icon: "success",
                                });
                                this.$bus.$emit('updateList');

                                return response.data;
                            });
                    } else {
                        this.laddabtn.stop();
                        return false;
                    }
                });
                
            },
            closeModal(formName) {
                this.$bus.$emit('init_modal', false);
             }
        },
    }
    
</script>
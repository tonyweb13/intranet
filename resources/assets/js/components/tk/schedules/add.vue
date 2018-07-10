<template>
    <div class="row">
        <el-form ref="schedules" :model="schedule" size="medium" :rules="rules">
            <el-form-item label="User ID" class="col-lg-12" prop="user_id">
                <el-input v-model="schedule.user_id"></el-input>
            </el-form-item>
            <el-form-item label="Work week" class="col-lg-6" prop="work_week">
                <el-input v-model="schedule.work_week"></el-input>
            </el-form-item>
            <el-form-item label="Sunday" class="col-lg-6" prop="sunday">
                <el-input v-model="schedule.sunday"></el-input>
            </el-form-item>
            <el-form-item label="Monday" class="col-lg-6" prop="monday">
                <el-input v-model="schedule.monday"></el-input>
            </el-form-item>
            <el-form-item label="Tuesday" class="col-lg-6" prop="tuesday">
                <el-input v-model="schedule.tuesday"></el-input>
            </el-form-item>
            <el-form-item label="Wednesday" class="col-lg-6" prop="wednesday">
                <el-input v-model="schedule.wednesday"></el-input>
            </el-form-item>
            <el-form-item label="Thursday" class="col-lg-6" prop="thursday">
                <el-input v-model="schedule.thursday"></el-input>
            </el-form-item>
            <el-form-item label="Friday" class="col-lg-6" prop="friday">
                <el-input v-model="schedule.friday"></el-input>
            </el-form-item>
            <el-form-item label="Saturday" class="col-lg-6" prop="saturday">
                <el-input v-model="schedule.saturday"></el-input>
            </el-form-item>
            <el-form-item label="Start Date" class="col-lg-6" prop="start_date">
                <el-date-picker type="date" v-model="schedule.start_date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="End Date" class="col-lg-6" prop="end_date">
                <el-date-picker type="date" v-model="schedule.end_date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item class="col-lg-12">
                <el-button @click="closeModal('schedules')">Cancel</el-button>
                <el-button type="primary" class="ladda-button" data-color="mint" data-style="slide-right" @click="createSchedule('schedules')">Create</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    "use strict"
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',    
                schedule: {
                    user_id: '',
                    work_week: '',
                    sunday: '',
                    monday: '',
                    tuesday: '',
                    wednesday: '',
                    thursday: '',
                    friday: '',
                    saturday: '',
                    start_date: '',
                    end_date: '',
                },
                rules: {
                    user_id: [
                        { required: true, message: 'Please input user id', trigger: 'blur' },
                    ],
                    work_week: [
                        { required: true, message: 'Please input work wek', trigger: 'blur' },
                    ],
                    sunday: [
                        { required: true, message: 'Please input sunday', trigger: 'blur' },
                    ],
                    monday: [
                        { required: true, message: 'Please input monday', trigger: 'blur' },
                    ],
                    tuesday: [
                        { required: true, message: 'Please input tuesday', trigger: 'blur' },
                    ],
                    wednesday: [
                        { required: true, message: 'Please input wednesday', trigger: 'blur' },
                    ],
                    thursday: [
                        { required: true, message: 'Please input thursday', trigger: 'blur' },
                    ],
                    friday: [
                        { required: true, message: 'Please input friday', trigger: 'blur' },
                    ],
                    saturday: [
                        { required: true, message: 'Please input saturday', trigger: 'blur' },
                    ],
                    start_date: [
                        { type: 'date', required: true, message: 'Please pick a start date', trigger: 'change' }
                    ],
                    end_date: [
                        { type: 'date', required: true, message: 'Please pick a end date', trigger: 'change' }
                    ],
                }
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            createSchedule(formName) {
                this.laddabtn.start();
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        let schedule = this.schedule;
                        axios.get("/api/tk/schedules/create", {
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
                        })
                        .then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            swal({
                                text: 'Created!',
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
            closeModal(formName){
                this.$bus.$emit('init_modal', false);
            }
        },
    }
</script>
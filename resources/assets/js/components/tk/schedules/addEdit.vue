<template>
    <form @submit.prevent="eventUpdate">
        <form-group label="User ID">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="user_id" type="text" placeholder="User ID"
                   v-model="schedule.user_id" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('user_id') }" >
            <div class="pull-right">
                <i v-show="errors.has('user_id')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('user_id')" class="help is-danger">{{ errors.first('user_id') }}</span>
        </form-group>
        <form-group label="Work Week">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="work_week" type="text" placeholder="Work Week"
                   v-model="schedule.work_week" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('work_week') }" >
            <div class="pull-right">
                <i v-show="errors.has('work_week')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('work_week')" class="help is-danger">{{ errors.first('work_week') }}</span>
        </form-group>
        <form-group label="Sunday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="sunday" type="text" placeholder="Sunday"
                   v-model="schedule.sunday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('sunday') }" >
            <div class="pull-right">
                <i v-show="errors.has('sunday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('sunday')" class="help is-danger">{{ errors.first('sunday') }}</span>
        </form-group>
        <form-group label="Monday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="monday" type="text" placeholder="Monday"
                   v-model="schedule.monday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('monday') }" >
            <div class="pull-right">
                <i v-show="errors.has('monday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('monday')" class="help is-danger">{{ errors.first('monday') }}</span>
        </form-group>
        <form-group label="Tuesday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="tuesday" type="text" placeholder="Tuesday"
                   v-model="schedule.tuesday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('tuesday') }" >
            <div class="pull-right">
                <i v-show="errors.has('tuesday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('tuesday')" class="help is-danger">{{ errors.first('tuesday') }}</span>
        </form-group>
        <form-group label="Wednesday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="wednesday" type="text" placeholder="Wednesday"
                   v-model="schedule.wednesday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('wednesday') }" >
            <div class="pull-right">
                <i v-show="errors.has('wednesday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('wednesday')" class="help is-danger">{{ errors.first('wednesday') }}</span>
        </form-group>
        <form-group label="Thursday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="thursday" type="text" placeholder="Thursday"
                   v-model="schedule.thursday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('thursday') }" >
            <div class="pull-right">
                <i v-show="errors.has('thursday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('thursday')" class="help is-danger">{{ errors.first('thursday') }}</span>
        </form-group>
         <form-group label="Friday">
             <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="friday" type="text" placeholder="Friday"
                   v-model="schedule.friday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('friday') }" >
            <div class="pull-right">
                <i v-show="errors.has('friday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('friday')" class="help is-danger">{{ errors.first('friday') }}</span>
        </form-group>
        <form-group label="Saturday">
            <div class="asterisk_label">*</div>
            <input class="form-control input-sm" name="saturday" type="text" placeholder="Saturday"
                   v-model="schedule.saturday" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('saturday') }" >
            <div class="pull-right">
                <i v-show="errors.has('saturday')" class="input_warning_icon fa fa-warning"></i>
            </div>
            <span v-show="errors.has('saturday')" class="help is-danger">{{ errors.first('saturday') }}</span>
        </form-group>
        <form-group label="Start Date">
            <div class="asterisk_label">*</div>
                <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control input-sm" name="start_date" type="text" placeholder="MM/DD/YYYY"
                        v-model="schedule.start_date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('start_date') }" >
                </div>
                <div class="pull-right">
                    <i v-show="errors.has('start_date')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('start_date')" class="help is-danger">{{ errors.first('start_date') }}</span>
        </form-group>
        <form-group label="End Date">
                <div class="asterisk_label">*</div>
                 <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input class="form-control input-sm" name="end_date" type="text" placeholder="MM/DD/YYYY"
                        v-model="schedule.end_date" v-validate="'required'" :class="{'input': true, 'is-danger': errors.has('end_date') }" >
                </div>
                <div class="pull-right">
                    <i v-show="errors.has('end_date')" class="input_warning_icon fa fa-warning"></i>
                </div>
                <span v-show="errors.has('end_date')" class="help is-danger">{{ errors.first('end_date') }}</span>
        </form-group>
        
        <save-button :disabled='!isComplete' />
    </form>
</template>
<script>
    export default {
        props: {
            scheduleProps: Object,
        },
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
            };
        },
        created(){
            if(this.scheduleProps.id){
                this.schedule.user_id = this.scheduleProps.user_id;
                this.schedule.work_week = this.scheduleProps.work_week;
                this.schedule.sunday = this.scheduleProps.sunday;
                this.schedule.monday = this.scheduleProps.monday;
                this.schedule.tuesday = this.scheduleProps.tuesday;
                this.schedule.wednesday = this.scheduleProps.wednesday;
                this.schedule.thursday = this.scheduleProps.thursday;
                this.schedule.friday = this.scheduleProps.friday;
                this.schedule.saturday = this.scheduleProps.saturday;
                this.schedule.start_date = this.scheduleProps.start_date;
                this.schedule.end_date = this.scheduleProps.end_date;
            } else {
                this.schedule.user_id = '',
                this.schedule.work_week =  '',
                this.schedule.sunday = '',
                this.schedule.monday = '',
                this.schedule.tuesday = '',
                this.schedule.wednesday = '',
                this.schedule.thursday = '',
                this.schedule.friday = '',
                this.schedule.saturday = '',
                this.schedule.start_date = '',
                this.schedule.end_date = ''
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        computed: {
            isComplete () {
                return this.schedule.user_id;
            }
        },
        methods: {
            eventUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.laddabtn.start();
                        let schedule = this.schedule;
                        let getAxios = '';

                        if(this.scheduleProps.id){

                            getAxios = this.$constants.TK_API.get("/schedules/"+this.scheduleProps.id, {
                                params: {
                                    user_id: schedule.user_id,
                                    work_week_no: schedule.work_week,
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
                            });

                        } else {

                            getAxios = this.$constants.TK_API.get("/schedules/create", {
                                params: {
                                    user_id: schedule.user_id,
                                    work_week_no: schedule.work_week,
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
                            });
                        }

                        getAxios.then(response => {
                            this.laddabtn.stop();
                            this.$bus.$emit('init_modal', false);
                            this.schedule = response.data;
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
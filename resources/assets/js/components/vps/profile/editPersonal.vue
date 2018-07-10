<template>
    <form @submit.prevent="updatePersonal">
        <label>Gender:</label>
        <div class="form-group">
            <vSelect label="text" v-model="personalProps.gender" :options="selectedGender" required/>
        </div>
        <custom-datepicker label="Birthday:" id="editBirthday" v-model="personalProps.birthday" required/>
        <label>Civil Status:</label>
        <div class="form-group">
            <vSelect label="text" v-model="personalProps.civil_status" :options="selectedCivilStatus" required />
        </div>
        <custom-number label="Mobile No:" v-model="personalProps.mobile_no" required/>
        <custom-text label="Email Address:" v-model="personalProps.email_address" required/>
        <custom-text label="Current Address:" v-model="personalProps.current_address" required/>
        <save-button/>
    </form>
</template>
<script>
    export default {
        props: {
            personalProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                selectedGender: [
                    { text: 'Male', value: 'Male'},
                    { text: 'Female', value: 'Female'},
                ],
                selectedCivilStatus:[
                    { text: 'Single', value: 'Single'},
                    { text: 'Married', value: 'Married'},
                    { text: 'Divorced', value: 'Divorced'},
                    { text: 'Separated', value: 'Separated'},
                    { text: 'Widowed', value: 'Widowed'},
                ],
            };
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            $("#editBirthday > div.form-group > div.input-group > input[type='text']").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            ).on(
                "changeDate", () => {
                    this.personalProps.birthday = $("#editBirthday > div.form-group > div.input-group > input[type='text']").val();
                }
            );
        },
        methods: {
            updatePersonal: function () {
                this.laddabtn.start();
                let employee = this.personalProps;
                this.$constants.Vps_API.get("/user_update/personal/"+employee.id, {
                    params: {
                        gender: employee.gender.text,
                        birthday: employee.birthday,
                        civil_status: employee.civil_status.text,
                        mobile_no: employee.mobile_no,
                        email_address: employee.email_address,
                        current_address: employee.current_address,
                    }
                }).then(response => {
                    this.laddabtn.stop();
                    this.$bus.$emit('init_modal', false);
                    if(response.data){
                        swal({
                            title:'Saved',
                            type: "success",
                            text: 'Please wait for HR Approval',
                        });
                    } else {
                        swal({
                            title: response.data.errors,
                            type: "error",
                        });
                    }
                });
            },
        },
    }
    
</script>
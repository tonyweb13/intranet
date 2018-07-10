<template>
    <form @submit.prevent="updateEmployment">
        <custom-datepicker label="Date Hired:" id="editHired" v-model="employmentProps.date_hired" required/>
        <custom-datepicker label="Regularization Date:" id="editRegularization" v-model="employmentProps.regularization_date" required/>
        <label>Employment Type:</label>
        <div class="form-group">
            <vSelect label="text" v-model="employmentProps.employment_type" :options="selectedEmploymentType" required/>
        </div>
        <save-button/>
    </form>
</template>
<script>
    export default {
        props: {
            employmentProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                selectedEmploymentType: [],
            };
        },
        created() {
            this.$constants.Settings_API.get("/employment_type/dropdown")
                .then(response => {
                    this.selectedEmploymentType = response.data;
                });
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));

            $("#editHired > div.form-group > div.input-group > input[type='text']").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            )
                .on(
                    "changeDate", () => {
                        this.employmentProps.date_hired = $("#editHired > div.form-group > div.input-group > input[type='text']").val();
                    }
                );

            $("#editRegularization > div.form-group > div.input-group > input[type='text']").datepicker(
                {
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }
            )
                .on(
                    "changeDate", () => {
                        this.employmentProps.regularization_date = $("#editRegularization > div.form-group > div.input-group > input[type='text']").val();
                    }
                );
        },
        methods: {
            updateEmployment: function () {
                this.laddabtn.start();
                let employee = this.employmentProps;
                this.$constants.Vps_API.get("/user_update/employment/"+employee.id, {
                    params: {
                        date_hired: employee.date_hired,
                        regularization_date: employee.regularization_date,
                        employment_type_id: employee.employment_type.value,
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
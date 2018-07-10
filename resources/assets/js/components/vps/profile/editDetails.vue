<template>
    <form @submit.prevent="updateDetails">
        <custom-text label="Person to contact in case of emergency:" v-model="detailsProps.person_to_contact_in_case_of_emergency" required/>
        <custom-text label="Relationship to contact person:" v-model="detailsProps.relationship" required/>
        <custom-text label="Contact person number:" v-model="detailsProps.contact_person_no" required/>
        <save-button/>
    </form>
</template>
<script>
    export default {
        props: {
            detailsProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
            };
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            updateDetails: function () {
                this.laddabtn.start();
                let employee = this.detailsProps;

                this.$constants.Vps_API.get("/user_update/details/"+employee.id, {
                    params: {
                        person_to_contact_in_case_of_emergency: employee.person_to_contact_in_case_of_emergency,
                        relationship: employee.relationship,
                        contact_person_no: employee.contact_person_no,
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
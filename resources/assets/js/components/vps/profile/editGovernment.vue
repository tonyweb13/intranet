<template>
    <form @submit.prevent="updateGovernment">
        <custom-number label="PhilHealth Number:" v-model="governmentProps.phil_health_number" required/>
        <custom-number label="Pag-ibig Number:" v-model="governmentProps.hmdf_number" required/>
        <custom-number label="SSS Number:" v-model="governmentProps.sss_number" required/>
        <custom-number label="TIN Number:" v-model="governmentProps.tin_number" required/>
        <save-button/>
    </form>
</template>
<script>
    export default {
        props: {
            governmentProps: Object,
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
            updateGovernment: function () {
                this.laddabtn.start();
                let employee = this.governmentProps;

                this.$constants.Vps_API.get("/user_update/government/"+employee.id, {
                    params: {
                        phil_health_number: employee.phil_health_number,
                        hmdf_number: employee.hmdf_number,
                        sss_number: employee.sss_number,
                        tin_number: employee.tin_number,
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
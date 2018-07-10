<template>
    <form @submit.prevent="updateEducational">
        <custom-text label="Course:" v-model="educationalProps.course" required/>
        <custom-text label="Educational Institution:" v-model="educationalProps.educational_institution" required/>
        <label>Year Graduated:</label>
        <div class="form-group">
            <vSelect label="text" v-model="educationalProps.year_graduated" :options="selectedYear" required/>
        </div>
        <save-button/>
    </form>
</template>
<script>
    export default {
        props: {
            educationalProps: Object,
        },
        data: function () {
            return {
                laddabtn : '',
                selectedYear: [
                    { text: '2018', value: '2018' },
                    { text: '2017', value: '2017' },
                    { text: '2016', value: '2016' },
                    { text: '2015', value: '2015' },
                    { text: '2014', value: '2014' },
                    { text: '2013', value: '2013' },
                    { text: '2012', value: '2012' },
                    { text: '2011', value: '2011' },
                    { text: '2010', value: '2010' },
                    { text: '2009', value: '2009' },
                    { text: '2008', value: '2008' },
                    { text: '2007', value: '2007' },
                    { text: '2006', value: '2006' },
                    { text: '2005', value: '2005' },
                    { text: '2004', value: '2004' },
                    { text: '2003', value: '2003' },
                    { text: '2002', value: '2002' },
                    { text: '2001', value: '2001' },
                    { text: '2000', value: '2000' },
                    { text: '1999', value: '1999' },
                    { text: '1998', value: '1998' },
                    { text: '1997', value: '1997' },
                    { text: '1996', value: '1996' },
                    { text: '1995', value: '1995' },
                    { text: '1994', value: '1994' },
                    { text: '1993', value: '1993' },
                    { text: '1992', value: '1992' },
                    { text: '1991', value: '1991' },
                    { text: '1990', value: '1990' },
                    { text: '1989', value: '1989' },
                    { text: '1988', value: '1988' },
                    { text: '1987', value: '1987' },
                    { text: '1986', value: '1986' },
                    { text: '1985', value: '1985' },
                    { text: '1984', value: '1984' },
                    { text: '1983', value: '1983' },
                    { text: '1982', value: '1982' },
                    { text: '1981', value: '1981' },
                ],
            };
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            updateEducational: function () {
                this.laddabtn.start();
                let employee = this.educationalProps;

                this.$constants.Vps_API.get("/user_update/educational/"+employee.id, {
                    params: {
                        course: employee.course,
                        educational_institution: employee.educational_institution,
                        year_graduated: employee.year_graduated.text,
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
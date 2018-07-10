<template>
    <form @submit="updateShift">
        <custom-text label="Name:" v-model="shift.name" required/>
        <custom-textarea label="Description:" v-model="shift.description"/>
        <custom-time label="Start:" v-model="shift.start" required/>
        <custom-time label="End:" v-model="shift.end" required/>
        <custom-select label="Status:" v-model="shift.is_enable" :options="radiosStatus" required/>
        <save-button/>
    </form>
</template>
<script>
    "use strict"
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',           
                shift: {
                    name: this.shiftProps.name,
                    description: this.shiftProps.desc,
                    start: this.shiftProps.start,
                    end: this.shiftProps.end,
                    is_enable: this.shiftProps.is_enable,
                },
                radiosStatus: [
                    { text: '', value: '', selected: 'selected' },
                    { text: 'Active', value: '1'},
                    { text: 'Inactive', value: '0'},
                ],
               
            };
        },    
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        props: {
            shiftProps: Object,
        },
        methods: {
            updateShift: function () {
                this.laddabtn.start();
                let shift = this.shift;

               return axios.get("/api/tk/shift/"+this.shiftProps.id, {
                    params: {
                        name: shift.name,
                        description: shift.description,
                        start: shift.start,
                        end: shift.end,
                        is_enable: shift.is_enable
                    }
                }).then(response => {
                    this.laddabtn.stop();
                    return response.data;
                });
            },
        },
    }
    
</script>
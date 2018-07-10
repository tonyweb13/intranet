<template>
    <form @submit='createShift'>
        <custom-text label="Name:" v-model="shift.name" required/>
        <custom-textarea label="Description:" v-model="shift.description"/>
        <custom-time label="Start:" v-model="shift.start" required/>
        <custom-time label="End:" v-model="shift.end" required/>
        <custom-select label="Status:" v-model="shift.is_enable" :options="radiosStatus" required/>
        <save-button />
    </form>
</template>
<script>
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',    
                shift: {},
                radiosStatus: [
                    { text: '', value: '', selected: 'selected' },
                    { text: 'Active', value: '1'},
                    { text: 'Inactive', value: '0'},
                ],
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            createShift () {
                this.laddabtn.start();
                let shift = this.shift;
                axios.get("/api/tk/shift/create", {
                    params: {
                        name: shift.name,
                        description: shift.description,
                        start: shift.start,
                        end: shift.end,
                        is_enable: shift.is_enable
                    }
                })
                .then(response => {
                    this.laddabtn.stop();
                    this.shift = response.data;
                    this.$router.push('/tk/shift');
                });
            }
        }
    }
</script>
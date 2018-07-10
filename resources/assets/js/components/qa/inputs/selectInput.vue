<template>
    <select class="form-control chosen" v-model="selected" @change="setMonthSession()" placeholder="Choose month . . .">
        <template v-for="option in selectOptions">
            <option :value="option.id">{{ option.name }}</option>
        </template>
    </select>
</template>
<script>
    'use strict';

    export default {
        name: 'selectInput',
        props: {
            options: {
                type: Array
            },
        },
        data() {
            return {
                selected: '',
            };
        },
        created() {
            this.getMonthSession();
        },
        computed: {
            selectOptions() {
                return this.options
            },
        },
        methods: {
            getMonthSession() {
                const current_date = new Date();
                this.$constants.QA_API.post('/session/get/month', {
                    month: ("0" + (current_date.getMonth() + 1)).slice(-2)
                }).then(response => {
                    this.$store.commit('session/setMonth', response.data);
                    this.selected = this.$store.getters['session/selectedMonth'];
                });
            },
            setMonthSession: function() {
                console.log(this.selected);
                this.$constants.QA_API.post('/session/set/month', {
                    month: this.selected
                }).then(response => {
                    this.$store.commit('session/setMonth', response.data);
                    this.selected = this.$store.getters['session/selectedMonth'];
                });
            }
        }
    }
</script>
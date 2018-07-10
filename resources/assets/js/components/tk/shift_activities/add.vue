<template>
    <form @submit='createActivity'>
        <custom-text label="Name:" v-model="activity.name" required/>
        <custom-textarea label="Description:" v-model="activity.description"/>
        <custom-text label="Class:" v-model="activity.class" required/>
        <custom-text label="Label Name:" v-model="activity.label_name" required/>
        <custom-text label="Icon:" v-model="activity.icon" required/>
        <save-button />
    </form>
</template>
<script>
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',    
                activity: {},
            }
        },
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        methods: {
            createActivity () {
                this.laddabtn.start();
                let activity = this.activity;
                axios.get("/api/tk/shiftactivities/create", {
                    params: {
                        name: activity.name,
                        class: activity.class,
                        label_name: activity.label_name,
                        icon: activity.icon,
                        description: activity.description
                    }
                })
                .then(response => {
                    this.laddabtn.stop();
                    this.activity = response.data;
                    this.$router.push('/tk/shiftactivities');
                });
            }
        }
    }
</script>
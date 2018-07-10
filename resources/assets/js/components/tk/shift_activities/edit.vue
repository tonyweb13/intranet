<template>
    <form @submit="updateActivity">
        <custom-text label="Name:" v-model="activity.name" required/>
        <custom-textarea label="Description:" v-model="activity.description"/>
        <custom-text label="Class:" v-model="activity.class" required/>
        <custom-text label="Label Name:" v-model="activity.label_name" required/>
        <custom-text label="Icon:" v-model="activity.icon" required/>
        <save-button />
    </form>
</template>
<script>
    "use strict"
    import axios from 'axios'

    export default {
        data: function () {
            return {
                laddabtn : '',           
                activity: {
                    name: this.activityProps.name,
                    description: this.activityProps.description,
                    class: this.activityProps.class,
                    label_name: this.activityProps.label_name,
                    icon: this.activityProps.icon,
                },
            };
        },    
        mounted() {
            this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },
        props: {
            activityProps: Object,
        },
        methods: {
            updateActivity: function () {
                this.laddabtn.start();
                let activity = this.activity;

               return axios.get("/api/tk/shiftactivities/"+this.activityProps.id, {
                    params: {
                        name: activity.name,
                        class: activity.class,
                        label_name: activity.label_name,
                        icon: activity.icon,
                        description: activity.description
                    }
                }).then(response => {
                    this.laddabtn.stop();
                    return response.data;
                });
            },
        },
    }
    
</script>
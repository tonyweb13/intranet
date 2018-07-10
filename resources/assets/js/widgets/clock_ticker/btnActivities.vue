<template>
<div class="actbtns">
    <ul>
        <li v-for="activities in btn_shift_activites">
            <button type="button" class="ladda-button btn btn-outline" v-bind:class="activities.class + ' btn_' + activities.name"  v-on:click="add_activity(activities.name)"><i class="fa" v-bind:class="activities.icon"></i> {{activities.label_name}}</button>
        </li>
    </ul>

</div>
</template>
<style scoped>
.actbtns {
    text-align: center;
    position: fixed;
    bottom: 40%;
    right: 10px;
    z-index: 99999999;
}
.actbtns  button {
    box-shadow: 2px 3px #eeeeee;
    min-width: 100px;
}
.actbtns ul li {
    list-style: none;
    margin: 5px 5px;
}
</style>

<script>
    import axios from 'axios';
    import {TK_API} from '../../constants';

    export default {
        data() {
            return {
                currentShiftId : 0,
                laddabtn : '',
                btn_shift_activites : [],
            }
        },
        mounted() {

        },

        methods: {
            add_activity : function(activity_name) {
                console.log(activity_name);
                let ld = Ladda.create(document.querySelector('.btn_'+activity_name));
                ld.start();
                this.$constants.TK_API.get('shiftactivity/create', {params : {'activity_name':activity_name }}).then(response => {
                            console.log(response.data);
                             ld.stop();
                }).catch(e => {
                        this.errors.push(e)
                })
               
                return;
            },

        },
        beforeMount() {
            this.$constants.TK_API.get('shiftactivitieslist')
                .then(response => {
                    console.log(response.data);
                    this.btn_shift_activites = response.data
                })
                .catch(e => {
                    this.errors.push(e)
                })
        },
        created() {

                    
            }

    }
</script>
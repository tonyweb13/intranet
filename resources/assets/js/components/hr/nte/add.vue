<template>
    <div>
        <div v-for="info in infos" v-bind:key="info.id" class="ibox-content p-xl">
            <hr-form :infoProps="infos">

            </hr-form>
        </div>
    </div>
</template>
<script>
    import hrForm from '../../../components/hr/nte/hrform.vue'

    export default {
        components: { hrForm },

        data: function () {
            return {
                infos: [],
            }
        },
        created (){
            this.getInfo();
        },
        methods: {
            getInfo: function () {
                this.$constants.HR_API.get('/nte/form/' + this.$route.params.nte_id)
                .then(response => {
                    this.infos = response.data;
                });
            }
            
        }
    }
    
</script>
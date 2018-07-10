<template>
    <div>

                <div class="profile-image">
                    <a @click="pictureModal = true">
                        <img :src="imageSrc" class="img-lg m-t-md" alt="profile">
                    </a>
                </div>
                <div class="profile-info">
                    <h1 class="no-margins">{{employee.first_name}} {{employee.last_name}}</h1>
                    <table class="table borderless m-t m-b">
                        <tr>
                            <td style="width: 100px;">Employee # :</td>
                            <td><h4>{{employee.employee_no}}</h4></td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">Department :</td>
                            <td><h4>{{employee.department.name}}</h4></td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">Designation :</td>
                            <td><h4>{{employee.designation.name}}</h4></td>
                        </tr>
                    </table>
                </div>

            <modal v-if="pictureModal" @close="pictureModal = false">
                    <h3 slot="header">Profile Picture</h3>
                    <profile-picture :imageProps="imageSrc" @event="handler" slot="body">
                    </profile-picture>
            </modal>
    <div class="clearfix m-sm"></div>
    </div>
</template>
<style>

</style>

<script>    
    import profilePicture from '../../../components/vps/profile/picture.vue'

    export default {
        components:{ profilePicture },
        data () {
            return {
                imageSrc: '',
                pictureModal: false,
            }
        },
        created(){
            this.$bus.$on('init_thumb', (param) => { 
                this.imageSrc = param; 
            });
            if(this.employee.profile_pic){
                // get profile pic via session or vps variable
                this.imageSrc = '/storage/profile/thumbnail/'+ this.employee.profile_pic
            } else {
                this.imageSrc = '/img/a4.jpg';
            }
        },
        methods: {
            handler (params) {
                this.pictureModal = params;
            },
        }
    }
</script>
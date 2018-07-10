<template>
    <div id="wrapper">
        <arbmenu/>
        <div id="page-wrapper" class="gray-bg dashbard-1" >
            <arbheader/>
            <div class="row wrapper border-bottom white-bg page-heading" >
                <div class="col-lg-10"> 
                    <h2>{{ pageTitle }}</h2>
                    <!--<h2>ARB Call Facilities</h2>-->
                    <!--<breadcrumbs/>-->
                    <!--<ol class="breadcrumb">-->
                        <!--<li>-->
                            <!--<a href="index.html">Home</a>-->
                        <!--</li>-->
                        <!--<li>-->
                            <!--<a>Forms</a>-->
                        <!--</li>-->
                        <!--<li class="active">-->
                            <!--<strong>Helper css classes</strong>-->
                        <!--</li>-->
                    <!--</ol>-->
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeIn" style="height:100%;">
                <loadingModal  v-if="$root.loading" />
                <router-view v-else></router-view>

                <modal v-if="changeModal">
                        <div slot="header">
                        <h3>Change Password</h3>
                        <i style="color:red">(You are using default system password, please change your password)</i>
                        </div>
                    <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
                    <change-pass :changePassProps="infos" slot="body"/>
                </modal>
            </div>
               <arbfooter/>
        </div>
    </div>
</template>
<script>
    import arbheader from './header.vue'
    import arbmenu from './menu.vue'
    import arbfooter from './footer.vue'
    import loadingModal from '../shared/modal/loadingModal.vue'
    import changePass from '../components/settings/user/changePass.vue'

    export default {
        components: { arbheader, arbmenu, arbfooter, loadingModal, changePass },
        data() {
            return {
                pageTitle: this.$store.state.PageHeaders.page_title,
                changeModal: false,
                infos: this.$session.get('user_session'),
            }
        },
        beforeCreate () {
            if (!this.$session.exists()) {
                this.$router.push('/login');
            }
        },
        created(){

            if (this.$session.exists()) {
                if(this.infos.is_default_password === 1){
                    this.changeModal = true;
                }
            }

            let self = this;
            let now = new Date();
            let nextHour = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours() + 12, 0, 0, 0);
            let difference = nextHour - now;

            setTimeout(function()
            {
                swal({
                    title: 'Login Expired!',
                    text: 'Required to login again',
                    type: 'error',
                });
    
                self.$session.destroy();
                self.$session.clear();
                location.href = '/logout';

            }, difference);
        },
    }
</script>
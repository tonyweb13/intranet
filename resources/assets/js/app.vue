<template>
    <div>
        <router-view
         :api-url="apiUrl"
         :secret="secret"
         @success="handleLogin"
         @failed="handleErrors">
        </router-view>
    </div>
</template>
<script>
 import login from './components/login.vue'

 export default {
     name: 'App',
     data () {
         return {
             apiUrl: this.$constants.API_URL,
             secret: this.$constants.PASSPORT_SECRET,
         }
     },
     mounted(){
         $('.nav-tabs').stickyTabs();
     },
     methods: {
         handleLogin () {
             this.$session.start();
             window.location.href = "/home";
             // this.$router.push('/');
         },
         handleErrors (errors) {
             this.$session.destroy();
             alert('Authorization error: ' + errors)
         },
     },
 }
</script>
<template >
    <body class="gray-bg">
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <h1 class="logo-name" style="line-height:.8; font-size:125px"> A R B</h1>
            <h3>QA-Report System</h3>
            <div class="m-t">
                <div class="form-group">
                    <input type="text" class="form-control full-width"  placeholder="Username" v-model="model.username" name="username" required />
                </div>

                <div class="form-group">
                    <input type="password" class="form-control full-width" placeholder="Password" v-model="model.password" name="password" required />
                </div>

                <div v-if="this.is_error" class="form-group">
                    <p class="text-danger" style="color:red"> {{ this.error_message }} </p>
                </div>

                <button class="btn btn-primary block full-width m-b" type="button" @click="onSubmit">Submit</button>
                <a href="#"><small>Forgot password?</small></a>
            </div>
        </div>

    </body>


</template>

<script>
'use strict';

import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

export default {
    name: 'login',
    data() {
        return {
            model: {
                username: '',
                password: ''
            },
            is_error: false,
            error_message: null,
        }
    },
    methods: {
        onSubmit() {

            axios.post('/login',this.model).then(response => {
                /*Todo: change the status code to 401   for
                 unauthorized when axios error handling is fixed*/
                if (response.data.status === 'success') {
                    /*Todo: try a different approace here to reload/load
                     dashboard after login and will overrid the redirect(_)
                     function of the RedirectAuthenticated middleware*/
                    this.$router.replace('/dashboard');
                    window.location.reload();
                } else {
                    this.is_error = true;
                    this.error_message = 'Invalid credentials.';
                }
            });
        }
    }
}
</script>
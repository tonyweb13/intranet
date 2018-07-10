<template>
    <div>
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <h6 class="logo-name" style="letter-spacing: -5px; margin-bottom: 20px; margin-left: -50px;">{{ labels.title }}</h6>
            </div>
            <h3>Welcome to ARB VPS System</h3>
            <form class="m-t" role="form" @submit.prevent="handleLogin">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Employee No" v-model="login.user" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="●●●●●●●" v-model="login.password" required="">
                </div>
                <button type="submit" class="ladda-button btn btn-primary block full-width m-b" data-style="slide-right" v-text="labels.button"></button>
            </form>
            <p class="m-t"> <small>ARB VPS System version 1.0.1 &copy; 2018</small> </p>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            labels: {
                type: Object,
                default () {
                    return {
                        title: 'ARB VPS System',
                        user: 'Username',
                        password: 'Password',
                        button: 'Login'
                    }
                }
            },
            apiUrl: {
                type: String,
                required: true
            },
            loginRoute: {
                type: String,
                default: 'login' //auth/token
            },
            userRoute: {
                type: String,
                default: 'user/'
            },
            clientId: {
                type: [Number, String],
                default: 2
            },
            secret: {
                type: String,
                required: true
            }
        },
        data () {
            return {
                laddabtn : '',
                login: {
                    user: '',
                    password: ''
                },
            }
        },
        computed: {
            loginUrl () {
                return `${this.apiUrl}/${this.loginRoute}`
            },
            userUrl () {
                return `${this.apiUrl}/${this.userRoute}`
            },
        },

        mounted() {
             this.laddabtn = Ladda.create( document.querySelector('.ladda-button'));
        },

        methods: {
            getHeaders (token) {
                return {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            },
            ax_config () {
                return {
                    headers:  {'X-CSRF-Token': this.$constants.csrf_token},
                }
            },
            handleLogin () {

               this.laddabtn.start();

                const authUser = {
                    employee_no: this.login.user,
                    password: this.login.password,
                }

                this.$axios.post(this.loginUrl, authUser, this.ax_config)
                    .then(response => {
                        if (response.data.errors) {
                            swal({ title: response.data.errors, text:response.data.message, type: "error" });
                            this.laddabtn.stop();
                        } else {
                            this.$session.set('user_session', response.data);
                            const headers = this.getHeaders(authUser.access_token);
                            this.$emit('success', { authUser, headers, response });
                        }
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        }
    }
</script>



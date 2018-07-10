<template>
    <!--<mainPage>-->
        <!--<router-view></router-view>-->
        <!--<div class="ibox-content" id="ibox-content" v-if="isChildren">-->
            <!--<clockTimeline/>-->
        <!--</div>-->
        <!-- <vpsclock/> -->
                  <!--  <div class="row">
                    <div class="col-lg-4">
                                <div class="ibox collapsed border-bottom">
                                    <div class="ibox-title">
                                        <h5>Quick Links</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-down"></i>
                                            </a>
                                       
                                         <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a> 
                                        </div>
                                    </div>
                                    <div class="ibox-content" style="display: block;">
                                                <ul class="list-group clear-list">
                                                            <li class="list-group-item fist-item">
                                                                <a href="http://timekeeping.arb-co.com" target="_blank" >Time Keeping</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="https://webmail.loannotify.com/" target="_blank">ARB Webmail</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="https://inbx.epicloansystems.com/" target="_blank">Inbox EPIC</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="https://vertical.loannotify.com/" target="_blank">Vertical V1</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="http://qa-report.vertical.arbcalls.com/login" target="_blank">Quality Assurance</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="http://app.arb-co.com/user/login" target="_blank">Human Resources</a>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <a href="http://training.arb-co.com/login" target="_blank">E-Learning</a>
                                                            </li>
                                                            
                                                </ul>
                                    </div>
                        </div>
                    </div>

                </div>-->
    <!--</mainPage>-->
</template>
<script>
    import mainPage from '../mainPage.vue'
    import vpsclock from '../vpsClock.vue'
    import clockTimeline from '../../widgets/clock_ticker/clockTimeline.vue'

    export default {
        props: {
            isChildren: {
                type: Boolean,
                default: true
            },
        },
        components: { mainPage, vpsclock, clockTimeline, },
        beforeCreate () {
            if (!this.$session.exists()) {
                this.$router.push('/login')
            }
        },
    }
</script>
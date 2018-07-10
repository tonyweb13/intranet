<template>
    <div class="row border-bottom">
        <!-- to be remove -->
        <!--<a href="#" @click="greet"> test</a>-->
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <headclock />

            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                <form role="search" class="navbar-form-custom">
                    <div class="form-group">
                        <!--<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">-->
                    </div>
                </form>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <logout/>
                </li>
            </ul>
        </nav>
        <!--<btnActivities  />-->
    </div>
 </template>

<script>
    import logout from './logout.vue'
    import headclock from './header_clock.vue'
    import btnActivities from '../widgets/clock_ticker/btnActivities.vue'

    export default {
        components:{ logout, headclock, btnActivities },

        mounted() {
        },


        methods: {

            greet: function (event) {
                swal(
                    'Good job!',
                    'You clicked the button!',
                    'success'
                );
            },

        }
    }
</script>
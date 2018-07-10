<template>
    <div>
        <nav class="navbar-default navbar-static-side" role="navigation" style="height:100%;">
            <div class="sidebar-collapse" style="height:100%;">
                <ul class="nav metismenu" id="side-menu" style="height:100%;">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span><img alt="image" class="img-circle" :src="imageMini"></span>
                            <span class="clear">
                            <span class="block m-t-xs"> <strong class="font-bold">{{employee.first_name}} {{employee.last_name}} <br>({{employee.employee_no}})</strong></span>
                            <span class="text-muted text-xs block"> {{employee.designation.name}} <b class="caret"></b></span>
                            </span></a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li>
                                    <router-link to="/profile"><i class="fa fa-user"></i> Profile</router-link>
                                </li>
                                <li>
                                    <a @click="pictureModal = true">
                                    <i class="fa fa-camera"></i> Change profile picture
                                    </a>
                                </li>
                                <li>
                                    <a @click="changeModal = true">
                                    <i class="fa fa-cog"></i> Change Password
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li><logout/></li>
                            </ul>
                        </div>
                    </li>

                    <li v-for="(item, index) in menu"
                        v-if="(item.is_menu == undefined || item.is_menu)"
                        :class="item.path.replace('/', '')"
                        >
                        <!--{{item.rules}}-->

                        <!--{{ rules[item.rules] }}-->

                        <a :href="item.children == undefined ? '/' : '#'">
                            <i :class="item.icon"></i>
                            <span class="nav-label"> {{item.label}} </span>
                            <span class="fa arrow" v-if="item.children"></span>
                        </a>

                        <ul class="nav collapse nav-second-level" v-if="item.children">
                        <!--instead of using replace ( / ) of ( _ ) from the path. Declared value in way for duplicate class as it is prone to errors in menu -->
                            <li v-for="(s_item, s_index) in item.children"
                                :class="item.path.replace('/', '') + '_'+ ( (s_item.path.substr(1).split('/')[1]) ? s_item.path.substr(1).split('/')[1] : s_item.path.substr(1)  ) "
                                v-if="(s_item.is_menu == undefined || s_item.is_menu == true)"
                                 >

                                <a v-if="s_item.children" :href="s_item.children == undefined ? '/' : '#'">
                                    <i :class="s_item.icon"></i>
                                    <span class="nav-label"> {{s_item.label}} </span>
                                    <span class="fa arrow" v-if="s_item.children"></span>
                                </a>
                                <ul class="nav collapse nav-third-level" v-if="s_item.children" >
                                    <li v-for="(t_item, s_index) in s_item.children"
                                        :class="item.path.replace('/', '') + '_' + s_item.path.replace('/', '') + '_' + t_item.path.substr(1).split('/')[2]"
                                        v-if="t_item.is_menu == undefined || t_item.is_menu == true">

                                        <link_route :route_link="t_item.path"
                                                    :label="t_item.label != undefined ? t_item.label : 'No Label' "
                                                    :icon="t_item.icon"/>
                                    </li>
                                </ul>

                                <link_route v-else :route_link="s_item.path" :label="s_item.label != undefined ? s_item.label : 'No Label' " :icon="s_item.icon" />
                            </li>
                        </ul>

                    </li>

                </ul>
            </div>
        </nav>

        <modal v-if="pictureModal" @close="pictureModal = false">
            <h3 slot="header">Profile Picture</h3>
            <profile-picture :imageProps="imageModal" @event="handler" slot="body">
            </profile-picture>
        </modal>

        <modal v-if="changeModal" @close="changeModal = false">
            <h3 slot="header">Change Password</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <change-pass :changePassProps="infos" slot="body" @event="handler"/>
        </modal>

    </div>
</template>
<script>
    import logout from './logout.vue';
    import link_route from './link_route.vue';
    import profilePicture from './vps/profile/picture.vue';
    import sideNavLink from './sidebar/sideNavLink';
    import sideNavDropdown from './sidebar/sideNavDropdown';
    import changePass from './settings/user/changePass.vue'

    export default {
        components:{ logout, link_route, profilePicture, sideNavLink, sideNavDropdown, changePass },

        data: function() {
            return {
                pictureModal: false,
                changeModal: false,
                imageMini: '/img/profile_small.jpg',
                imageModal: '/img/profile.jpg',
                menu : this.$router.options.routes,
                infos: this.$session.get('user_session'),
            }
        },
        created(){
            // console.log(this.employee);
            if (!this.$session.exists()) {

                this.employee = {
                        profile_pic: '',
                        first_name: '',
                        last_name: '',
                        designation:{
                            name: ''
                        }
                };

            } else {

                this.$bus.$on('init_image', (param) => { this.imageMini = param; });

                if(this.employee.profile_pic){
                    this.imageMini = '/storage/profile/'+ this.employee.profile_pic;
                    this.imageModal = '/storage/profile/thumbnail/'+ this.employee.profile_pic;
                }

                this.$bus.$on('init_modal', (param) => {
                    this.changeModal = param;
                });

                this.menu = this.inRules(this.$router.options.routes);

            }

        },
        watch: {
            '$route': {
                deep: true,
                handler: function (refreshPage) {
                    this.menuChange();
                }
            }
        },
        mounted(){

            $('#side-menu').metisMenu();
            this.menuChange();
            // this.inRules (this.$router.options.routes)
            // this.rules = vps.settings.acl_rules.rules.loanapproval;
        },
        methods: {
            handler (params) {
                this.pictureModal = params;
                this.changeModal = params;
            },
            inRules (inrules) {

                let menus = [];

                for (var key in inrules) {
                    let data = inrules[key];

                    if(typeof data.meta == 'undefined') {
                        continue;
                    }



                    if(data.path === '/')
                    {
                        menus.push(inrules[key]);

                    } else if (typeof data.meta.rules !== 'undefined' ) {
                        // console.log(data.meta.rules);
                        let parent_rule_enable = this.acl_rules[data.meta.rules];

                        if (typeof parent_rule_enable === "boolean") {

                            if(typeof data.children !== 'undefined') {
                                inrules[key].children = '';
                            }

                            if(parent_rule_enable) {
                                menus.push(inrules[key]);
                            }

                        } else {

                            let global_menu = (typeof data.meta.global_menu !== 'undefined') ? data.meta.global_menu : false;


                            if(global_menu) {
                                menus.push(inrules[key]);
                            }

                            if(typeof parent_rule_enable !== 'undefined' && Object.keys(parent_rule_enable.child_rules).length >= 1 && parent_rule_enable.is_enable) {

                                let children_menus = [];
                                let child_data = inrules[key]['children'];
                                let new_children = [];

                                for (var child_key in child_data) {

                                    /* Include children where rules meta is nulle because the children considered as menu and global*/
                                    if(typeof child_data[child_key].meta == 'undefined') {
                                        new_children.push(child_data[child_key]);
                                        continue;
                                    }

                                    let child_global_menu = (typeof child_data[child_key].meta.global_menu !== 'undefined')  ? child_data[child_key].meta.global_menu : undefined;

                                    /* Check if child menu is declared globally for users*/
                                    if(child_global_menu) {
                                        // console.log(child_data[child_key]);
                                        new_children.push(child_data[child_key]);
                                    } else {

                                        if (typeof child_data[child_key].meta !== 'undefined' && typeof child_data[child_key].meta.rules !== 'undefined' )
                                        {
                                            let child_rule = child_data[child_key].meta.rules;
                                            // console.log(parent_rule_enable.child_rules[child_rule]);
                                            if ( parent_rule_enable.child_rules[child_rule] ) {

                                                if(typeof child_data[child_key].children !== 'undefined' && Object.keys(child_data[child_key].children).length >= 1) {

                                                        let childs = child_data[child_key].children;
                                                        let build_level3_child = [];
                                                        // console.log(childs);
                                                        for (var level_3_child in childs) {
                                                            // console.log(childs[level_3_child]);
                                                            if(parent_rule_enable.child_rules[child_rule].child_rules !== 'undefined') {
                                                                // console.log(childs[level_3_child].meta);
                                                                if(typeof childs[level_3_child].meta !== 'undefined') {
                                                                    let route_3_child = childs[level_3_child].meta.rules;
                                                                    let rule_3_child = parent_rule_enable.child_rules[child_rule].child_rules[route_3_child];

                                                                    if(rule_3_child) {
                                                                        build_level3_child.push(childs[level_3_child]);
                                                                    }
                                                                }


                                                            }

                                                        }

                                                        // overwrite 3rd level childs
                                                        child_data[child_key].children = build_level3_child;

                                                        if(parent_rule_enable.child_rules[child_rule].is_enable) {
                                                            // overwrite 2nd level childs
                                                            new_children.push(child_data[child_key]);
                                                        }

                                                } else {

                                                    if(typeof parent_rule_enable.child_rules[child_rule].is_enable !== 'undefined') {

                                                            if(parent_rule_enable.child_rules[child_rule].is_enable) {
                                                                new_children.push(child_data[child_key]);
                                                            }

                                                    } else {
                                                        new_children.push(child_data[child_key]);
                                                    }


                                                }

                                            }

                                        }

                                    }
                                }

                                inrules[key]['children'] = new_children;

                                if(!global_menu) {
                                    menus.push(inrules[key]);
                                }
                            }

                        }

                    }

                }

                return menus;

            },
            menuChange : function() {
                var url_path = window.location.pathname;
                var split_url = url_path.substr(1);
                var paths = split_url.split("/");
                $('#side-menu').find('.active').removeClass('active');
                $('#side-menu .'+paths[0]).addClass('active');
                let active_path = paths[0]+'_'+paths[1];
                if(paths.length > 2 && paths.length <= 3) {
                    $('#side-menu .'+paths[0]).find('.'+active_path+' ul').addClass('in');
                    $('#side-menu .'+paths[0]).find('.'+active_path+' ul').parents().addClass('in');
                    $('#side-menu .'+paths[0]+' ul').find('.'+active_path+'_'+paths[2]).addClass('active');
                } else {
                    $('#side-menu .'+paths[0]+' ul').addClass('in');
                }

                $('#side-menu .'+paths[0]+' ul').find('.'+active_path).addClass('active');
            },
        },
    }
</script>
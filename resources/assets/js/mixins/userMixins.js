export default {
    data() {
        return {
            modalLoader: '',
            modalmask: '',
            employee : {
                first_name : '',
                last_name : '',
                designation : '',
                department:{},
                designation:{},
                employment_type:{},
                address:{},
                government_credential:{},
            },
            imageMini: '',
            acl_rules : (typeof vps != "undefined" && typeof vps.settings.acl_rules != "undefined" && vps.settings.acl_rules !== null) ? vps.settings.acl_rules.rules : '',
        }
    },
    created(){
        // console.log(vps.settings.acl_rules);
        // console.log(this.$session.get('user_session'));
        // console.log(vps.settings.auth_user);
        this.employee = (typeof vps != "undefined" ) ? vps.settings.auth_user : '' ;
    },
    mounted(){
        // console.log(vps.settings.auth_user);
        this.modalmask = $(".modal-mask");
        this.modalLoader = $(".loader");
    },
}


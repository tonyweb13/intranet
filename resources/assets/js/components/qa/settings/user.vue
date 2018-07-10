<template>
    <div>
        <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
        <content-header :header="title" :list="list" />
        <main-content-wrapper :header="header" />
    </div>
</template>
<script>
    'use strict';

    import ContentHeader from '../shared/contentHeader.vue';
    import MainContentWrapper from '../shared/mainContentWrapper.vue';

    export default {
        name: 'users',
        data: function () {
            return {
                title: 'Employee Records',
                header: '',
                list: [
                    {
                        name: 'Home',
                        url: '/main',
                        icon: 'fa fa-th-large',
                    },
                    {
                        name: 'Employee Records',
                        url: '/settings/user',
                        icon: 'fa fa-user'
                    }
                ]
            }
        },
        computed: {
            title() {
                return this.title
            }
        },
        components: {ContentHeader, MainContentWrapper}
    }
</script>
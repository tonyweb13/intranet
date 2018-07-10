<template>
    <div class="row wrapper wrapper-content border-bottom white-bg page-heading">
        <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
        <content-header :header="header" :list="list" />
        <main-content-wrapper :header="header" />
    </div>
</template>
<script>
    'use strict';

    import ContentHeader from '../shared/contentHeader.vue';
    import MainContentWrapper from '../shared/mainContentWrapper.vue';

    export default {
        name: 'categories',
        data: function () {
            return {
                title: 'Categories',
                list: [
                    {
                        name: 'Home',
                        url: '/main',
                        icon: 'fa fa-th-large',
                    },
                    {
                        name: 'Categories',
                        url: '/settings/categories',
                        icon: 'fa fa-list-alt'
                    }
                ]
            }
        },
        computed: {
            header() {
                return this.title
            }
        },
        components: {ContentHeader, MainContentWrapper}
    }
</script>
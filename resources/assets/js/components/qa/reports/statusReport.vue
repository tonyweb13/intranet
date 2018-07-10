<template>
    <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
    <!--<content-header :header="pageTitle" :list="list" />-->
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="ibox">
                <div class="col-lg-12">
                    <ibox-title-header :header="pageHeader" />
                    <div class="ibox-content">
                        <div class="row">
                            <div class="row">
                                <table id="form-table" class="table table-bordered table-striped compact" cellspacing="0" width="100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    'use strict';

    import axios from 'axios';

    import Months from '../months';
    import SearchButtonIcon from "../buttons/searchButtonIcon";
    import IboxTitleHeader from '../shared/iboxTitleHeader.vue';

    export default {
        name: 'statusReport',
        data: function () {
            return {
                title: 'QA Monthly Status Report',
                header: 'QA Monthly Status Report',
            }
        },
        computed: {
            pageTitle() {
                return this.title
            },
            pageHeader() {
                return this.header
            },
            monthsArray() {
                return Months.items
            }
        },
        components: {Months, IboxTitleHeader, SearchButtonIcon}
    }
</script>
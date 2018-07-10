<template>
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="ibox">
            <div class="col-lg-12">
                <ibox-title-header :header="titleHeader" />
                <div class="ibox-content">
                    content text goes here
                    <!--<table id="form-table" class="table table-bordered table-striped compact" class="display" cellspacing="0" width="100%"></table>-->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    'use strict';

    import IboxTitleHeader from './iboxTitleHeader.vue';

    export default {
        name: 'mainContentWrapper',
        data() {
            return {

            }
        },
        props: {
            header: {
                type: String,
                default: ''
            }
        },
        computed: {
          titleHeader() {
              return this.header
          }
        },
        components: {IboxTitleHeader}
    }
</script>
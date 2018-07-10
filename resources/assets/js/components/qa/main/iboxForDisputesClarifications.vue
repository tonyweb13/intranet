<template>
    <div class="col-lg-6 no-padding">
        <div class="ibox">
            <div class="ibox-title text-center">
                <h5>{{ title }} for (April 2018)</h5>
                <a href="/process/dispute" class="no-style">
                    <span class="btn btn-info btn-outline pull-right" type="button">
                        <i class="fa fa-paper-plane-o fa-1x"></i>&nbsp;&nbsp;{{ title }} Summary
                    </span>
                </a>
            </div>
            <div class="ibox-content" style="max-height: 400px; min-height: 400px; overflow-y: scroll">
                <div class="col-lg-12">
                    There is no unresolved disputes...
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    'use script';

    export default {
        name: 'iboxForDisputesClarifications',
        props: {
            results: {
                type: Array,
                required: true,
                default: [],
            },
            title: {
                type: String,
                default: ''
            }
        }
    }
</script>
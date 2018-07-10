<template>
    <div class="row wrapper wrapper-content border-bottom page-heading">
        <!--TODO: Well fix this content header once I figure out how to make page header dynamic-->
        <!--<content-header :header="updatePageTitle" :list="list" />-->
        <div class="row">
            <template v-for="(item, index) in items">
                <ibox-float :columnClass="iboxColumn" :titleClass="item.class" :title="item.title" :resultTotal="item.value" />
            </template>
        </div>
        <div class="row">
            <top-drivers :top_drivers="top_drivers"></top-drivers>
        </div>
        <div class="row">
            <template v-for="(result, index) in results">
                <ibox-for-disputes-clarifications :title="result.type" :results="results" />
            </template>
        </div>
    </div>
</template>
<script>
    'use script';

    import axios from 'axios';

    import { mapGetters, mapMutations } from 'vuex';
    import IboxFloat from "../commons/iboxFloat";
    import TopDrivers from "./topDrivers";
    import IboxForDisputesClarifications from "./iboxForDisputesClarifications";

    export default {
        name: 'dashboard',
        data: function () {
            return {
                headerTitle: this.$store.state.PageHeaders.page_title,
                title: 'Dashboard',
                iboxColumn: 'col-lg-2',
                //TODO: Replace this static data with actual data from audit form table
                items: [
                    {
                        title: 'Forms',
                        value: '592',
                        class: ''
                    },
                    {
                        title: 'Ongoing',
                        value: '6',
                        class: 'text-success'
                    },
                    {
                        title: 'Done',
                        value: '586',
                        class: 'text-info'
                    },
                    {
                        title: 'Passed',
                        value: '498',
                        class: 'text-success'
                    },
                    {
                        title: 'Failed',
                        value: '94',
                        class: 'text-danger'
                    },
                    {
                        title: 'Score Average',
                        value: '96.3',
                        class: 'text-info'
                    }
                ],
                top_drivers: [
                    {
                        type: 'Originators',
                        data: [
                            {
                                category: 'Operations',
                                descriptions: [
                                    {
                                        name: 'Followed Hold/Transfer/Conference Procedures Correctly',
                                        count: '355'
                                    },
                                    {
                                        name: 'Followed L- Verification [Phase 1 and Phase 2]',
                                        count: '212'
                                    },
                                    {
                                        name: 'Navigated the System Proficiently',
                                        count: '207'
                                    },
                                    {
                                        name: 'Followed proper Greeting Script [Inbound/Outbound] / Closing Script',
                                        count: '149'
                                    },
                                    {
                                        name: 'Notated the System Correctly',
                                        count: '113'
                                    },
                                    {
                                        name: 'Followed proper call Handling',
                                        count: '97'
                                    },
                                    {
                                        name: 'UW / Verifier Correction',
                                        count: '69'
                                    },
                                    {
                                        name: 'Followed the correct Process',
                                        count: '63'
                                    },
                                    {
                                        name: 'Input the Call Disposition in Soft Phone System Correctly',
                                        count: '59'
                                    }
                                ]
                            },
                            {
                                category: 'Compliance',
                                descriptions: [
                                    {
                                        name: 'Followed ACH Disclosure',
                                        count: '47'
                                    },
                                    {
                                        name: 'Followed Outbound Monitoring Disclaimer',
                                        count: '23'
                                    },
                                    {
                                        name: 'Followed Proper Authentication Procedure',
                                        count: '22'
                                    },
                                    {
                                        name: 'Followed APR Disclosure',
                                        count: '12'
                                    },
                                    {
                                        name: 'Followed APR Disclosure',
                                        count: '7'
                                    }
                                ]
                            }
                        ]
                    },
                    {
                        type: 'Collections',
                        data: [
                            {
                                category: 'Operations',
                                descriptions: [
                                    {
                                        name: 'Followed Hold/Transfer/Conference Procedures Correctly',
                                        count: '355'
                                    },
                                    {
                                        name: 'Followed L- Verification [Phase 1 and Phase 2]',
                                        count: '212'
                                    },
                                    {
                                        name: 'Navigated the System Proficiently',
                                        count: '207'
                                    },
                                    {
                                        name: 'Followed proper Greeting Script [Inbound/Outbound] / Closing Script',
                                        count: '149'
                                    },
                                    {
                                        name: 'Notated the System Correctly',
                                        count: '113'
                                    },
                                    {
                                        name: 'Followed proper call Handling',
                                        count: '97'
                                    },
                                    {
                                        name: 'UW / Verifier Correction',
                                        count: '69'
                                    },
                                    {
                                        name: 'Followed the correct Process',
                                        count: '63'
                                    },
                                    {
                                        name: 'Input the Call Disposition in Soft Phone System Correctly',
                                        count: '59'
                                    }
                                ]
                            },
                            {
                                category: 'Compliance',
                                descriptions: [
                                    {
                                        name: 'Followed ACH Disclosure',
                                        count: '47'
                                    },
                                    {
                                        name: 'Followed Outbound Monitoring Disclaimer',
                                        count: '23'
                                    },
                                    {
                                        name: 'Followed Proper Authentication Procedure',
                                        count: '22'
                                    },
                                    {
                                        name: 'Followed APR Disclosure',
                                        count: '12'
                                    },
                                    {
                                        name: 'Followed APR Disclosure',
                                        count: '7'
                                    }
                                ]
                            }
                        ]
                    }
                ],
                results: [
                    {
                        type: 'Disputes',
                        data: [
                            {
                                type: 'Disputes',
                            }
                        ]
                    },
                    {
                        type: 'Clarifications',
                        data: [
                            {
                                type: 'Disputes',
                            }
                        ]
                    }
                ]
            }

        },
        computed: {
            ...mapGetters({
                updatePageTitle: 'PageHeaders/pageTitle'
            })
        },
        created() {
            this.allUsers();
        },
        methods: {
            allUsers() {
                axios.get('/api/qa/user/all')
                    .then(response => {
                        return response;
                        console.log(response);
                    });
            },
        },
        components: {
            IboxForDisputesClarifications,
            TopDrivers,
            IboxFloat
        }
    }
</script>

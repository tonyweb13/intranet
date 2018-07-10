<template>
    <mainPage>
        <ibox title="Request for Payment">
            <listheader>
                <add-button
                        class='pull-left'
                        text-to-add='Approval Form'
                        :to="{path: '/loanapproval/application/add'}"
                />
                <custom-search v-model="searchKey" />
            </listheader>
            <custom-table :columns='columnApplications'>
                <tr v-for="application in filteredApplications" >
                    <td>
                        <view-button :to="{ name: 'application-show', params: {application_id: application.id}}" />
                        <edit-button :to="{ name: 'application-edit', params: {application_id: application.id}}" />
                        <delete-button :to="{ name: 'application-delete', params: {application_id: application.id}}" />
                    </td>
                    <td>{{ application.app_number }}</td>
                    <td>{{ application.states }}</td>
                    <td>{{ application.portfolio }}</td>
                    <td>{{ application.downloads }}</td>
                    <td>{{ application.new_or_return }}</td>
                    <td>{{ application.end_of_billing }}</td>
                    <td>{{ application.pay_type }}</td>
                    <td>{{ application.exceptions }}</td>
                    <td>
                        {{ application.ddl1 }},
                        {{ application.ddl2 }},
                        {{ application.ddl3 }},
                        {{ application.ddl4 }},
                        {{ application.ddl5 }},
                        {{ application.ddl6 }},
                    </td>
                    <td>
                        {{ application.eod1 }},
                        {{ application.eod2 }},
                        {{ application.eod3 }},
                        {{ application.eod4 }},
                        {{ application.eod5 }},
                        {{ application.eod6 }},
                    </td>
                </tr>
            </custom-table>
        </ibox>
    </mainPage>
</template>
<script>
    import axios from 'axios'
    import searchMixin from '../../../mixins/searchMixins'
    import tableColumnMixin from '../../../mixins/tableColumnMixins'
    import mainPage from '../../mainPage.vue'
    import ibox from '../../../shared/customHtml/ibox.vue'
    import listheader from '../../../shared/customHtml/listheader.vue'
    import AddButton from '../../../shared/buttons/addButton.vue'
    import EditButton from '../../../shared/buttons/editButton.vue'
    import DeleteButton from '../../../shared/buttons/deleteButton.vue'
    import ViewButton from '../../../shared/buttons/viewButton.vue'
    import customSearch from '../../../shared/inputs/customsearch.vue'
    import CustomTable from '../../../shared/customTable.vue'

    export default {
        mixins: [ searchMixin, tableColumnMixin ],
        components: { mainPage, ibox, listheader, customSearch, AddButton, EditButton, DeleteButton, ViewButton, CustomTable },
        data: function () {
            return {
                applications: [],
                searchKey: '',
            };
        },
        created() {
            axios.get("/api/loanapproval/application")
                .then(response => {
                    this.applications = response.data;
                });
        },
    }
</script>
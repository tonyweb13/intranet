<template>
    <ibox title="List of NTE Form">
        <div>
            <add-button @add="addRow()" textToAdd="NTE Form"/>
            <v-client-table :data="rows" :columns="columns" :options="options">
                <template slot="actions_row" slot-scope="props">
                    <button class='btn btn-default btn-md' @click="handleEdit(props.row)"> {{ labels.viewBtn }}</button>
                </template>
            </v-client-table>
        </div>

        <modal v-if="openModal" @close="openModal = false">
            <h3 slot="header">Add NTE Form</h3>
            <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
            <add-nte slot="body" />
        </modal>

    </ibox>
</template>
<script>
    import addNte from '../../../../components/hr/nte/nteform/add.vue'

    export default {
        components: { addNte },
        props:
        {
            labels: {
                type: Object,
                default() {
                    return {
                        viewBtn: 'View',
                    }
                }
            },

        },
        data: function() {
            return {
                columns: ['actions_row', 'name', 'description'],
                rows:  [],
                openModal: false,
                options: {
                    headings: {
                        actions_row: 'Actions',
                        name: 'Name',
                        description: 'Description',
                    },
                    sortable: ['name', 'description'],
                    filterable: ['name', 'description']
                },
            }
        },
        created() {
            this.fetchNteList();
            this.$bus.$on('updateList', this.fetchNteList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods: {
            fetchNteList: function() {
                this.$constants.HR_API.get('/ntelistform')
                .then(response => {
                    return this.rows = response.data;
                });
            },
            handleEdit(row) {
                this.$router.push('/hr/nte/edit/'+ row.id);
            },
            addRow: function (props_row) {
                this.openModal = true;
            },
        }
    }

</script>
<template>
    <div v-if="categoriesProps">
        <ibox :title="categoryTitle">
            <div>
                <v-client-table :data="rows" :columns="columns" :options="options">
                    <template slot="provision" slot-scope="props">
                        <div style="width: 180px;">{{ props.row.provision.provision }}</div>
                    </template>
                    <template slot="gravity" slot-scope="props">
                       <div style="width: 80px;">{{ props.row.gravity.gravity }}</div>
                    </template>
                    <template slot="corrective_action" slot-scope="props">
                        <div style="width: 150px;">{{ props.row.corrective_action.corrective_action }}</div>
                    </template>
                    <template slot="actions" slot-scope="props">
                        <div style="width: 100px;">
                            <button class='btn btn-primary btn-xs' @click="addEditRow(props.row)"><i class="fa fa-pencil"></i> {{ labels.editBtn }}</button>
                            <button class='btn btn-danger btn-xs' @click="deleteRow(props.row)"><i class="fa fa-remove"></i> {{ labels.deleteBtn }}</button>
                        </div>
                    </template>
                </v-client-table>
            </div>

            <modal v-if="openModal" @close="openModal = false">
                <h3 slot="header">{{ headerName }}</h3>
                <small slot="header" class="pull-right required_fields"><i>Required Fields ( <span class="required_asterisk">*</span> )</i></small>
                <add-edit :offenseProps="offense_data" slot="body" />
            </modal>

        </ibox>
    </div>
</template>
<script>
    import addEdit from '../../../../components/hr/nte/offense/addEdit.vue'

    export default {
        components: {
            addEdit
        },
        props: {
            categoriesProps: Number,
                labels: {
                    type: Object,
                    default() {
                        return {
                            edit: 'Edit Offense',
                            editBtn: 'Edit',
                            deleteBtn: 'Delete'
                    }
                }
            },
        },
        data: function () {
            return {
                columns: ['actions', 'provision', 'gravity', 'corrective_action', 'offense'],
                rows:  [],
                options: {
                    sortable: ['provision', 'gravity', 'corrective_action', 'offense'],
                    filterable: ['provision', 'gravity', 'corrective_action', 'offense']
                },
                headerName: '',
                openModal: false,
                offense_data: {
                    off_category: '',
                    off_provision: '',
                    off_offense: '',
                    off_gravity: '',
                    off_corrective_action: '',
                    off_id: '',
                },
                categoryTitle: '',
            }
        },
        mounted() {
            this.$emit("update", this.updatePagination);
        },
        created(){
            this.getList();
            this.$bus.$on('updateList', this.getList);
            this.$bus.$on('init_modal', (param) => {
                this.openModal = param;
            });
        },
        methods:{
            getList: function() {
                this.$constants.HR_API.get("/offense/category/"+this.categoriesProps)
                    .then(response => {
                        this.rows = response.data;
                        if(this.rows[1].category.name){
                            this.categoryTitle = "List of Offenses for "+this.rows[1].category.name;
                        }
                    });
            },
            addEditRow: function (props_row) {
                this.openModal = true;
                if(props_row){
                    this.headerName = this.labels.edit;
                    this.offense_data.off_category = props_row.category.name;
                    this.offense_data.off_provision = props_row.provision.provision;
                    this.offense_data.off_offense = props_row.offense;
                    this.offense_data.off_gravity = props_row.gravity.gravity;
                    this.offense_data.off_corrective_action = props_row.corrective_action.corrective_action;
                    this.offense_data.off_id = props_row.id;
                }
            },
            deleteRow: function (props_row) {
                swal({
                    title: 'Are you sure you want to delete item Number: ' + props_row.id + ' ?',
                    text: "Once deleted, you will not be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                })
                    .then((result) => {
                        if (result.value) {
                            this.$constants.HR_API.delete("/offense/" + props_row.id)
                                .then(response => {
                                    response.data;
                                    this.getList();
                                });
                            swal(
                                'Deleted!',
                                'Item Number: ' + props_row.id + ' has been deleted!',
                                "success",
                            );
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            swal(
                                'Cancelled',
                                'Item Number: ' + props_row.id + ' is safe!',
                                'error'
                            )
                        }
                    })
            },
        }
    }
</script>
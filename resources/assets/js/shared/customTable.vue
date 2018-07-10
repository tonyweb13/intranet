<template>
    <table class="table table-striped table-hover dataTable table-responsive">
        <thead>
        <tr>
            <th>Actions</th>
            <th v-for="title in _html_titles">{{title}}</th>
        </tr>
        </thead>
        <tbody>
            <slot/>
        </tbody>
    </table>
</template>
<script>
    import VueUtil from '../mixins/vue_util'

    export default {
        props: {
            columns: {
                type: Array,
                required: true,
            },
        },
        computed: {
            _html_titles() {
                let columns = [];
                for (let custom_column of this.columns) {
                    let title = this._getTitle(custom_column);
                    columns.push(title);
                }

                return columns;
            },
        },
        methods: {
            _getTitle(column) {
                let title = column.title;
                if (!title) {
                    let field = column.field;
                    if (typeof field === 'string') {
                        title = VueUtil.fieldToTitle(field);
                    } else {
                        this.warn('Custom Table column is missing title and field is not a string');
                        title = 'missing'
                    }
                }
                return title;
            },
        }
    }
</script>
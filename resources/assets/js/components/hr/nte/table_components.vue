<template>
    <div class="col-lg-12">
        <table class="table table-bordered table-responsive m-t">
            <thead >
                <tr>
                    <th>Criteria</th>
                    <th>Target Loan Amount</th>
                    <th>Actual Loan Amount</th>
                    <th>Target</th>
                    <th>Actual</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:20%;">
                        <div><strong>Monthly Key Performance Indicator (KPI)-</strong></div>
                        <strong>December</strong>
                    </td>
                    <td style="width:20%;">
                        <input class="form-control input-sm" name="target" type="text"
                        v-model="infoNte.target" v-validate="'required|integer'" :class="{'input': true, 'is-danger': errors.has('target') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('target')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                    <span v-show="errors.has('target')" class="help is-danger">{{ errors.first('target') }}</span>
                    </td>
                    <td style="width:20%;">
                        <input class="form-control input-sm" name="actual" type="text"
                        v-model="infoNte.actual" v-validate="'required|integer'" :class="{'input': true, 'is-danger': errors.has('actual') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('actual')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('actual')" class="help is-danger">{{ errors.first('actual') }}</span>
                    </td>
                    <td>
                        <input class="form-control input-sm" name="target_grade" type="text"
                        v-model="infoNte.target_grade" v-validate="'required|integer'" :class="{'input': true, 'is-danger': errors.has('Target grade') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('Target grade')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Target grade')" class="help is-danger">{{ errors.first('Target grade') }}</span>
                    </td>
                    <td>
                        <input class="form-control input-sm" name="actual_grade" type="text"
                        v-model="infoNte.actual_grade" v-validate="'required|integer'" :class="{'input': true, 'is-danger': errors.has('Actual grade') }" >
                        <div class="pull-right">
                            <i v-show="errors.has('Actual grade')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Actual grade')" class="help is-danger">{{ errors.first('Actual grade') }}</span>
                    </td>
                    <td>
                        <textarea class="form-control input-sm" v-validate="'required'" name="remarks" v-model="infoNte.remarks" 
                        :class="{'input': true, 'is-danger': errors.has('Remarks') }"/>
                        <div class="pull-right">
                            <i v-show="errors.has('Remarks')" class="input_warning_icon fa fa-warning"></i>
                        </div>
                        <span v-show="errors.has('Remarks')" class="help is-danger">{{ errors.first('Remarks') }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                infoNte: {
                    target: '',
                    actual: '',
                    provision: '',
                    gravity: '',
                    remarks: ''
                },
            }
        },
    }
</script>
<template>
    <div class="panel-body">
        <div class="pull-right m-b-sm">
            <button class='btn btn-warning btn-xs' @click="$emit('updateInfo')">Edit Employment Information</button>
        </div>
        <table class="table small m-b-xs m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>Date Hired : </strong> {{ employee.date_hired  }}
                </td>
                <td>
                    <strong>Date Regular : </strong> {{ employee.regularization_date }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Employment Type : </strong> {{ employee.employment_type.name }}
                </td>
                <td>
                    <strong>Employment Description : </strong> {{ employee.employment_type.Description }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
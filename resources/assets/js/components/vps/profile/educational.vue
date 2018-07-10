<template>
    <div class="panel-body">
        <div class="pull-right m-b-sm">
            <button class='btn btn-warning btn-xs' @click="$emit('updateInfo')">Edit Educational Background</button>
        </div>
        <table class="table small m-b-xs m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>Course : </strong> {{ employee.course  }}
                </td>
                <td>
                    <strong>Year Graduated : </strong> {{ employee.year_graduated }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Educational Institution : </strong> {{ employee.educational_institution }}
                </td>
                <td>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
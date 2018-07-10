<template>
    <div class="panel-body">
        <div class="pull-right m-b-sm">
            <button class='btn btn-warning btn-xs' @click="$emit('updateInfo')" >Edit Personal Information</button>
        </div>
        <table class="table small m-b-xs m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>Gender : </strong> {{ employee.gender }}
                </td>
                <td>
                    <strong>Birthday : </strong> {{ employee.birthday }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Civil Status : </strong> {{ employee.civil_status }}
                </td>
                <td>
                    <strong>Mobile : </strong> {{ employee.mobile_no }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Email Address : </strong> {{ employee.email_address }}
                </td>
                <td>
                    <strong>Address : </strong> {{ employee.address.current_address }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
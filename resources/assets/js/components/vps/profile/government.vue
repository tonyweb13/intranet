<template>
    <div class="panel-body">
        <div class="pull-right m-b-sm">
            <button class='btn btn-warning btn-xs' @click="$emit('updateInfo')">Edit Government Information</button>
        </div>
        <table class="table small m-b-xs m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>PhilHealth Number : </strong> {{ employee.government_credential.phil_health_number }}
                </td>
                <td>
                    <strong>Pag-ibig Number: </strong> {{ employee.government_credential.hmdf_number }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>SSS Number : </strong> {{ employee.government_credential.sss_number }}
                </td>
                <td>
                    <strong>TIN Number : </strong> {{ employee.government_credential.tin_number }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
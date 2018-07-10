<template>
    <div class="panel-body">
        <div class="pull-right m-b-sm">
            <button class='btn btn-warning btn-xs' @click="$emit('updateInfo')" >Edit Details Information</button>
        </div>
        <table class="table small m-b-xs m-t-sm">
            <tbody>
            <tr>
                <td>
                    <strong>Person to contact in case of emergency: </strong> {{ employee.person_to_contact_in_case_of_emergency  }}
                </td>
                <td>
                    <strong>Relationship to contact person: </strong> {{ employee.relationship  }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Contact person number: </strong> {{ employee.contact_person_no  }}
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
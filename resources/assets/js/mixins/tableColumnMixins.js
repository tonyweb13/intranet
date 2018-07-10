export default {
    computed: {
        columnPayments() {
            return [
                {title: 'ID'},
                {title: 'Request Number'},
                {title: 'Department'},
                {title: 'Supplier'},
                {title: 'Payee'},
                {title: 'Amount'},
                {title: 'Due Date'},
                {title: 'Description'},
                {title: 'Requested By'},
                {title: 'Noted By'},
                {title: 'Approved By'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnSupplies() {
            return [
                {title: 'Control Number'},
                {title: 'Department'},
                {title: 'Location'},
                {title: 'Order Quantity'},
                {title: 'Item Code'},
                {title: 'Item Description'},
                {title: 'Unit'},
                {title: 'Amount'},
                {title: 'Total Amount'},
                {title: 'Issued Quantity'},
                {title: 'Date Received'},
                {title: 'Pending Order Quantity'},
                {title: 'Pending Date Received'},
            ];
        },

        columnSchedules() {
            return [
                {title: 'ID'},
                {title: 'User ID'},
                {title: 'Work Week'},
                {title: 'Sunday'},
                {title: 'Monday'},
                {title: 'Tuesday'},
                {title: 'Wednesday'},
                {title: 'Thursday'},
                {title: 'Friday'},
                {title: 'Saturday'},
                {title: 'Start Date'},
                {title: 'End Date'},
                {title: 'Created By'},
                {title: 'Updated By'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnApplications() {
            return [
                {title: 'App Number'},
                {title: 'States'},
                {title: 'Portfolio'},
                {title: 'Downloads'},
                {title: 'New or Return'},
                {title: 'End_of Billing'},
                {title: 'Pay Type'},
                {title: 'Exceptions'},
                {title: 'DDL'},
                {title: 'EOD'},
            ];
        },

        columnDepartments() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnShifts() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Start'},
                {title: 'End'},
                {title: 'Status'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnActivities() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Class'},
                {title: 'Label Name'},
                {title: 'Icon'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },
        
        columnPortfolios() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnCostCenters() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnOfficeLocations() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnEmploymentTypes() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Description'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },
        
        columnDesignations() {
            return [
                {title: 'ID'},
                {title: 'Name'},
                {title: 'Created Date'},
                {title: 'Updated Date'},
            ];
        },

        columnEmployees() {
            return [
                {title: 'ID'},
                {title: 'Employee ID'},
                {title: 'Username'},
                {title: 'Password'},
                {title: 'First Name'},
                {title: 'Last Name'},
                {title: 'Email Address'},
            ];
        },
    }
}
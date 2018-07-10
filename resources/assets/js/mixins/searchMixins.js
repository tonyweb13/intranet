export default {
    computed: {
        filteredPayments() {
            return this.payments.filter((payment) => {
                return payment.department.indexOf(this.searchKey) > -1
                    || payment.supplier.indexOf(this.searchKey) > -1 || payment.payee.indexOf(this.searchKey) > -1
                    || payment.description.indexOf(this.searchKey) > -1 || payment.requested_by.indexOf(this.searchKey) > -1
                    || payment.noted_by.indexOf(this.searchKey) > -1 || payment.approved_by.indexOf(this.searchKey) > -1;
            })
        },

        filteredSupplies() {
            return this.supplies.filter((supply) => {
                return supply.department.indexOf(this.searchKey) > -1
                    || supply.location.indexOf(this.searchKey) > -1
                    || supply.item_code.indexOf(this.searchKey) > -1
                    || supply.item_description.indexOf(this.searchKey) > -1
                    || supply.unit.indexOf(this.searchKey) > -1;
            })
        },

        filteredShifts() {
            return this.shifts.filter((shift) => {
                return shift.name.indexOf(this.searchKey) > -1 || shift.description.indexOf(this.searchKey) > -1
            })
        },

        filteredActivities() {
            return this.activities.filter((activity) => {
                return activity.name.indexOf(this.searchKey) > -1 || activity.description.indexOf(this.searchKey) > -1
            })
        },

        filteredApplications() {
            return this.applications.filter((application) => {
                return application.states.indexOf(this.searchKey) > -1
                    || application.portfolio.indexOf(this.searchKey) > -1
                    || application.downloads.indexOf(this.searchKey) > -1
                    || application.end_of_billing.indexOf(this.searchKey) > -1
                    || application.pay_type.indexOf(this.searchKey) > -1;
            })
        },

        filteredDepartments() {
            return this.departments.filter((department) => {
                return department.name.indexOf(this.searchKey) > -1 || department.description.indexOf(this.searchKey) > -1
            })
        },

        filteredSchedules() {
            return this.schedules.filter((schedule) => {
                return schedule.user_id
            })
        },

        filteredPortfolios() {
            return this.portfolios.filter((portfolio) => {
                return portfolio.name.indexOf(this.searchKey) > -1 || portfolio.description.indexOf(this.searchKey) > -1
            })
        },

        filteredCostCenters() {
            return this.costcenters.filter((costcenter) => {
                return costcenter.name.indexOf(this.searchKey) > -1 || costcenter.description.indexOf(this.searchKey) > -1
            })
        },

        filteredOfficeLocations() {
            return this.officelocations.filter((officelocation) => {
                return officelocation.name.indexOf(this.searchKey) > -1 || officelocation.description.indexOf(this.searchKey) > -1
            })
        },

        filteredEmploymentTypes() {
            return this.employmenttypes.filter((employment) => {
                return employment.name.indexOf(this.searchKey) > -1 || employment.description.indexOf(this.searchKey) > -1
            })
        },
        
        filteredDesignations() {
            return this.designations.filter((designation) => {
                return designation.name.indexOf(this.searchKey) > -1 
            })
        },

        filteredEmployees() {
            return this.employees.filter((employee) => {
                return employee.username.indexOf(this.searchKey) > -1 
            })
        },
    }
}
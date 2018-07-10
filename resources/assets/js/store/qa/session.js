export default {
    namespaced: true,
    state: {
        month: ''
    },
    getters: {
        selectedMonth: state => `${state.month}`
    },
    mutations: {
        setMonth(state, selected_month) {
            state.month = selected_month;
        }
    },
    actions: {
        selectedMonthUpdate(context, month) {
            context.commit('updateSelectedMonth', month)
        }
    }
};
export default {
    namespaced: true,
    state: {
        page_title: 'ARB Call Facilities'
    },
    getters: {
        pageTitle: state => `${state.page_title}`
    },
    mutations: {
        updatePageTitle(state, pageTitle) {
            state.page_title = pageTitle;
        }
    },
    actions: {
        pageTitleupdate(context, pageTitle) {
            context.commit('updatePageTitle', pageTitle)
        }
    }
};
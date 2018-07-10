import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import PageHeaders from './pageheaders';
import user from './qa/user';
import session from './qa/session';

const store = new Vuex.Store({
    modules: {
        PageHeaders,
        user,
        session
    }
});

export default store;
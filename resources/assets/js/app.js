import 'babel-polyfill'
import Vue from 'vue'
import Vuex from 'vuex'
import App from './app.vue'
import Axios from 'axios'
import VueSession from 'vue-session'
import VueRouter from 'vue-router'
import Routes from './routes'
import Breabcrumbs from 'vue-2-breadcrumbs'
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import VeeValidate from 'vee-validate'
import { Validator } from 'vee-validate'
import { FormWizard, WizardButton, TabContent } from "vue-form-wizard"
import { ServerTable, ClientTable, Event } from 'vue-tables-2'
import vSelect from 'vue-select'
import * as constants from './constants'
import store from './store/store'
import draggable from 'vuedraggable'
import { VueEditor, Quill } from 'vue2-editor'
import { ImageDrop } from 'quill-image-drop-module'
// import { ImageResize } from 'quill-image-resize-module'
import VueCroppie from 'vue-croppie'

Quill.register('modules/imageDrop', ImageDrop)
// Quill.register('modules/imageResize', ImageResize)

/*start custom components*/
import mainPage from './components/mainPage.vue'
import modal from './shared/modal/modal.vue'
import ibox from './shared/customHtml/ibox.vue'
import listheader from './shared/customHtml/listheader.vue' //TODO: remove after datatable use in all crud
import customLabel from './shared/customHtml/customLabel.vue'
import customTable from './shared/customTable.vue'
import customSearch from './shared/inputs/customsearch.vue'
import customText from './shared/inputs/customText.vue'
import customTime from './shared/inputs/customTime.vue'
import customNumber from './shared/inputs/customNumber.vue'
import customTextarea from './shared/inputs/customTextarea.vue'
import customSelect from './shared/inputs/customSelect.vue'
import customDatepicker from './shared/inputs/customDatepicker.vue'
import addButton from './shared/buttons/addButton.vue'
import backButton from './shared/buttons/backButton.vue'
import cancelButton from './shared/buttons/cancelButton.vue'
import deleteButton from './shared/buttons/deleteButton.vue'
import editButton from './shared/buttons/editButton.vue'
import saveButton from './shared/buttons/saveButton.vue'
import viewButton from './shared/buttons/viewButton.vue'
import formGroup from './shared/inputs/formGroup.vue'
import deleteConfirmButton from './shared/buttons/deleteConfirmButton.vue'
/*end custom components*/

/*start custom mixins*/
import UserUtil from './mixins/userMixins'
import searchMixin from './mixins/searchMixins'
import tableColumnMixin from './mixins/tableColumnMixins'
/*end custom mixins*/

/*start prototype*/
Vue.prototype.$axios = Axios;
Vue.prototype.$constants = constants;
Vue.prototype.$bus = new Vue();
/*end prototype*/

export const router = new VueRouter({
    routes: Routes,
    mode: 'history',
});

export const config = {
    fieldsBagName: 'field',
};

/*start vue use*/
Vue.use(Element, { locale });
Vue.use(VueSession, { persist: true });
Vue.use(VueRouter);
Vue.use(Breabcrumbs);
Vue.use(ClientTable);
Vue.use(ServerTable);
Vue.use(Element, { locale , size: 'small'});
Vue.use(VeeValidate, config);
Vue.use(Vuex);
Vue.use(VueCroppie); // To Be Remove Unneeded because of CrosOrigin S3 Bucket
/*end vue use*/

/*start vue mixins*/
Vue.mixin(UserUtil);
Vue.mixin(searchMixin);
Vue.mixin(tableColumnMixin);
/*end vue mixins*/

/*start vue components*/
Vue.component('mainPage', mainPage);
Vue.component('modal', modal);
Vue.component('ibox', ibox);
Vue.component('listheader', listheader);
Vue.component('customLabel', customLabel);
Vue.component('customTable', customTable);
Vue.component('customSearch', customSearch);
Vue.component('customText', customText);
Vue.component('customTime', customTime);
Vue.component('customNumber', customNumber);
Vue.component('customTextarea', customTextarea);
Vue.component('customSelect', customSelect);
Vue.component('customDatepicker', customDatepicker);
Vue.component('addButton', addButton);
Vue.component('backButton', backButton);
Vue.component('cancelButton', cancelButton);
Vue.component('deleteButton', deleteButton);
Vue.component('editButton', editButton);
Vue.component('saveButton', saveButton);
Vue.component('viewButton', viewButton);
Vue.component('deleteConfirmButton', deleteConfirmButton);
Vue.component('Validator', Validator);
Vue.component('FormWizard', FormWizard);
Vue.component('WizardButton', WizardButton);
Vue.component('TabContent', TabContent);
Vue.component('formGroup', formGroup);
Vue.component('vSelect', vSelect);
Vue.component('draggable', draggable);
Vue.component('vueEditor', VueEditor);
/*end vue components*/


const app = new Vue({
    data: {
        loading: false,
        message: 'Hello',
    },
    router: router,
    store: store,
    render: h => h(App),
}).$mount('#vps-app');


router.beforeEach((to, from, next) => {
    // try {

        // let parentrules = to.matched[0].meta.rules;
        // let mainRules = vps.settings.acl_rules.rules[parentrules];
        // console.log(mainRules);
        // let childRules = mainRules.child_rules[to.meta.rules];
        // console.log(childRules );
        // let currentMenuRules = to.meta.rules;
        //
        // console.log(vps.settings.acl_rules);
        //
        // let current_rule = vps.settings.acl_rules.rules[parentrules].child_rules[currentMenuRules];
        //
        // if(mainRules.is_enable && current_rule) {
        //     app.loading = true
        //     next()
        // }
    // }
    // catch(err) {
    //     alert('Error Enable to Get Permission\nMessage : '+ err);
    // }

    // console.log(parent);
    // console.log(to);
    app.loading = true
    next()

})



router.afterEach(() => {
    setTimeout(() => app.loading = false, 1000)
})
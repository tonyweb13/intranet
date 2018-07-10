import applicationForm from './application_form.vue'
import applications from './applications.vue'
import duplicateCheck from './duplicate_check.vue'
import loanMatrix from './loanmatrix/add.vue'

export {
    applicationForm,
    applications,
    duplicateCheck,
    loanMatrix,
}

// const files = require.context('.', false, /\.vue$/)
// let modsd  = {}
//
// files.keys().forEach((key) => {
//     // console.log(key);
//     let mods = './'+key.replace(/(\.\/)/g, '');
//     modsd[key.replace(/(\.\/|\.vue)/g, '')] = System.import('./application_form.vue');
//     // System.import(mods);
//     // console.log(key.replace(/(\.\/)/g, ''));
//     // if (key === './index.js') return
//     // modules[key.replace(/(\.\/|\.vue)/g, '')] = require.context('.', false, /\.vue$/);
//     // console.log(modules);s
// })
//
// //
// // export default modules
// // console.log(modules);

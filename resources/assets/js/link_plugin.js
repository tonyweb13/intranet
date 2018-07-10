const link_route = {

    install(Vue, options) {
        // Vue.myAddedProperty = 'Example Property'
        // Vue.myAddedMethod = function() {
        //     return Vue.myAddedProperty
        // }
        // Vue.prototype.$myAddedMethod = function() {
        //
        // }
        Vue.mixin({

            mounted() {
                console.log('Mounted!');
            },
            methods: {
                testreverse : function(names) {
                    console.log('123456');
                    return;
                },

            },
        });
    }
};

export default link_route;

// Automatic installation if Vue has been added to the global scope.
if (typeof window !== 'undefined' && window.Vue) {
    window.Vue.use(link_route)
}
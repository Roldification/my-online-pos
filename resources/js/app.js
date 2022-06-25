/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
import Vue from 'vue';
import store from './store'

window.Vue = require('vue').default;
Vue.use(ElementUI, { size: 'small', zIndex: 3000, locale });
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('side-navigation', require('./components/navigation/SideNavigation.vue').default);
Vue.component('registration', require('./components/Registration.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('create-item', require('./components/partials/items/CreateItem.vue').default);
Vue.component('manage-categories', require('./components/partials/ManageCategories.vue').default);
Vue.component('items-list', require('./components/partials/items/ItemsList.vue').default);
Vue.component('create-purchase-order', require('./components/purchase-orders/CreatePurchaseOrder.vue').default);
Vue.component('item-view', require('./components/partials/items/ItemView.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: store
});

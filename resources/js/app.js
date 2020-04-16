/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
/**
 // window.Vue = require('vue');
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 Vue.component('example-component', require('./components/ExampleComponent.vue').default);
 */
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 const app = new Vue({
    el: '#app',
 });
 */

/**
 * Get and Substitute parameter of the Delete Form
 * Set name, name property and delete path (routeName) of the item
 * @param id - item id
 * @param name - name property of the item
 * @param item - item name
 */
window.deleteConfirm = function (id, name, item) {
    // Get plural route-name for Resource Controller
    var routeName = '';
    if(item[item.length - 1] === 'y') {
        item[item.length - 1] = 'i';
        routeName = item.substr(0, item.length - 1);
        routeName += 'ies';
    } else {
        routeName = item + 's';
    }
    // Capitalize the item name
    item = item.charAt(0).toUpperCase() + item.slice(1);
    // Set the form action route
    document.getElementById('del_form').setAttribute('action', '/' + routeName + '/' + id);
    // Set Title of the modal
    document.getElementById('del_modal_title').innerHTML = 'Delete ' + item;
    // Display the name of the item
    document.getElementById('item').innerHTML = item;
    // Display the name property of the item
    document.getElementById('item_name').innerHTML = '\" ' + name + ' \"';
};

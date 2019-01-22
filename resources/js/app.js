/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');

import VueProgressBar from 'vue-progressbar'

const options = {
    color: '#65e7ab',
    failedColor: '#e74b41',
    thickness: '2px',
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./components/App.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('editor', require('./components/Editor/Editor.vue').default);
Vue.component('action-btn', require('./components/ActionBtn.vue').default);
Vue.component('image-picker', require('./components/ImagePicker.vue').default);
Vue.component('multiselect', require('vue-multiselect').default)

Vue.directive('click-outside', require('./directives/outsideClick'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

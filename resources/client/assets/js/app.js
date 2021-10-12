
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window._ = require('lodash')
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.purify = o => JSON.parse(JSON.stringify(o))


let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

let date_format     = document.head.querySelector('meta[name="dp-date"]')
let time_format     = document.head.querySelector('meta[name="dp-time"]')
let datetime_format = document.head.querySelector('meta[name="dp-datetime"]')
let app_locale      = document.head.querySelector('meta[name="app-locale"]')

if (date_format && time_format && datetime_format) {
    window.date_format_moment     = date_format.content
    window.time_format_moment     = time_format.content
    window.datetime_format_moment = datetime_format.content
    window.app_locale             = app_locale.content
} else {
    console.error('Moment.js date and time formats not found')
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

window.Vue = require('vue')
Vue.prototype.$eventHub = new Vue()

import router from './routes'
import store from './store'
import Datatable from 'vue2-datatable-component'
import VueAWN from 'vue-awesome-notifications'
import vSelect from 'vue-select'
import datePicker from 'vue-bootstrap-datetimepicker'
import VueSweetalert2 from 'vue-sweetalert2'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'
import { ToggleButton } from 'vue-js-toggle-button'
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import VueTagsInput from '@johmun/vue-tags-input';

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.use(Datatable)
Vue.use(VueAWN, {
    position: 'top-right'
})
Vue.use(datePicker)
Vue.use(VueSweetalert2)

Vue.component('Modal', require('./components/Modal.vue'))
Vue.component('back-buttton', require('./components/BackButton.vue'))
Vue.component('bootstrap-alert', require('./components/Alert.vue'))
Vue.component('event-hub', require('./components/EventHub.vue'))
Vue.component('vue-button-spinner', require('./components/VueButtonSpinner.vue'))
Vue.component('v-select', vSelect)
Vue.component('datepicker', datePicker)
Vue.component('toggle-button', ToggleButton)
Vue.component('vue-dropzone', vue2Dropzone)
Vue.component('droply', vue2Dropzone)
Vue.component('vue-tags-input', VueTagsInput)

moment.updateLocale(window.app_locale, {
    week: {
        dow: 1
    }
})

const app = new Vue({
    data: {
        relationships: {},
        dpconfigDate: {
            format: window.date_format_moment
        },
        dpconfigTime: {
            format: window.time_format_moment
        },
        dpconfigDatetime: {
            format: window.datetime_format_moment,
            sideBySide: true
        }
    },
    router,
    store
}).$mount('#app')

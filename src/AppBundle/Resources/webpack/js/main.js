import Vue from 'vue'
import App from './App'
import jQuery from 'jquery'
window.jQuery = window.$ = jQuery
require('bootstrap-sass')
// Vue.config.delimiters = ['${', '}']
/* eslint-disable no-new */
new Vue({
  el: '#app',
  template: '<App/>',
  components: { App }
})

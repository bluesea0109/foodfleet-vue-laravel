import Vue from 'vue'
import Vuex from 'vuex'
import Vuetify from 'vuetify'
import VueAxios from 'vue-axios'
import axios from 'axios'
import VeeValidate from 'vee-validate'
import theme from '../resources/js/theme'
import '@freshinup/core-ui/src/styles/stylus/main.styl'

Vue.use(Vuetify, {
  options: {
    customProperties: true
  },
  iconfont: 'fa',
  theme
})

Vue.use(VueAxios, axios)
Vue.use(VeeValidate)
Vue.use(Vuex)

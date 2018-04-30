// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './app'
import router from './main/router'
import store from './main/store'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

Vue.config.productionTip = false

require('./main/global-components')
require('./assets/scss/main.scss')


/* eslint-disable no-new */
const mgtAdmin = new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>',
  store,
  beforeCreate () {
    // this.$store.dispatch('accounts/checkToken', {
    //   router: this.$router
    // })
    // // this.$router
  }
})

window.addEventListener('message', function (event) {
  if (!event.data || event.data.type !== 'token') return
  console.log('event.data', event.data)
  console.log(mgtAdmin.$store);
})

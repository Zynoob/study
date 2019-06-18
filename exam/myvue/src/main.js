import Vue from 'vue'
import App from './App.vue'
import router from './routes/router'
import store from './store'
import axios from 'axios'
import mypost from './axios'
import './assets/font/iconfont.css'
import './plugins/iview.js'

// axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
axios.defaults.withCredentials = true;
Vue.prototype.$axios = axios;
Vue.prototype.$mypost = mypost;

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

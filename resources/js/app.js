import * as Vue from 'vue'

import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import VueAxios from 'vue-axios'
import ElementPlus from 'element-plus'
import lang from 'element-plus/lib/locale/lang/ru'
import router from './router'
import App from '@/components/layout/MainLayout.vue'

import store from './store/index'

import Identity from './classes/Identity'
import axios from './classes/AxiosWrapper'

/**
 * @link https://element-plus.org/en-US/guide/design.html
 */
import 'element-plus/dist/index.css'
import 'element-plus/lib'

// import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'
import '../scss/elemet-override.scss'

const app = Vue.createApp(App)
for (let i = 0; i < Object.entries(ElementPlusIconsVue).length; i++) {
  const [key, component] = Object.entries(ElementPlusIconsVue)[i]
  app.component(key, component)
}

app
  .use(store)
  .use(VueAxios, axios)

async function init() {
  app.config.globalProperties.$http = axios
  app.config.globalProperties.$localStorage = localStorage
  app.use(router)
  app.use(ElementPlus, { locale: lang })
  app.mount('#app')
}

init()

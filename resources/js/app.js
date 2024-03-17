import { createApp } from "vue";
import { createPinia } from "pinia";
import router from './router';
import App from "./App.vue";
import CoreuiVue from '@coreui/vue-pro'
import CIcon from '@coreui/icons-vue'
import '@coreui/coreui-pro/dist/css/coreui.min.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import { iconsSet as icons } from '../icons/index'
import { registerFirebaseMessagingServiceWorker } from './services/service-worker';
import { Select2 } from "select2-vue-component";

const pinia = createPinia()
const app = createApp(App)

registerFirebaseMessagingServiceWorker()

app.component('select2', Select2)

app.use(router)
app.use(pinia)
app.use(CoreuiVue)
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.mount("#app");

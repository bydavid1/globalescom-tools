import './bootstrap';
import { createApp } from "vue";
import { createPinia } from "pinia";
import router from './router';
import App from "./App.vue";
import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '../icons/index'

const pinia = createPinia()
const app = createApp(App)


app.use(router)
app.use(pinia)
app.use(CoreuiVue)
app.provide('icons', icons)
app.component('CIcon', CIcon)
app.mount("#app");

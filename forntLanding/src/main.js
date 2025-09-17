import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios';
import VueAxios from 'vue-axios'

import App from './App.vue'
import router from './users/router'

const app = createApp(App)
import webUrl from "../config/dev.json"
  // import webUrl from "../config/prod.json";


import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import 'bootstrap/js/dist/popover.js';

////tailwind
import '@/commons/assets/css/index.css'
import "@/commons/assets/css/iransans.css"
import "@/commons/assets/fonts/fontawesome-free/css/all.min.css"


let token = localStorage.getItem('token');
axios.defaults.headers.common['Authorization'] = (token) ? token :  delete axios.defaults.headers.common['Authorization'];
 axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.headers.common['Access-Control-Allow-Headers'] = 'X-Requested-With';
axios.defaults.baseURL = webUrl.BASE_URL

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)


app.mount('#app')

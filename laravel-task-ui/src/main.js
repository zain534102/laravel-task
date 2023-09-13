import {createApp} from 'vue'
import App from './App.vue'
import router from "@/router/index.js";
import store from "@/store/index.js";
import './index.css'
import {error} from "@/directive/error.js";

const app = createApp(App);
app.directive('error', error)

app.use(router).use(store).mount('#app');

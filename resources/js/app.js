import './bootstrap';

import 'bootstrap/dist/css/bootstrap.css'
import '../css/app.css'
import '../css/main.css'

import { createApp } from "vue";

import App from "./App.vue";
import router from './router'

import { plugin, defaultConfig } from '@formkit/vue'
import FontAwesomeIcon from "@/helpers/fontawesome";

import HomeLoggedIn from './pages/HomeLoggedIn.vue';
import HomeLoggedOut from './pages/HomeLoggedOut.vue';
import Navbar from './page-components/Navbar.vue';
import Breadcrumbs from './page-components/Breadcrumbs.vue';
import Footer from './page-components/Footer.vue';

const app = createApp(App)
app.use(router)
app.use(plugin, defaultConfig);


app.component('Navbar', Navbar)
app.component('Breadcrumbs', Breadcrumbs)
app.component('Footer', Footer)
app.component('HomeLoggedIn', HomeLoggedIn)
app.component('HomeLoggedOut', HomeLoggedOut)
app.component("FontAwesomeIcon", FontAwesomeIcon)

app.mount("#app");
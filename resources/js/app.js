import { createApp } from 'vue';
import App from "./components/App.vue";
import './bootstrap';
import router from './router';
import '../css/app.css';

const app = createApp(App);

app.use(router);

app.mount('#app');

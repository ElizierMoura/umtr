import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import Customers from './components/Customers.vue';

const app = createApp();

app.component('app', App);
app.component('customers', Customers);

app.mount('#app');
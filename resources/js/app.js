import './bootstrap';


import { createApp } from 'vue'
// import the root component App from a single-file component.
import App from './components/App.vue'

const app = createApp(App).mount('#app')

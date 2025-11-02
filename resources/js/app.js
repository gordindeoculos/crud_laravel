import './bootstrap';
// import './validacao-formulario'
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import FormInput from './components/FormInput.vue';
app.component('example-component', ExampleComponent);
app.component('form-input', FormInput);

app.mount('#app');

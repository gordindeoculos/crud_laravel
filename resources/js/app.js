import './bootstrap'; // Interno do Laravel

// Importação do arquivo JavaScript de validação do formulário
import './validacao-formulario'

// Configuração do Vue.js
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

app.mount('#app');

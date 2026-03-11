// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';

// Importa tu componente Table.vue
import Table from './components/ui/Table.vue';

const app = createApp({});

// Usa PrimeVue con tema Aura
app.use(PrimeVue, {
    theme: { preset: Aura },
});

// Registra el componente global
app.component('table-component', Table);

// Monta Vue en un contenedor con id="app"
app.mount('#app');
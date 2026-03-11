<template>
    <DataTable v-model:selection="selectedOrganizations" :value="organizations" dataKey="id"
        tableStyle="min-width: 50rem">
        <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
        <Column field="name" header="Name"></Column>
        <Column field="slug" header="Slug"></Column>
        <Column field="type" header="Type"></Column>
    </DataTable>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import axios from 'axios';

const baseUrl = 'https://va-backend.test/api/v1/organizations';
const token = ref(null);

onMounted(() => {
    if (window.PHP_SESSION) {
        token.value = window.PHP_SESSION;
        console.log('hay sesion', token.value)
    }
});

axios.get(baseUrl, {
    headers: {
        Authorization: `Bearer ${token}`
    }
})
    .then(response => {
        console.log('Datos recibidos:', response.data);
    })
    .catch(error => {
        console.log(token.value);
        console.error('Error en la petición:', error);
    });

export default defineComponent({
    components: { DataTable, Column },
    setup() {
        const organizations = ref([
            { name: 'Product 1', category: 'Cat A', quantity: 10 },
            { name: 'Product 2', category: 'Cat B', quantity: 20 },
            { name: 'Product 3', category: 'Cat A', quantity: 5 },
        ]);



        return { organizations };
    },
});
</script>
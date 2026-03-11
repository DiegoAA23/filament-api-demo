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
import { defineComponent, ref, onMounted } from 'vue'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import axios from 'axios'

export default defineComponent({
  components: { DataTable, Column },
  setup() {
    const organizations = ref([])
    const selectedOrganizations = ref([])

    const root = document.getElementById('app')
    const token = root?.dataset?.apiToken ?? null

    onMounted(async () => {
      if (!token) {
        console.error('No hay token en #app[data-api-token]')
        return
      }

      try {
        const response = await axios.get('https://va-backend.test/api/v1/organizations', {
          headers: { Authorization: `Bearer ${token}` },
        })

        organizations.value = response.data?.data ?? []
      } catch (error) {
        console.error('Error en la petición:', error)
      }
    })

    return { organizations, selectedOrganizations }
  },
})
</script>


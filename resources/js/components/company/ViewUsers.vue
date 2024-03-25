<template>
    <div>
        <CTable v-if="users.length > 0" small>
            <CTableHead>
                <CTableRow>
                    <CTableHeaderCell scope="col">ID</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Nombre</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Email</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Creado</CTableHeaderCell>
                    <CTableHeaderCell scope="col">ID notificaciones</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow v-for="user in users" :key="user.id">
                    <CTableDataCell>{{ user.id }}</CTableDataCell>
                    <CTableDataCell>{{ user.name }}</CTableDataCell>
                    <CTableDataCell>{{ user.email }}</CTableDataCell>
                    <CTableDataCell>{{ user.created_at }}</CTableDataCell>
                    <CTableDataCell>{{ user.device_id }}</CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
        <div v-else class="text-center mt-2">
            <h6>No hay usuarios registrados</h6>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { getUsers } from '../../services/api/companies-service';

const props = defineProps({
    companyId: {
        type: Number,
        required: true
    }
});

const users = ref([]);

const loadUsers = async (id) => {
    users.value = await getUsers(id);
}

watch(() => props.companyId, async () => {
    await loadUsers(props.companyId);
}, { immediate: true });

</script>

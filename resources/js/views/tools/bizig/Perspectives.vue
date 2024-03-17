<template>
    <CContainer class="mt-2" fluid>
        <PerspectiveDetail />
    </CContainer>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { getUsers } from '../../../services/api/companies-service';
import PerspectiveDetail from '../../../components/tools/bizig/PerspectiveDetail.vue';
import { useUsers } from '../../../store/user';

const store = useUsers();

const perspectives = ref([]);

onMounted(async () => {
    await loadCompanyUsers();
});

const loadCompanyUsers = async () => {
    // get company id from local store
    const companyId = JSON.parse(localStorage.getItem('user')).company_id;
    const response = await getUsers(companyId);

    store.setUsers(response);
}
</script>

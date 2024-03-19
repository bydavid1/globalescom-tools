<template>
    <CContainer class="mt-2 min-vh-100" fluid>
        <div v-if="isLoading" class="text-center mt-5">
            <CSpinner />
        </div>
        <div v-else class="text-center mt-5">
            <PerspectiveDetail v-if="perspectives.length > 0"/>
            <NoPerspectives v-else/>
        </div>
    </CContainer>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { getUsers } from '../../../services/api/companies-service';
import PerspectiveDetail from '../../../components/tools/bizig/PerspectiveDetail.vue';
import { useUsers } from '../../../store/user';
import { usePerspective } from '../../../store/tools/bizig/perspectives';
import NoPerspectives from '../../../components/tools/bizig/NoPerspectives.vue';

const userStore = useUsers();
const perspectiveStore = usePerspective();

onMounted(async () => {
    await loadCompanyUsers();
});

const perspectives = computed(() => perspectiveStore.perspectives);

const isLoading = computed(() => perspectiveStore.loadingPerspectives);

const loadCompanyUsers = async () => {
    // get company id from local store
    const companyId = JSON.parse(localStorage.getItem('user')).company_id;
    const response = await getUsers(companyId);

    userStore.setUsers(response);
}
</script>

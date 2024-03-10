<template>
    <CContainer class="mt-2">
        <CNav variant="tabs">
            <CNavItem
                v-for="perspective in perspectives"
                :key="perspective.id"
            >
                <CNavLink
                    :style="{ backgroundColor: perspective.data.accent_color, color: '#ffffff', cursor: 'pointer' }"
                    :active="perspective.id == route.params.id"
                    @click="choosePerspective(perspective.id)"
                >
                    {{ perspective.name }}
                </CNavLink>
            </CNavItem>
            <CNavItem>
                <CNavLink
                    :style="{ backgroundColor: '#000', color: '#fff', cursor: 'pointer' }"
                    @click="goToDashboard"
                >
                    Dashboard
                </CNavLink>
            </CNavItem>
        </CNav>
        <PerspectiveDetail />
    </CContainer>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { getPerspectives } from '../../../services/api/tools/bizig/perspectives-service';
import { getUsers } from '../../../services/api/companies-service';
import { useRouter, useRoute } from 'vue-router';
import PerspectiveDetail from '../../../components/tools/bizig/PerspectiveDetail.vue';
import { useUsers } from '../../../store/user';

const router = useRouter();
const route = useRoute();

const store = useUsers();

const perspectives = ref([]);

onMounted(async () => {
    await loadPerspectives();
    await loadCompanyUsers();
});

const loadCompanyUsers = async () => {
    // get company id from local store
    const companyId = JSON.parse(localStorage.getItem('user')).company_id;
    const response = await getUsers(companyId);

    store.setUsers(response);
}

const choosePerspective = (id) => {
    router.push({ name: 'perspectiva', params: { id: id } });
}

const loadPerspectives = async () => {
    const response = await getPerspectives();

    perspectives.value = response;
}

const goToDashboard = () => {
    router.push({ path: '/herramientas/bizig/dashboard' });
}
</script>

<template>
    <CContainer class="mt-2 min-vh-100" fluid>
        <div v-if="isLoading" class="text-center mt-5">
            <CSpinner />
        </div>
        <div v-else class="text-center mt-5">
            <PerspectiveDetail v-if="perspectives.length > 0" />
            <NoPerspectives v-else @on-add-click="() => { showNewPerspectiveModal = true }"/>
        </div>
    </CContainer>
    <CModal :visible="showNewPerspectiveModal">
        <CModalHeader>
            <CModalTitle>Nueva perspectiva</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <NewPerspectiveForm @on-save="onNewPerspective"/>
        </CModalBody>
    </CModal>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { getUsers } from '../../../services/api/companies-service';
import { useUsers } from '../../../store/user';
import { usePerspective } from '../../../store/tools/bizig/perspectives';
import { useBizig } from "../../../store/tools/bizig/bizig"
import useUser from "../../../composables/useUserComposable"
import NoPerspectives from '../../../components/tools/bizig/NoPerspectives.vue';
import NewPerspectiveForm from '../../../components/tools/bizig/NewPerspectiveForm.vue';
import PerspectiveDetail from '../../../components/tools/bizig/PerspectiveDetail.vue';

/// Hooks
const userStore = useUsers();
const perspectiveStore = usePerspective();
const bizigStore = useBizig();
const { user } = useUser();

/// Reactive variables
const showNewPerspectiveModal = ref(false);


/// Computed properties
const perspectives = computed(() => perspectiveStore.perspectives);
const isLoading = computed(() => perspectiveStore.loadingPerspectives);
const isAdmin = computed(() => user.value?.role_name === 'admin');
const showAsAdmin = computed(() => bizigStore.showAsAdmin);
const companyId = computed(() => bizigStore.companyId);

/// Lifecycle hooks
onMounted(async () => {
    if (showAsAdmin.value && !isAdmin.value) {
        alert.add({ title: 'No tienes permisos', content: 'No tienes permisos para acceder a esta sección.' })
        router.push({ path: '/' });
        return;
    }

    await loadCompanyUsers();
});


/// Methods
const loadCompanyUsers = async () => {

    if (showAsAdmin.value) {
        const response = await getUsers(companyId.value);
        userStore.setUsers(response);
    } else {
        // get current user company id from local store
        const companyId = JSON.parse(localStorage.getItem('user')).company_id;
        const response = await getUsers(companyId);
        userStore.setUsers(response);
    }

}

const onNewPerspective = () => {
    showNewPerspectiveModal.value = true;
    perspectiveStore.fetchPerspectives();
}
</script>

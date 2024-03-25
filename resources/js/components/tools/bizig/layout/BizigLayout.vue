<template>
    <CRow>
        <CCol sm="auto">
            <CSidebar :visible="true" :unfoldable="false" color-scheme="light" class="h-100">
                <CSidebarNav>
                    <CNavTitle>Bizig</CNavTitle>
                    <CNavItem href="/bizig">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Bizig
                    </CNavItem>
                    <CNavTitle v-if="perspectives.length > 0">Perspectivas</CNavTitle>
                    <CNavItem
                        href="#"
                        v-for="perspective in perspectives"
                        :key="perspective.id"
                        :style="{ color: perspective.data.accent_color }"
                        @click="choosePerspective(perspective.id)"
                    >
                        <CIcon
                            :style="{ color: perspective.data.accent_color }"
                            customClassName="nav-icon"
                            :icon="perspective.data.icon || 'cil-puzzle'"
                        />
                        {{ perspective.name }}
                    </CNavItem>
                    <CNavItem v-if="!isAdmin" href="#" @click="() => showNewPerspectiveModal = true">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Crear perspectiva
                    </CNavItem>
                    <CNavTitle v-if="perspectives.length > 0">Resumen</CNavTitle>
                    <CNavItem v-if="perspectives.length > 0" href="#" @click="goToDashboard">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Dashboard
                    </CNavItem>
                    <CNavTitle v-if="isAdmin">Administración</CNavTitle>
                    <CNavItem v-if="isAdmin" href="/bizig/admin">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Administración
                    </CNavItem>
                </CSidebarNav>
            </CSidebar>
        </CCol>
        <CCol>
            <div class="body flex-grow-1 px-3">
                <router-view />
            </div>
        </CCol>
    </CRow>
    <CContainer class="text-center my-5">
        <hr />
        © Todos los Derechos Reservados y Autor 2024, exclusivos de Global Escom - Social Audit, Training &
        Innovation Consulting. <br>
        Se prohíbe desbloquear, transferir, usar, copiar, fotografiar y reproducir parcial o total el contenido sin
        la previa autorización. <br>
        Metodología de trabajo bajo la metodología de BIZIG.
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
import { computed, onMounted, ref, watch } from "vue";
import { useCompany } from "../../../../store/company";
import { usePerspective } from "../../../../store/tools/bizig/perspectives";
import { useBizig } from "../../../../store/tools/bizig/bizig";
import { useAlerts } from "../../../../store/alert";
import { useRouter, useRoute } from "vue-router";
import useUser from "../../../../composables/useUserComposable"
import NewPerspectiveForm from "../../../../components/tools/bizig/NewPerspectiveForm.vue";

/// Hooks
const companyStore = useCompany();
const perspectiveStore = usePerspective();
const bizigStore = useBizig();
const alert = useAlerts();
const { user } = useUser();
const router = useRouter();
const route = useRoute();


/// Reactive variables
const showNewPerspectiveModal = ref(false);


/// Computed
const showAsAdmin = computed(() => bizigStore.showAsAdmin);
const companyId = computed(() => bizigStore.companyId);
const perspectives = computed(() => perspectiveStore.perspectives);
const isAdmin = computed(() => user.value?.role_name === 'admin');

/// Lifecycle hooks
onMounted(async () => {
    if (showAsAdmin.value && !isAdmin.value) {
        alert.add({ title: 'No tienes permisos', content: 'No tienes permisos para acceder a esta sección.' })
        router.push({ path: '/' });
        return;
    }

    await loadPerspectives();
    await loadCompanyInfo();
});


/// Methods
const loadCompanyInfo = async () => {
    try {
        if (showAsAdmin.value) {
            await companyStore.fetchCompanyInfo(companyId.value)
        } else {
            await companyStore.fetchMyCompanyInfo()
        }

        alert.add({ title: 'Información de la empresa cargada', content: 'Se ha cargado la información de la empresa.' })
    } catch (error) {
        console.log(error)
        alert.add({ title: 'No se puede cargar la información de la empresa', content: 'Puede que no haya información de la empresa o que no se pueda cargar la información de la empresa.' })
    }
}

const loadPerspectives = async () => {
    try {
        perspectiveStore.loadingPerspectives = true
        await perspectiveStore.fetchPerspectives(companyId.value)
        alert.add({ title: 'Perspectivas cargadas', content: 'Se han cargado las perspectivas.' })
    } catch (error) {
        console.log(error)
        alert.add({ title: 'No se pueden cargar las perspectivas', content: 'Puede que no haya perspectivas asociadas a la empresa o que no se puedan cargar las perspectivas.' })
    } finally {
        perspectiveStore.loadingPerspectives = false
    }
}

const choosePerspective = (id) => {
    if (showAsAdmin.value) {
        router.push({ name: 'Perspectiva', query: { id: id, asAdmin: 'true', companyId: companyId.value } });
        return;
    }

    router.push({ name: 'Perspectiva', query: { id: id } });
}

const goToDashboard = () => {
    if (showAsAdmin.value) {
        router.push({ name: 'Dashboard', query: { asAdmin: 'true', companyId: companyId.value } });
        return;
    }

    router.push({ name: 'Dashboard' });
}

const onNewPerspective = () => {
    if (showAsAdmin.value) {
        alert.add({ title: 'No se puede crear perspectiva', content: 'No se puede crear perspectiva en modo administrador.' })
        return;
    }

    showNewPerspectiveModal.value = false;
    perspectiveStore.fetchPerspectives();
}


/// Watchers
watch(() => route.query, async () => {
    const { query } = route;

    if (query && query.asAdmin === 'true' && query.companyId) {
        bizigStore.showAsAdmin = true;
        bizigStore.companyId = query.companyId;
    }
}, { immediate: true });
</script>

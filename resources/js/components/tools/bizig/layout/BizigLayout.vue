<template>
    <CRow>
        <CCol sm="auto">
            <CSidebar :visible="true" :unfoldable="false" color-scheme="light" class="h-100">
                <CSidebarNav>
                    <CNavTitle>Perspectivas</CNavTitle>
                    <CNavItem
                        href="#"
                        v-for="perspective in perspectives"
                        :key="perspective.id"
                        :style="{ color: perspective.data.accent_color }"
                        @click="choosePerspective(perspective.id)"
                    >
                        <CIcon customClassName="nav-icon" icon="cil-puzzle" /> {{ perspective.name }}
                    </CNavItem>
                    <CNavItem v-if="perspectives.lenght > 0" href="#" @click="goToDashboard">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Dashboard
                    </CNavItem>
                    <CNavItem href="#" @click="() => showNewPerspectiveModal = true">
                        <CIcon customClassName="nav-icon" icon="cil-speedometer" /> Crear perspectiva
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
import { computed, onMounted, ref } from "vue";
import { useCompany } from "../../../../store/company";
import { usePerspective } from "../../../../store/tools/bizig/perspectives";
import { useAlerts } from "../../../../store/alert";
import { useRouter, useRoute } from "vue-router";
import NewPerspectiveForm from "../../../../components/tools/bizig/NewPerspectiveForm.vue";

const companyStore = useCompany();
const perspectiveStore = usePerspective();
const alert = useAlerts();

const router = useRouter();
const route = useRoute();

const showNewPerspectiveModal = ref(false);

const perspectives = computed(() => perspectiveStore.perspectives);

onMounted(async () => {
    await loadPerspectives();
    await loadMyCompanyInfo();
});

const loadMyCompanyInfo = async () => {
    try {
        await companyStore.fetchCompanyInfo()
        alert.add({ title: 'Información de la empresa cargada', content: 'Se ha cargado la información de la empresa.' })
    } catch (error) {
        alert.add({ title: 'No se puede cargar la información de la empresa', content: 'Puede que no esté asociado a ninguna empresa o que no se pueda cargar la información de la empresa.' })
    }
}

const loadPerspectives = async () => {
    try {
        perspectiveStore.loadingPerspectives = true
        await perspectiveStore.fetchPerspectives()
        alert.add({ title: 'Perspectivas cargadas', content: 'Se han cargado las perspectivas.' })
    } catch (error) {
        alert.add({ title: 'No se pueden cargar las perspectivas', content: 'Puede que no haya perspectivas asociadas a la empresa o que no se puedan cargar las perspectivas.' })
    } finally {
        perspectiveStore.loadingPerspectives = false
    }
}

const choosePerspective = (id) => {
    router.push({ name: 'Perspectiva', params: { id: id } });
}

const goToDashboard = () => {
    router.push({ path: '/bizig/dashboard' });
}

const onNewPerspective = () => {
    showNewPerspectiveModal.value = false;
    perspectiveStore.fetchPerspectives();
}

</script>

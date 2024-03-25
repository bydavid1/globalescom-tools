<template>
    <CContainer class="text-center mt-5 rounded-2 py-1"
        :style="{ backgroundColor: perspective.data?.accent_color, color: '#fff' }">
        <span class="h5">{{ perspective.name }}</span>
    </CContainer>
    <CContainer class="my-4">
        <CRow class="justify-content-between align-items-center">
            <CCol xs="2">
                <CImage src="/assets/logos/GLOBAL_ESCOM.png" width="140" />
            </CCol>
            <CCol xs="6" class="text-center">
                Metas de Inteligencia de Negocios de Global Escom ● BIZIG 2024 <br>
                <strong>Global Escom, Social Audit • Training • Innovation Consulting.</strong>
            </CCol>
            <CCol xs="2">
                <CImage src="/assets/logos/BIZIG.png" width="130" />
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="text-start my-5">
        <div class="d-flex align-items-center mb-4">
            <CIcon icon="cil-puzzle" size="lg" class="me-2" />
            <h4>Bigs</h4>
        </div>
        <CAlert v-if="showAsAdmin && perspective.bigs?.length === 0" color="info">
            La empresa no ha agregado bigs.
        </CAlert>
        <PerspectivaTable v-for="(item, index) in perspective.bigs" :loading="isLoading" :key="index" :section="item"
            :form="perspective.form" class="mb-3" />
        <div v-if="perspective.bigs?.length < 3 && !showAsAdmin" class="d-grid gap-2 col-6 mx-auto mt-5">
            <CButton v-if="!showAddBigForm" color="secondary" variant="outline" @click="() => showAddBigForm = true">
                Agregar big</CButton>
            <CFormInput v-else v-model="newBigInput" placeholder="Nombre de la big"
                @keydown.esc="() => showAddBigForm = false" @keydown.enter="addNewBig" />
        </div>
    </CContainer>
    <CContainer class="text-start my-5">
        <div class="d-flex align-items-center mb-4">
            <CIcon icon="cil-puzzle" size="lg" class="me-2" />
            <h4>Iniciativas</h4>
        </div>
        <CAlert v-if="showAsAdmin && perspective.initiatives?.length === 0" color="info">
            La empresa no ha agregado iniciativas.
        </CAlert>
        <PerspectivaTable v-for="(item, index) in perspective.initiatives" :loading="isLoading" :key="index"
            :section="item" :form="perspective.form" class="mb-3" />
        <div v-if="perspective.initiatives?.length < 3 && !showAsAdmin" class="d-grid gap-2 col-6 mx-auto mt-5">
            <CButton v-if="!showAddInitiativeForm" color="secondary" variant="outline"
                @click="() => showAddInitiativeForm = true">Agregar iniciativa</CButton>
            <CFormInput v-else v-model="newInitiativeInput" placeholder="Nombre de la big"
                @keydown.esc="() => showAddInitiativeForm = false" @keydown.enter="addNewInitiative" />
        </div>
    </CContainer>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import PerspectivaTable from './PerspectivaTable.vue';
import { getPerspective } from '../../../services/api/tools/bizig/perspectives-service';
import { useRoute } from 'vue-router';
import { useAlerts } from '../../../store/alert';
import { useBizig } from "../../../store/tools/bizig/bizig"
import { createBig } from '../../../services/api/tools/bizig/big-service';
import { createInitiative } from '../../../services/api/tools/bizig/initiative-service';

/// Hooks
const route = useRoute();
const alert = useAlerts();
const bizigStore = useBizig();

/// Reactive variables
const isLoading = ref(false);
const perspective = ref({});

const showAddBigForm = ref(false);
const showAddInitiativeForm = ref(false);

const newBigInput = ref('');
const newInitiativeInput = ref('');


/// Computed properties
const showAsAdmin = computed(() => bizigStore.showAsAdmin);


/// Methods
const loadPerspective = async (id) => {
    isLoading.value = true;
    const response = await getPerspective(id);
    perspective.value = response;
    isLoading.value = false;
}

const addNewBig = async () => {
    try {
        if (!newBigInput.value) return;

        await createBig({
            name: newBigInput.value,
            parent_id: perspective.value.id
        });

        await loadPerspective(perspective.value.id);
    } catch (error) {
        alert.add({ title: 'Error', content: 'Ocurrió un error al agregar la big' });
    } finally {
        newBigInput.value = '';
        showAddBigForm.value = false;
    }
}

const addNewInitiative = async () => {
    try {
        if (!newInitiativeInput.value) return;

        await createInitiative({
            name: newInitiativeInput.value,
            parent_id: perspective.value.id
        });

        await loadPerspective(perspective.value.id);
    } catch (error) {
        alert.add({ title: 'Error', content: 'Ocurrió un error al agregar la iniciativa' });
    } finally {
        newInitiativeInput.value = '';
        showAddInitiativeForm.value = false;
    }
}


/// Watchers
watch(() => route.query.id, async () => {
    await loadPerspective(route.query.id);
}, { immediate: true });
</script>

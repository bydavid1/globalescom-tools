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
            <CIcon icon="cil-puzzle" size="lg" class="me-2"/>
            <h4>Bigs</h4>
        </div>
        <PerspectivaTable v-for="(item, index) in perspective.bigs" :loading="isLoading" :key="index" :section="item"
            :form="perspective.form" class="mb-3" />
        <div class="d-grid gap-2 col-6 mx-auto mt-5">
            <CButton color="secondary" variant="outline">Agregar big</CButton>
        </div>
    </CContainer>
    <CContainer class="text-start my-5">
        <div class="d-flex align-items-center mb-4">
            <CIcon icon="cil-puzzle" size="lg" class="me-2" />
            <h4>Iniciativas</h4>
        </div>
        <PerspectivaTable v-for="(item, index) in perspective.initiatives" :loading="isLoading" :key="index"
            :section="item" :form="perspective.form" class="mb-3" />
        <div class="d-grid gap-2 col-6 mx-auto mt-5">
            <CButton color="secondary" variant="outline">Agregar big</CButton>
        </div>
    </CContainer>
</template>

<script setup>
import { ref, watch } from 'vue';
import PerspectivaTable from './PerspectivaTable.vue';
import { getPerspective } from '../../../services/api/tools/bizig/perspectives-service';
import { useRoute } from 'vue-router';

const route = useRoute();

const isLoading = ref(false);
const perspective = ref({});

const loadPerspective = async (id) => {
    isLoading.value = true;
    const response = await getPerspective(id);
    perspective.value = response;
    isLoading.value = false;
}

watch(() => route.params.id, async () => {
    await loadPerspective(route.params.id);
}, { immediate: true });
</script>

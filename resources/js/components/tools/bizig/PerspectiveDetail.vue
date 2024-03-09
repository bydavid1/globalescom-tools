
<template>
    <CContainer class="text-center mt-5 rounded-2 py-1" :style="{backgroundColor: perspective.data?.accent_color, color: '#fff'}">
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
                <strong>Nombre de los Responsables:</strong> Ernesto Chíchique.
            </CCol>
            <CCol xs="2">
                <CImage src="/assets/logos/BIZIG.png" width="130" />
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="mt-5">
        <PerspectivaTable
            v-for="(item, index) in perspective.children"
            :key="index"
            :section="item"
            :form="perspective.form"
            :answer-batches="getAnswerBatches(item.id)"
            class="mb-3"
        />
    </CContainer>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import PerspectivaTable from './PerspectivaTable.vue';
import { getPerspective } from '../../../services/api/tools/bizig/perspectives-service';
import { useRoute } from 'vue-router';

const route = useRoute();

const perspective = ref({});

const loadPerspective = async (id) => {
    const response = await getPerspective(id);
    perspective.value = response;
}

const getAnswerBatches = (sectionId) => {
    return perspective.value.answers_batches.filter(b => b.section_id == sectionId);
}

watch(() => route.params.id, async () => {
    await loadPerspective(route.params.id);
}, { immediate: true });
</script>

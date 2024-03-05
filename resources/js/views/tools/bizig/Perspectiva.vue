
<template>
    <CContainer class="text-center mt-5">
        <span class="h5">{{ perspective.name }}</span>
    </CContainer>
    <CContainer class="mt-5">
        <PerspectivaTable
            v-for="(item, index) in perspective.children"
            :key="index" :section="item"
            :form="perspective.form"
            :answer-batches="perspective.answers_batches.filter(b => b.section_id == item.id)"
            class="mb-3"
        />
    </CContainer>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import PerspectivaTable from '../../../components/tools/bizig/PerspectivaTable.vue';
import perspectivesService from '../../../services/tools/bizig/perspectives-service';

const perspective = ref({});

onMounted(() => {
    loadPerspective();
});

const loadPerspective = async () => {
    const response = await perspectivesService.getPerspective(1);

    perspective.value = response;
}
</script>

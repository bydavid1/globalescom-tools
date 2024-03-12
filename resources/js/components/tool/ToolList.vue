<template>
    <CCard v-for="tool in tools" :key="tool.id" @click="goToTool(tool.name)" class="tool-card">
        <CCardImage orientation="top" src="/assets/logos/BIZIG.png" />
        <CCardBody>
            <CCardTitle>{{ tool.name }}</CCardTitle>
        </CCardBody>
    </CCard>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { getTools } from '../../services/api/tools-service';

const router = useRouter();

const tools = ref([]);

onMounted(async () => {
    try {
        tools.value = await getTools();
    } catch (error) {
        console.error('Failed to load tools:', error);
    }
});

const goToTool = (toolName) => {
    router.push({ path: `/herramientas/${toolName.toLowerCase()}` });
};
</script>

<template>
    <div>
        <h3>Welcome to the Home view!</h3>
        <div class="mt-3">
            <CCard v-for="tool in tools" :key="tool.id" @click="goToTool(tool.name)" class="tool-card">
                <CCardImage orientation="top" src="https://coreui.io/demos/vue/4.0/free/img/vue.24fc173a.jpg" />
                <CCardBody>
                    <CCardTitle>{{ tool.name }}</CCardTitle>
                </CCardBody>
            </CCard>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getTools } from '../services/api/tools-service';
import { useRouter } from 'vue-router';

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

<style>
    .tool-card {
        width: 18rem;
        cursor: pointer;
    }
</style>

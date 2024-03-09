<template>
    <div>
        <h1>Welcome to the Home view!</h1>
        <ul>
            <li v-for="tool in tools" :key="tool.id">{{ tool.name }}</li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getTools } from '../services/api/tools-service';

const tools = ref([]);

onMounted(async () => {
    try {
        tools.value = await getTools();
    } catch (error) {
        console.error('Failed to load tools:', error);
    }
});
</script>

<style scoped>
h1 {
    color: #333;
}
ul {
    list-style-type: none;
    padding: 0;
}
li {
    margin-bottom: 10px;
}
</style>

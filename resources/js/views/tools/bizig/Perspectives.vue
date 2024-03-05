<template>
    <CContainer class="mt-2">
        <CNav variant="tabs">
            <CNavItem
                v-for="perspective in perspectives"
                :key="perspective.id"
            >
                <CNavLink
                    href="#"
                    :active="perspective.id == route.params.id"
                    @click="choosePerspective(perspective.id)"
                >
                    {{ perspective.name }}
                </CNavLink>
            </CNavItem>
        </CNav>
        <PerspectiveDetail />
    </CContainer>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { getPerspectives } from '../../../services/tools/bizig/perspectives-service';
import { useRouter, useRoute } from 'vue-router';
import PerspectiveDetail from '../../../components/tools/bizig/PerspectiveDetail.vue';

const router = useRouter();
const route = useRoute();

const perspectives = ref([]);

onMounted(async () => {
    await loadPerspectives();

});

const choosePerspective = (id) => {
    router.push({ name: 'perspectiva', params: { id: id } });
}

const loadPerspectives = async () => {
    const response = await getPerspectives();

    perspectives.value = response;
}
</script>./PerspectiveDetail.vue

<template>
    <CContainer class="my-4">
        <CRow class="justify-content-between align-items-center">
            <CCol xs="2">
                <CImage src="/assets/logos/BIZIG.png" width="130" />
            </CCol>
            <CCol xs="10" class="bg-black text-white rounded-1 d-flex align-items-center justify-content-center"
                style="height: 3rem;">
                <span class="h5">Metas de Inteligencia de Negocios de Global Escom ● BIZIG 2024.</span>
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="my-1 text-center">
        <h4>Global Escom, Social Audit • Training • Innovation Consulting.</h4>
    </CContainer>
    <CContainer fluid>
        <CRow class="mb-4" :xs="{ gutter: 1 }">
            <CCol xs="2">
                <CContainer class="text-center mt-5 rounded-2 bg-black text-white py-1">
                    PERSPECTIVAS:
                </CContainer>
            </CCol>
            <CCol xs="4">
                <CContainer class="text-center mt-5 rounded-2 bg-black text-white py-1">
                    BIG - BUSINESS INTELLIGENCE GOALS:
                </CContainer>
            </CCol>
            <CCol xs="4">
                <CContainer class="text-center mt-5 rounded-2 bg-black text-white py-1">
                    INICIATIVAS:
                </CContainer>
            </CCol>
            <CCol xs="2">
                <CContainer class="text-center mt-5 rounded-2 bg-black text-white py-1">
                    CUMPLIMIENTO:
                </CContainer>
            </CCol>
        </CRow>
        <CRow v-for="(item, i) in perspectives" :xs="{ gutter: 1 }" :key="i" style="font-size: 12px;" class="mt-2">
            <CCol xs="2">
                <CCard
                    style="min-height: 9rem; width: 9rem; display: flex; justify-content: center; align-items: center;"
                    :style="{ backgroundColor: item.data?.accent_color, color: '#fff' }">
                    <CCardBody class="p-2">
                        {{ item.name }}
                    </CCardBody>
                </CCard>
            </CCol>
            <CCol xs="4">
                <CRow :xs="{ gutter: 1 }">
                    <CCol v-for="(big, j) in item.bigs" :key="j">
                        <CCard style="min-height: 9rem; width: 9rem;" :class="`bg-${getColor(big.progress)}`"
                            class="text-white">
                            <CCardBody>
                                {{ big.name }}
                            </CCardBody>
                        </CCard>
                    </CCol>
                </CRow>
            </CCol>
            <CCol xs="4">
                <CRow :xs="{ gutter: 1 }">
                    <CCol v-for="(iniciative, j) in item.initiatives" :key="j">
                        <CCard style="min-height: 9rem; width: 9rem;" :class="`bg-${getColor(iniciative.progress)}`"
                            class="text-white">
                            <CCardBody>
                                {{ iniciative.name }}
                            </CCardBody>
                        </CCard>
                    </CCol>
                </CRow>
            </CCol>
            <CCol xs="2">
                <CCard style="height: 8rem; width: 8rem;" :class="`bg-${getColor(item.progress)} text-white p-3`">
                    <div class="text-end text-medium-emphasis-inverse">
                        <CIcon icon="cil-speedometer" height="30" />
                    </div>
                    <div class="fs-4 fw-semibold">{{ item.progress }}%</div>
                    <div class="text-uppercase fw-semibold small text-medium-emphasis-inverse mb-1">Avance</div>
                    <CProgress>
                        <CProgressBar :value="item.progress" color="light" style="height: 4px;" />
                    </CProgress>
                </CCard>
            </CCol>
        </CRow>
        <CRow :xs="{ gutter: 1 }" class="align-items-center mt-4">
            <CCol xs="10" class="text-end pe-5" style="height: 2rem;">
                <span class="h5">Promedio global de cumplimiento de Global Escom®:</span>
            </CCol>
            <CCol xs="2">
                <CCard style="height: 8rem; width: 8rem;" :class="`bg-${getColor(globalProgress)} text-white p-3`">
                    <div class="text-end text-medium-emphasis-inverse">
                        <CIcon icon="cil-speedometer" height="30" />
                    </div>
                    <div class="fs-4 fw-semibold">{{ globalProgress }}%</div>
                    <div class="text-uppercase fw-semibold small text-medium-emphasis-inverse mb-1">Avance</div>
                    <CProgress style="height: 4px;">
                        <CProgressBar :value="globalProgress" color="light" />
                    </CProgress>
                </CCard>
            </CCol>
        </CRow>
    </CContainer>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { loadDashboard } from '../../../services/api/tools/bizig/dashboard-service';
import { useRoute } from 'vue-router';

const route = useRoute();

const perspectives = ref([]);
const globalProgress = ref(0);

onMounted(async () => {

    if (route.params.companyId && !isUserAdmin) {
        router.push({ name: 'home' });
    }

    await getData();
});

const isUserAdmin = () => JSON.parse(localStorage.getItem('user')).role_name === 'admin';

const getData = async () => {
    const response = await loadDashboard(route.params.companyId ?? null);
    perspectives.value = response.perspectives;
    globalProgress.value = response.global_progress;
}

function getColor(progress) {
    if (progress < 20) {
        return 'danger';
    } else if (progress >= 20 && progress <= 50) {
        return 'warning';
    } else {
        return 'success';
    }
}
</script>

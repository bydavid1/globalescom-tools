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
    <CContainer class="my-2 text-center">
        Global Escom, Social Audit • Training • Innovation Consulting.
    </CContainer>
    <CRow v-for="(item, i) in perspectives" :xs="{ gutter: 3 }" :key="i" style="font-size: 12px;" class="mt-2">
        <CCol xs="2">
            <CCard style="height: 8rem; width: 8rem;">
                <CCardBody class="p-2">
                    {{ item.name }}
                </CCardBody>
            </CCard>
        </CCol>
        <CCol xs="4">
            <CRow :xs="{ gutter: 1 }">
                <CCol v-for="(big, j) in item.bigs" :key="j">
                    <CCard style="height: 8rem; width: 8rem;" :class="`bg-${getColor(big.progress)}`"
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
                <CCol v-for="(iniciative, j) in item.iniciatives" :key="j">
                    <CCard style="height: 8rem; width: 8rem;" :class="`bg-${getColor(iniciative.progress)}`"
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
                    <CProgressBar :value="item.progress" color="light" style="height: 4px;"/>
                </CProgress>
            </CCard>
        </CCol>
    </CRow>
    <CContainer class="my-4">
        <CRow class="justify-content-end align-items-center">
            <CCol xs="4" class="d-flex align-items-center justify-content-end"
                style="height: 2rem;">
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
                        <CProgressBar :value="globalProgress" color="light"/>
                    </CProgress>
                </CCard>
            </CCol>
        </CRow>
    </CContainer>
</template>

<script setup>
import { CCol } from '@coreui/vue';
import { computed, reactive } from 'vue';


const perspectives = reactive([
    {
        name: 'Gestión del Talento y Capital Humano.',
        bigs: [
            {
                name: 'Atracción y Retención del Talento.',
                progress: 0,
            },
            {
                name: 'Desarrollo y Capacitación del Talento.',
                progress: 30,
            },
            {
                name: 'Clima y Cultura Organizacional.',
                progress: 70,
            }
        ],
        iniciatives: [
            {
                name: 'Implementación de un Programa de Capacitación.',
                progress: 70,
            },
            {
                name: 'Implementación de un Programa de Clima y Cultura Organizacional.',
                progress: 10,
            },
            {
                name: 'Implementación de un Programa de Atracción y Retención del Talento.',
                progress: 50,
            }
        ],
        progress: 10,
    },
    {
        name: 'Gestión de la Innovación y el Conocimiento.',
        bigs: [
            {
                name: 'Gestión del Conocimiento.',
                progress: 0,
            },
            {
                name: 'Gestión de la Innovación.',
                progress: 30,
            },
            {
                name: 'Gestión de la Tecnología.',
                progress: 70,
            }
        ],
        iniciatives: [
            {
                name: 'Implementación de un Programa de Gestión del Conocimiento.',
                progress: 70,
            },
            {
                name: 'Implementación de un Programa de Gestión de la Innovación.',
                progress: 10,
            },
            {
                name: 'Implementación de un Programa de Gestión de la Tecnología.',
                progress: 50,
            }
        ],
        progress: 40,
    },
    {
        name: 'Gestión de la Calidad y la Excelencia.',
        bigs: [
            {
                name: 'Gestión de la Calidad.',
                progress: 0,
            },
            {
                name: 'Gestión de la Excelencia.',
                progress: 30,
            },
            {
                name: 'Gestión de la Sostenibilidad.',
                progress: 70,
            }
        ],
        iniciatives: [
            {
                name: 'Implementación de un Programa de Gestión de la Calidad.',
                progress: 70,
            },
            {
                name: 'Implementación de un Programa de Gestión de la Excelencia.',
                progress: 10,
            },
            {
                name: 'Implementación de un Programa de Gestión de la Sostenibilidad.',
                progress: 50,
            }
        ],
        progress: 70,
    },
]);

const globalProgress = computed(() => {
    return perspectives.reduce((acc, perspective) => acc + perspective.progress, 0) / perspectives.length;
});

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

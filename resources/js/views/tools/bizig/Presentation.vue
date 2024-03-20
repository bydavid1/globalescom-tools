<template>
    <CContainer v-if="isAdmin" class="my-4">
        <CRow class="justify-content-end">
            <CCol xs="2">
                <router-link to="/bizig/admin" class="btn btn-outline-secondary">
                    <CIcon icon="cilSettings" size="sm" class="me-1"/>
                    Administración
                </router-link>
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="my-4">
        <CRow class="justify-content-between align-items-center">
            <CCol xs="2">
                <CImage :src="company?.logo || '/assets/logos/GLOBAL_ESCOM.png'" width="140" />
            </CCol>
            <CCol xs="2">
                <CImage src="/assets/logos/BIZIG.png" width="130" />
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="text-center mt-5 rounded-2 bg-black text-white py-1">
        <span class="h5">Metas de Inteligencia de Negocios de Global Escom ● BIZIG 2024.</span>
    </CContainer>
    <CContainer class="mt-5">
        <CRow>
            <CCol sm="6">
                <CCard>
                    <CCardHeader class="bg-black text-white">Misión o propósito de Global Escom®.</CCardHeader>
                    <CCardBody>
                        Promovemos la mejora continua, a través de la genialidad y excelencia del capital humano, para
                        lograr la productividad en la cultura organizacional.
                    </CCardBody>
                </CCard>
            </CCol>
            <CCol sm="6">
                <CCard>
                    <CCardHeader class="bg-black text-white">Visión de Global Escom®.</CCardHeader>
                    <CCardBody>
                        Seremos su aliado estratégico en la transformación organizacional; a través de experiencias
                        innovadoras para facultar al capital humano.
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="mt-5">
        <CTable class="rounded-2" bordered>
            <CTableHead class="rounded-2">
                <CTableRow class="rounded-2">
                    <CTableHeaderCell class="bg-black text-white" scope="col">Valores</CTableHeaderCell>
                    <CTableHeaderCell class="bg-black text-white">Conductas y creencias de Global Escom®.
                    </CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow>
                    <CTableDataCell><strong>Excelencia:</strong></CTableDataCell>
                    <CTableDataCell>
                        Buscamos constantemente ser una solución eficiente y eficaz, para apoyar a nuestros clientes;
                        basándonos en la mejora continua y la calidad integral.
                    </CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell><strong>Pasión:</strong></CTableDataCell>
                    <CTableDataCell>Demostrar el estado coherente de excelencia frente a nuestros clientes; ofreciendo
                        soluciones y alternativas que logren satisfacer y superar sus expectativas.</CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell><strong>Innovación:</strong></CTableDataCell>
                    <CTableDataCell>Dentro del desarrollo de nuestros servicios profesionales, implantamos e
                        implementamos técnicas y metodologías, centradas en la generación de valor a nuestros clientes.
                    </CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell><strong>Coherencia:</strong></CTableDataCell>
                    <CTableDataCell>Nos conducimos bajo la premisa: pensar, sentir, decir y actuar de forma integral;
                        conectamos con el desarrollo cognitivo, físico y espiritual del ser humano.</CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell><strong>Optimismo:</strong></CTableDataCell>
                    <CTableDataCell>Somos felices creando experiencias de aprendizaje y nos caracterizamos por reconocer
                        la genialidad, creatividad y excelencia de las personas, equipos y organizaciones.
                    </CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CContainer>
    <CContainer v-if="!isAdmin" class="text-center mt-5">
        <router-link to="/bizig/perspectivas/1" class="btn btn-primary btn-lg">Ver
            progreso</router-link><br>
    </CContainer>
</template>


<script setup>
import { computed } from 'vue';
import useUser from '../../../composables/useUserComposable';
import { useCompany } from '../../../store/company';

const store = useCompany();
const { user } = useUser();

const company = store.company;

const isAdmin = computed(() => user.value?.role_name === 'admin');
</script>

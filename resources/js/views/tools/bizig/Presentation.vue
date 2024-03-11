<template>
    <CContainer class="my-4">
        <CRow class="justify-content-between align-items-center">
            <CCol xs="2">
                <CImage :src="company?.logo" width="140" />
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
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe corporis tenetur dolorum est
                        asperiores veritatis praesentium quibusdam molestias nisi cum laudantium optio animi, sapiente
                        aut illo soluta delectus sed. Molestiae?
                    </CCardBody>
                </CCard>
            </CCol>
            <CCol sm="6">
                <CCard>
                    <CCardHeader class="bg-black text-white">Visión de Global Escom®.</CCardHeader>
                    <CCardBody>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tenetur ratione facere possimus ipsam
                        soluta dignissimos provident aut, voluptate ullam quod consequatur voluptatem iusto
                        reprehenderit sequi repudiandae quisquam, voluptas, unde quo.
                    </CCardBody>
                </CCard>
            </CCol>
        </CRow>
    </CContainer>
    <CContainer class="mt-5">
        <CTable bordered>
            <CTableHead>
                <CTableRow class="bg-black">
                    <CTableHeaderCell scope="col">Valores</CTableHeaderCell>
                    <CTableHeaderCell scope="col">Conductas y creencias de Global Escom®.</CTableHeaderCell>
                </CTableRow>
            </CTableHead>
            <CTableBody>
                <CTableRow>
                    <CTableDataCell></CTableDataCell>
                    <CTableDataCell></CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell></CTableDataCell>
                    <CTableDataCell></CTableDataCell>
                </CTableRow>
                <CTableRow>
                    <CTableDataCell></CTableDataCell>
                    <CTableDataCell></CTableDataCell>
                </CTableRow>
            </CTableBody>
        </CTable>
    </CContainer>
    <CContainer class="text-center">
        <router-link to="/herramientas/bizig/perspectivas/1" class="btn btn-secondary">Ver progreso</router-link><br>
    </CContainer>
</template>


<script setup>
import { onMounted, ref } from 'vue';
import { getMyCompany } from '../../../services/api/companies-service';
import { useAlerts } from '../../../store/alert'

const alert = useAlerts();

const company = ref(null);

onMounted(() => {
    loadMyCompanyInfo();
});

const loadMyCompanyInfo = async () => {
    try {
        const response = await getMyCompany();
        company.value = response.data;
        alert.add({ title: 'Información de la empresa cargada', content: 'Se ha cargado la información de la empresa.'})
    } catch (error) {
        alert.add({ title: 'No se puede cargar la información de la empresa', content: 'Puede que no esté asociado a ninguna empresa o que no se pueda cargar la información de la empresa.'})
    }
}
</script>

<template>
    <div>
        <h1>Empressas</h1>
        <CCard>
            <CCardHeader>
                <CRow>
                    <CCol>
                        <h2 class="card-title">Empresas</h2>
                    </CCol>
                    <CCol class="text-end">
                        <CButton to="/empresas/nueva" color="primary">Nueva Empresa</CButton>
                    </CCol>
                </CRow>
            </CCardHeader>
            <CCardBody>
                <CTable>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">ID</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Nombre</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Usuario</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Acciones</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-for="company in companies" :key="company.id">
                            <CTableDataCell>{{ company.id }}</CTableDataCell>
                            <CTableDataCell>{{ company.name }}</CTableDataCell>
                            <CTableDataCell>{{ company.user }}</CTableDataCell>
                            <CTableDataCell>
                                <CButton color="primary" to="/company/edit">Editar</CButton>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </CCardBody>
        </CCard>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { getCompanies } from '../../services/api/companies-service';

const companies = ref([]);

onMounted(async () => {
    await loadCompanies();
});

const loadCompanies = async () => {
    companies.value = await getCompanies();
}
</script>

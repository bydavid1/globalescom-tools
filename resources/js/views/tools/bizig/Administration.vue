<template>
    <div class="min-vh-100">
        <CContainer class="my-4">
        <CRow>
            <CCol>
                <h4>Administración</h4>
            </CCol>
        </CRow>
    </CContainer>
    <CContainer>
        <CCard>
            <CCardHeader>
                <h5>Empresas</h5>
            </CCardHeader>
            <CCardBody>
                <CTable bordered>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell>ID</CTableHeaderCell>
                            <CTableHeaderCell>Empresa</CTableHeaderCell>
                            <CTableHeaderCell>Porcentaje global</CTableHeaderCell>
                            <CTableHeaderCell class="text-end">Acciones</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-for="company in companies" :key="company.id">
                            <CTableDataCell>{{ company.id }}</CTableDataCell>
                            <CTableDataCell>{{ company.name }}</CTableDataCell>
                            <CTableDataCell>{{ company.progress }}%</CTableDataCell>
                            <CTableDataCell class="text-end">
                                <a :href="`/bizig?asAdmin=true&companyId=${company.id}`" class="btn btn-sm btn-success text-white">
                                    Ver Progreso
                                </a>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </CCardBody>
        </CCard>
    </CContainer>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getCompanies } from '../../../services/api/tools/bizig/admin-service'

const companies = ref('')

onMounted(() => {
    loadCompanies()
})

const loadCompanies = async () => {
    const response = await getCompanies()

    companies.value = response
}
</script>

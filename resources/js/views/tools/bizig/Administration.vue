<template>
    <CContainer class="text-center mt-5">
        <span class="h5">Administracion</span>
    </CContainer>
    <CContainer class="mt-5">
        <CCard>
            <CCardHeader>
                Empresas
            </CCardHeader>
            <CCardBody>
                <CTable bordered>
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell>ID</CTableHeaderCell>
                            <CTableHeaderCell>Empresa</CTableHeaderCell>
                            <CTableHeaderCell>Porcentaje global</CTableHeaderCell>
                            <CTableHeaderCell>Acciones</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-for="company in companies" :key="company.id">
                            <CTableDataCell>{{ company.id }}</CTableDataCell>
                            <CTableDataCell>{{ company.name }}</CTableDataCell>
                            <CTableDataCell>{{ company.progress  }}%</CTableDataCell>
                            <CTableDataCell>
                                <CButton color="success" class="me-2">Ver Dashboard</CButton>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </CCardBody>
        </CCard>
    </CContainer>
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

<template>
    <CContainer class="my-4">
        <CRow>
            <CCol>
                <h4>Administracion</h4>
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
                                <router-link
                                    :to="{ name: 'dashboard', params: { companyId: company.id } }"
                                    class="btn btn-sm btn-success text-white"
                                >
                                    Ver Dashboard
                                </router-link>
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

<template>
    <div class="min-vh-100">
        <CContainer class="mt-5">
            <CRow>
                <CCol>
                    <h4>Empresas</h4>
                </CCol>
                <CCol class="text-end">
                    <CButton @click="openCreateModal" size="sm" color="primary">Nueva Empresa</CButton>
                </CCol>
            </CRow>
            <CCard class="mt-3">
                <CCardBody>
                    <CTable v-if="companies.length > 0" small>
                        <CTableHead>
                            <CTableRow>
                                <CTableHeaderCell scope="col">ID</CTableHeaderCell>
                                <CTableHeaderCell scope="col">Nombre</CTableHeaderCell>
                                <CTableHeaderCell scope="col">Email</CTableHeaderCell>
                                <CTableHeaderCell scope="col" class="text-end">Acciones</CTableHeaderCell>
                            </CTableRow>
                        </CTableHead>
                        <CTableBody>
                            <CTableRow v-for="company in companies" :key="company.id">
                                <CTableDataCell>{{ company.id }}</CTableDataCell>
                                <CTableDataCell>{{ company.name }}</CTableDataCell>
                                <CTableDataCell>{{ company.email }}</CTableDataCell>
                                <CTableDataCell class="text-end">
                                    <CDropdown variant="btn-group">
                                        <CDropdownToggle color="secondary" size="sm">Opciones</CDropdownToggle>
                                        <CDropdownMenu>
                                            <CDropdownItem @click="openEditModal(company.id)">Editar</CDropdownItem>
                                            <CDropdownItem @click="openUsersModal(company.id)">Ver Usuarios
                                            </CDropdownItem>
                                            <CDropdownItem @click="openCreateUserModal(company.id)">Nuevo Usuario
                                            </CDropdownItem>
                                        </CDropdownMenu>
                                    </CDropdown>
                                </CTableDataCell>
                            </CTableRow>
                        </CTableBody>
                    </CTable>
                    <div v-else class="text-center mt-2">
                        <h6>No hay empresas registradas</h6>
                    </div>
                </CCardBody>
            </CCard>
        </CContainer>
        <CModal :visible="showUsersModal" size="xl" @close="() => { showUsersModal = false }">
            <CModalBody>
                <ViewUsers :company-id="currentCompanyId" />
            </CModalBody>
        </CModal>
        <CModal :visible="showCreateUserModal" size="lg" @close="() => { showCreateUserModal = false }">
            <CModalBody>
                <AddUser :company-id="currentCompanyId" @onSuccess="closeModals" />
            </CModalBody>
        </CModal>
        <CModal :visible="showCompanyModal" size="lg" @close="() => { showCompanyModal = false }">
            <CModalBody>
                <CreateOrUpdateCompany :is-editing="isEditing" :company-id="currentCompanyId"
                    @onSuccess="closeModals" />
            </CModalBody>
        </CModal>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { getCompanies } from '../../services/api/companies-service';
import ViewUsers from '../../components/company/ViewUsers.vue';
import AddUser from '../../components/company/AddUser.vue';
import CreateOrUpdateCompany from '../../components/company/CreateOrUpdateCompany.vue';

const showCompanyModal = ref(false);
const showUsersModal = ref(false);
const showCreateUserModal = ref(false);

const companies = ref([]);
const currentCompanyId = ref(null);

const isLoading = ref(false);
const isEditing = ref(false);


onMounted(async () => {
    await loadCompanies();
});

const openCreateModal = () => {
    isEditing.value = false;
    showCompanyModal.value = true;
}

const openEditModal = (id) => {
    currentCompanyId.value = id;
    isEditing.value = true;
    showCompanyModal.value = true;
}

const openUsersModal = (id) => {
    currentCompanyId.value = id;
    showUsersModal.value = true;
}

const openCreateUserModal = (id) => {
    currentCompanyId.value = id;
    showCreateUserModal.value = true;
}

const closeModals = () => {
    console.log('closeModals');
    showCompanyModal.value = false;
    showUsersModal.value = false;
    showCreateUserModal.value = false;
    loadCompanies();
}

const loadCompanies = async () => {
    companies.value = await getCompanies();
}
</script>

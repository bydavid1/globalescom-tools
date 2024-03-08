<template>
    <div>
        <CCard>
            <CCardHeader>
                <CRow>
                    <CCol>
                        <h5>Empresas</h5>
                    </CCol>
                    <CCol class="text-end">
                        <CButton @click="openCreateModal" color="primary">Nueva Empresa</CButton>
                    </CCol>
                </CRow>
            </CCardHeader>
            <CCardBody>
                <CTable v-if="companies.length > 0">
                    <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">ID</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Nombre</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Email</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Acciones</CTableHeaderCell>
                        </CTableRow>
                    </CTableHead>
                    <CTableBody>
                        <CTableRow v-for="company in companies" :key="company.id">
                            <CTableDataCell>{{ company.id }}</CTableDataCell>
                            <CTableDataCell>{{ company.name }}</CTableDataCell>
                            <CTableDataCell>{{ company.email }}</CTableDataCell>
                            <CTableDataCell>
                                <CButton @click="openEditModal(company.id)" to="/company/edit">Editar</CButton>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
                <div v-else class="text-center mt-2">
                    <h6>No hay empresas registradas</h6>
                </div>
            </CCardBody>
        </CCard>
        <CModal :visible="showModal" @close="() => { visibleLiveDemo = false }">
            <CModalHeader>
                <CModalTitle>Registrar empresa</CModalTitle>
            </CModalHeader>
            <CModalBody>
                <CForm @submit="sendCompany" class="row gy-3 align-items-center">
                    <CCol xs="12">
                        <CFormLabel for="name">Nombre</CFormLabel>
                        <CFormInput v-model="formState.name" type="text" id="name"
                            placeholder="Ingrese el nombre de la empresa" />
                    </CCol>
                    <CCol xs="12">
                        <CFormLabel for="logo">Logo</CFormLabel>
                        <CFormInput v-on:change="getFileFromInput" type="file" id="logo"
                            placeholder="Suba el logo de la empresa" />
                    </CCol>
                    <CCol xs="12">
                        <CFormLabel for="email">Usuario</CFormLabel>
                        <CFormInput v-model="formState.email" type="text" id="email"
                            placeholder="Ingrese el email de la empresa" />
                    </CCol>
                    <CCol xs="12">
                        <CFormLabel for="password">Contrseña</CFormLabel>
                        <CFormInput v-model="formState.password" type="text" id="password"
                            placeholder="Ingrese la contraseña de la empresa" />
                    </CCol>
                    <CContainer class="mt-4">
                        <button class="btn btn-primary" type="submit">
                            <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <span v-if="isLoading">Guardando...</span>
                            <span v-if="!isLoading">Guardar</span>
                        </button>
                    </CContainer>
                </CForm>
            </CModalBody>
        </CModal>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { getCompanies, saveCompany, updateCompany } from '../../services/api/companies-service';

const companies = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const currentCompanyId = ref(null);
const isLoading = ref(false);

const formState = reactive({
    name: '',
    logo: null,
    user: '',
    password: ''
});

onMounted(async () => {
    await loadCompanies();
});

const openCreateModal = () => {
    showModal.value = true;
}

const openEditModal = (id) => {
    showModal.value = true;
    isEditing.value = true;
    currentCompanyId.value = id;
}

const loadCompanies = async () => {
    companies.value = await getCompanies();
}

const getCompany = async (id) => {
    const result = await getCompany(id);

    formState.name = result.name;
    formState.logo = result.logo;
    formState.user = result.email;
}

const getFileFromInput = (event) => {
    console.log('event', event.target.files[0]);
    formState.logo = event.target.files[0];
}

const sendCompany = async (event) => {
    event.preventDefault();
    isLoading.value = true;
    try {
        // validate form
        if (formState.name === '' || formState.email === '' || formState.password === '') {
            return;
        }

        console.log('formState', formState.logo);

        // create form request
        const formData = new FormData();
        formData.append('name', formState.name);
        formData.append('logo', formState.logo);
        formData.append('email', formState.email);
        formData.append('password', formState.password);

        console.log('formData', formData);

        // send request
        if (isEditing.value) {
            await updateCompany(currentCompanyId.value, formData);
        } else {
            await saveCompany(formData);
        }

        // close modal
        showModal.value = false;
        loadCompanies();
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
}
</script>

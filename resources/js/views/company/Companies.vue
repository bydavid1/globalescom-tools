<template>
    <div>
        <h1>Empresas</h1>
        <CCard>
            <CCardHeader>
                <CRow>
                    <CCol>
                        <h2 class="card-title">Empresas</h2>
                    </CCol>
                    <CCol class="text-end">
                        <CButton @click="openCreateModal" color="primary">Nueva Empresa</CButton>
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
                                <CButton @click="openEditModal(company.id)" to="/company/edit">Editar</CButton>
                            </CTableDataCell>
                        </CTableRow>
                    </CTableBody>
                </CTable>
            </CCardBody>
        </CCard>
        <CModal :visible="showModal" @close="() => { visibleLiveDemo = false }">
            <CModalHeader>
                <CModalTitle>Registrar empresa</CModalTitle>
            </CModalHeader>
            <CModalBody @submit="sendCompany">
                <CForm>
                    <CFormGroup>
                        <CLabel for="name">Nombre</CLabel>
                        <CInput v-model="formState.name" type="text" id="name" />
                    </CFormGroup>
                    <CFormGroup>
                        <CLabel for="name">Logo</CLabel>
                        <CFormInput v-model="formState.logo" type="file" id="logo"/>
                    </CFormGroup>
                    <CFormGroup>
                        <CLabel for="user">Usuario</CLabel>
                        <CInput v-model="formState.user" type="text" id="user" />
                    </CFormGroup>
                    <CFormGroup>
                        <CLabel for="user">Contrasena</CLabel>
                        <CInput v-model="formState.password" type="text" id="password" />
                    </CFormGroup>
                </CForm>
            </CModalBody>
            <CModalFooter>
                <CButton color="secondary" @click="() => { showModal = false }">
                    Cerrar
                </CButton>
                <CButton type="submit" color="primary">Guardar</CButton>
            </CModalFooter>
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
    formState.user = result.user;
}


const sendCompany = async () => {
    // validate form
    if (formState.name === '' || formState.user === '' || formState.password === '') {
        return;
    }

    // create form request
    const formData = new FormData();
    formData.append('name', formState.name);
    formData.append('logo', formState.logo);
    formData.append('user', formState.user);
    formData.append('password', formState.password);

    // send request
    if (isEditing.value) {
        await updateCompany(currentCompanyId.value, formData);
    } else {
        await saveCompany(formData);
    }
}
</script>

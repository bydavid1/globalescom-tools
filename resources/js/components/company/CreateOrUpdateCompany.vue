<template>
    <CForm @submit="sendCompany" class="row gy-3 align-items-center">
        <CCol xs="12">
            <CFormLabel for="name">Nombre</CFormLabel>
            <CFormInput v-model="formState.name" type="text" id="name" placeholder="Ingrese el nombre de la empresa" />
        </CCol>
        <CCol xs="12">
            <CFormLabel for="logo">Logo</CFormLabel>
            <CFormInput v-on:change="getFileFromInput" type="file" id="logo" placeholder="Suba el logo de la empresa" />
        </CCol>
        <CCol v-if="!isEditing" xs="12">
            <CFormLabel for="email">Usuario</CFormLabel>
            <CFormInput v-model="formState.email" type="text" id="email" placeholder="Ingrese el email de la empresa" />
        </CCol>
        <CCol v-if="!isEditing" xs="12">
            <CFormLabel for="password">Contrseña</CFormLabel>
            <CFormInput v-model="formState.password" type="password" id="password"
                placeholder="Ingrese la contraseña de la empresa" />
        </CCol>
        <CContainer class="mt-4">
            <CustomLoadingButton class="btn btn-primary" type="submit" :loading="isLoading" >
                {{ props.isEditing ? 'Actualizar' : 'Guardar' }}
            </CustomLoadingButton>
        </CContainer>
    </CForm>
</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import { getCompany, saveCompany, updateCompany } from '../../services/api/companies-service';
import CustomLoadingButton from '../widgets/CustomLoadingButton.vue';
import { useAlerts } from '../../store/alert';

const alert = useAlerts();

const props = defineProps({
    isEditing: {
        type: Boolean,
        required: true,
        default: false
    },
    companyId: {
        type: Number,
        required: false,
        default: null
    },
});

const emit = defineEmits(['onSuccess']);

const isLoading = ref(false);

const formState = reactive({
    name: '',
    logo: null,
    user: '',
    password: ''
});

const loadCompany = async (id) => {
    const result = await getCompany(id);

    formState.name = result.name;
    formState.logo = result.logo;
    formState.user = result.email;
}

const sendCompany = async (event) => {
    event.preventDefault();
    isLoading.value = true;
    try {
        // validate form
        if ((props.isEditing && !formState.name || !formState.logo) ||
            (!props.isEditing && (!formState.name || !formState.logo || !formState.email || !formState.password))) {
            alert.add({ title: 'Error',  content: 'Por favor, complete todos los campos'});
        }

        // create form request
        const formData = new FormData();

        formData.append('name', formState.name);
        formData.append('logo', formState.logo);

        if (!isEditing) {
            formData.append('email', formState.email);
            formData.append('password', formState.password);
        }

        // send request
        if (props.isEditing) {
            await updateCompany(companyId.value, formData);
        } else {
            await saveCompany(formData);
        }

        alert.add({ title: 'Exito', content: 'Empresa guardada con exito' });
        emit('onSuccess');
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
}

const getFileFromInput = (event) => {
    console.log('event', event.target.files[0]);
    formState.logo = event.target.files[0];
}

watch(() => props.companyId, async () => {
    if (props.isEditing) {
        await loadCompany(props.companyId);
    }
}, { immediate: true });
</script>

<template>
    <div>
        <CForm @submit.prevent="createUser">
            <CCol xs="12">
                <CFormLabel for="name">Nombre</CFormLabel>
                <CFormInput v-model="name" type="text" id="name"
                    placeholder="Ingrese el nombre del usuario" />
            </CCol>
            <CCol xs="12">
                <CFormLabel for="email">Email</CFormLabel>
                <CFormInput v-model="email" type="text" id="email"
                    placeholder="Ingrese el email del usuario" />
            </CCol>
            <CCol xs="12">
                <CFormLabel for="password">Contraseña</CFormLabel>
                <CFormInput v-model="password" type="text" id="password"
                    placeholder="Ingrese la contraseña del usuario" />
            </CCol>

            <CustomLoadingButton type="submit" class="btn btn-primary mt-4" :isLoading="false">
                Guardar
            </CustomLoadingButton>
        </CForm>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { saveUser } from '../../services/api/companies-service'
import CustomLoadingButton from '../widgets/CustomLoadingButton.vue';

const props = defineProps({
    companyId: {
        type: Number,
        required: true
    }
});

const isLoading = ref(false);

const name = ref('');
const email = ref('');
const password = ref('');

const createUser = async () => {
    isLoading.value = true;
    try {
        await saveUser(props.companyId, {
            name: name.value,
            email: email.value,
            password: password.value
        });
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }

    // Clear form
    name.value = '';
    email.value = '';
    password.value = '';

}
</script>

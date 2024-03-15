<template>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol :md="8">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm @submit.prevent="attemptLogin">
                                    <h1>Iniciar sesion</h1>
                                    <p class="text-medium-emphasis">Inicia sesion con tu cuenta de Global Escom</p>
                                    <CInputGroup class="mb-3">
                                        <CInputGroupText>
                                            <CIcon icon="cil-user" />
                                        </CInputGroupText>
                                        <CFormInput v-model="formState.email" placeholder="Ingrese su email"
                                            autocomplete="email" />
                                    </CInputGroup>
                                    <CInputGroup class="mb-4">
                                        <CInputGroupText>
                                            <CIcon icon="cil-lock-locked" />
                                        </CInputGroupText>
                                        <CFormInput v-model="formState.password" type="password"
                                            placeholder="Ingrese su contraseña" autocomplete="current-password" />
                                    </CInputGroup>
                                    <CRow>
                                        <CCol :xs="6">
                                            <CLoadingButton type="submit" color="primary" :loading="isLoading">Iniciar sesión</CLoadingButton>
                                        </CCol>
                                    </CRow>
                                </CForm>
                            </CCardBody>
                        </CCard>
                        <CCard class="text-white py-5" style="width: 44%">
                            <CCardBody>
                                <div class="h-100 d-flex justify-content-center align-items-center"> <!-- Add text-center class -->
                                    <CImage src="/assets/logos/GLOBAL_ESCOM.png" width="200" />
                                </div>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { login } from '../services/api/auth-service';
import { useRouter } from 'vue-router';
import { useAlerts } from '../store/alert';
import { CImage } from '@coreui/vue';

const router = useRouter();
const alert = useAlerts();

const isLoading = ref(false);

const formState = reactive({
    email: '',
    password: '',
});

const attemptLogin = async () => {
    isLoading.value = true;
    try {

        // validate form
        if (!formState.email || !formState.password) {
            alert.add({ title: 'Error',  content: 'Por favor, complete todos los campos'});
            return;
        }

        await login(formState.email, formState.password);
        alert.add({ title: 'Bienvenido', content: 'Bienvenido de nuevo a Global Escom' });

        router.replace({ path: '/' });
    } catch (error) {
        alert.add({ title: 'Error', content: error.response.data?.message || 'Ocurrio un error inesperado'});
    } finally {
        isLoading.value = false;
    }
}
</script>

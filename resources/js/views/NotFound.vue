<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="6">
          <div class="clearfix">
            <h1 class="float-start display-3 me-4">404</h1>
            <h4 class="pt-3">La página no existe.</h4>
            <p class="text-medium-emphasis float-start">
                La página que estás buscando no se pudo encontrar.
            </p>
          </div>
          <CInputGroup class="input-prepend">
            <CInputGroupText>
              <CIcon icon="cil-home" />
            </CInputGroupText>
            <CButton color="info" @click="goHome">Ir al inicio</CButton>
          </CInputGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const goHome = () => {
  router.push({ path: '/' });
}
</script>

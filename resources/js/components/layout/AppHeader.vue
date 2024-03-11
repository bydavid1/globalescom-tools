<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderBrand class="mx-auto d-lg-none" to="/">
      </CHeaderBrand>
      <CHeaderNav class="d-none d-md-flex me-auto">
        <CNavItem v-if="isAdmin">
          <CNavLink href="/empresas">Empresas</CNavLink>
        </CNavItem>
      </CHeaderNav>
      <CHeaderNav>
        <CNavItem>
          <CNavLink href="#">
            <CIcon class="mx-2" icon="cil-bell" size="lg" />
          </CNavLink>
        </CNavItem>
        <AppHeaderDropdownAccnt />
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider />
    <CContainer fluid>
      <AppBreadcrumb />
    </CContainer>
  </CHeader>
</template>

<script setup>
import { computed } from 'vue';
import AppBreadcrumb from './AppBreadcrumb.vue'
import AppHeaderDropdownAccnt from './AppHeaderDropdownAccnt.vue'
import useUser from '../../composables/useUserComposable';

const isAdmin = computed(() => user.value?.role_name === 'admin');
const { user } = useUser();

</script>

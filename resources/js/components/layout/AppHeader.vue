<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <!-- <CHeaderToggler class="ps-1" @click="store.toggleSidebar">
        <CIcon icon="cil-menu" size="lg" />
      </CHeaderToggler> -->
      <CHeaderBrand class="mx-auto d-lg-none" to="/">
      </CHeaderBrand>
      <CHeaderNav class="d-none d-md-flex me-auto">
        <CNavItem v-if="isAdmin">
          <CNavLink href="/empresas">Empresas</CNavLink>
        </CNavItem>
        <CNavItem v-if="isAdmin">
          <CNavLink href="#">Herramientas</CNavLink>
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

const isAdmin = computed(() => user.value?.role === 'admin');
const { user } = useUser();

</script>

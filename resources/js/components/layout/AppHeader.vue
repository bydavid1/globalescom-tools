<template>
  <CHeader position="sticky">
    <CContainer fluid>
      <CHeaderBrand href="/">
          <CImage src="/assets/logos/GLOBAL_ESCOM.png" width="90" />
      </CHeaderBrand>
      <CHeaderNav class="d-none d-md-flex me-auto">
        <CNavItem v-if="isAdmin">
          <CNavLink href="/empresas">Empresas</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="/herramientas">Herramientas</CNavLink>
        </CNavItem>
      </CHeaderNav>
      <CHeaderNav>
        <AppHeaderDropdownAccnt />
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider v-if="!isRoot"/>
    <CContainer v-if="!isRoot" fluid >
      <AppBreadcrumb />
    </CContainer>
  </CHeader>
</template>

<script setup>
import { computed } from 'vue';
import AppBreadcrumb from './AppBreadcrumb.vue'
import AppHeaderDropdownAccnt from './AppHeaderDropdownAccnt.vue'
import useUser from '../../composables/useUserComposable';
import { useRoute } from 'vue-router';

const { user } = useUser();
const route = useRoute();

const isAdmin = computed(() => user.value?.role_name === 'admin');
const isRoot = computed(() => route.path === '/');

</script>

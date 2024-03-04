<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        store.updateSidebarVisible(event)
    "
  >
    <CSidebarBrand>
    </CSidebarBrand>
    <!-- <AppSidebarNav /> -->
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="store.toggleUnfoldable"
    />
  </CSidebar>
</template>

<script setup>
import { computed } from 'vue'
import { useLayoutStore } from '../../store/layout'

const store = useLayoutStore()

const sidebarUnfoldable = computed(() => store.sidebarUnfoldable)
const sidebarVisible = computed(() => store.sidebarVisible)
</script>

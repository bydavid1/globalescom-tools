import { defineStore } from 'pinia'

export const useLayoutStore = defineStore({
  id: 'layoutStore',
  state: () => ({
    sidebarVisible: '',
    sidebarUnfoldable: false,
  }),
  actions: {
    toggleSidebar() {
      this.sidebarVisible = !this.sidebarVisible
    },
    toggleUnfoldable() {
      this.sidebarUnfoldable = !this.sidebarUnfoldable
    },
    updateSidebarVisible(value) {
      this.sidebarVisible = value
    },
  },
})

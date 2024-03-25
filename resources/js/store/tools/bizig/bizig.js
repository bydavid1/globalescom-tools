import { defineStore } from 'pinia'

export const useBizig = defineStore({
  id: 'bizigStore',
  state: () => ({
    showAsAdmin: false,
    companyId: null,
  }),
})

import { defineStore } from 'pinia'
import { getMyCompany } from '../services/api/companies-service'

export const useCompany = defineStore({
  id: 'companyStore',
  state: () => ({
    company: {},
  }),
  actions: {
    async fetchCompanyInfo() {
        const response = await getMyCompany()
        this.company = response
    },
  },
})

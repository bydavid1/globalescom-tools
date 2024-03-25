import { defineStore } from 'pinia'
import { getMyCompany, getCompany } from '../services/api/companies-service'

export const useCompany = defineStore({
  id: 'companyStore',
  state: () => ({
    company: {},
  }),
  actions: {
    async fetchMyCompanyInfo() {
        const response = await getMyCompany()
        this.company = response
    },
    async fetchCompanyInfo(id) {
        const response = await getCompany(id)
        this.company = response
    }
  },
})

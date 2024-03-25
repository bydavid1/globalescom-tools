import { defineStore } from 'pinia'
import { getPerspectives } from '../../../services/api/tools/bizig/perspectives-service'

export const usePerspective = defineStore({
  id: 'perspectiveStore',
  state: () => ({
    perspectives: [],
    loadingPerspectives: false,
  }),
  actions: {
    async fetchPerspectives(companyId = null) {
        const response = await getPerspectives(companyId)
        this.perspectives = response
    },
  },
})

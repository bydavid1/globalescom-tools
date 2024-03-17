import { defineStore } from 'pinia'
import { getPerspectives } from '../../../services/api/tools/bizig/perspectives-service'

export const usePerspective = defineStore({
  id: 'perspectiveStore',
  state: () => ({
    perspectives: [],
  }),
  actions: {
    async fetchPerspectives() {
        const response = await getPerspectives()
        this.perspectives = response
    },
  },
})

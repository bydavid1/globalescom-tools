import { defineStore } from 'pinia'

export const useAlerts = defineStore({
  id: 'alertStore',
  state: () => ({
    alerts: [],
  }),
  getters: {
    getAlerts() {
      return this.alerts
    },
  },
  actions: {
    add(alert) {
      this.alerts.push(alert)
    },
  },
})

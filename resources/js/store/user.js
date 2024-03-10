import { defineStore } from 'pinia'

export const useUsers = defineStore({
  id: 'userStore',
  state: () => ({
    users: [],
  }),
  getters: {
    getUsers() {
      return this.users
    },
  },
  actions: {
    setUsers(users) {
      this.users = users
    }
  },
})

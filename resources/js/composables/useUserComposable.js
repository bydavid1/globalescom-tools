import { ref } from 'vue';

export default function useUser() {
  const user = ref(null);

  const getUserFromLocalStorage = () => {
    const userData = localStorage.getItem('user');
    if (userData) {
      user.value = JSON.parse(userData);
    }
  };

  const saveUserToLocalStorage = (userData) => {
    localStorage.setItem('user', JSON.stringify(userData));
    user.value = userData;
  };

  const deleteUserFromLocalStorage = () => {
    localStorage.removeItem('user');
    user.value = null;
  };

  getUserFromLocalStorage();

  return {
    user,
    saveUserToLocalStorage,
    deleteUserFromLocalStorage
  };
}

import axios from 'axios';

const BASE_URL = `${window.appUrl}/api`;

const api = axios.create({
  baseURL: BASE_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

api.interceptors.request.use((config) => {
  let user = localStorage.getItem('user');

  if (user) {
    user = JSON.parse(user);
    config.headers.Authorization = `Bearer ${user.token}`;
  }
  return config;
});

api.interceptors.response.use(
  response => {
      return response
  },
  error => {
      console.log(error);
      if (!error.response) {
          return Promise.reject(error)
      }

      if (
          error.response.status === 401 &&
          (
              error.response.data.code === 'MISSING_AUTH_TOKEN' ||
              error.response.data.code === 'INVALID_AUTH_TOKEN'
          )
      ) {
          localStorage.removeItem('token')
          window.location.href = '/login'
      } else {
          return Promise.reject(error)
      }
  }
)

export default api;

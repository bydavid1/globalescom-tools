import api from "../api"

const login = async (email, password) => {
    const response = await api.post('/auth/login', {
        email,
        password
    });

    const data = response.data;

    if (data.access_token) {
        localStorage.setItem('user', JSON.stringify(data));
    }

    return response.data;
}

export {
    login,
}

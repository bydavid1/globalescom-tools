import api from "../api"

const login = async (email, password) => {
    const response = await api.post('/auth/login', {
        email,
        password
    });

    const data = response.data;

    if (data.token) {
        console.log(data.token);
        localStorage.setItem('user', JSON.stringify(data));
    }

    return response.data;
}

const logout = async () => {
    await api.post('/auth/logout');
    localStorage.removeItem('user');
}

const me = async () => {
    const response = await api.get('/auth/me');
    return response.data;
}

export {
    login,
    logout,
    me
}

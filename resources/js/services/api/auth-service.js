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

export {
    login,
}

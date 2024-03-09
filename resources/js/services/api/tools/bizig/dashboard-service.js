import api from "../../../api"

const loadDashboard = async () => {
    const response = await api.get('/dashboard');

    return response.data;
}


export {
    loadDashboard,
}

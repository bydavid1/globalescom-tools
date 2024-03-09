import api from "../api"

const getTools = async () => {
    const response = await api.get('/tools');

    return response.data;
}

export {
    getTools,
}

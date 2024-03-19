import api from "../.."

const getPerspectives = async () => {
    const response = await api.get('/perspectives');

    return response.data;
}

const getPerspective = async (id) => {
    const response = await api.get(`/perspectives/${id}`);

    return response.data;
}

const createPerspective = async (data) => {
    const response = await api.post('/perspectives', data);

    return response.data;
}

export {
    getPerspectives,
    getPerspective,
    createPerspective
}

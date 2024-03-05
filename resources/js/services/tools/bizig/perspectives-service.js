import api from "../../api"

const getPerspectives = async () => {
    const response = await api.get('/perspectives');

    return response.data;
}

const getPerspective = async (id) => {
    const response = await api.get(`/perspectives/${id}`);

    return response.data;
}

export {
    getPerspectives,
    getPerspective
}

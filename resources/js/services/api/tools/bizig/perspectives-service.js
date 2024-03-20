import api from "../.."

const getPerspectives = async () => {
    const response = await api.get('/perspectives');

    return response.data;
}

const getPerspective = async (id) => {
    const response = await api.get(`/perspectives/${id}`);

    const perspective = response.data;

    perspective.bigs = perspective.children.filter(child => child.type === 'big');
    perspective.initiatives = perspective.children.filter(child => child.type === 'initiative');

    return perspective;
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

import api from "../.."

const createInitiative = async (data) => {
    const response = await api.post('/initiatives', data);

    return response.data;
}

export {
    createInitiative,
}

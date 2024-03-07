import api from "../../../api"

const saveBatch = async (batch) => {
    const response = await api.post('/answers/batch', batch);

    return response.data;
}

const updateBatch = async (batch) => {
    const response = await api.put('/answers/batch', batch);

    return response.data;
}

export {
    saveBatch,
    updateBatch
}

import api from "../../../api"

const saveBatch = async (batch) => {
    const response = await api.post('/answers/batch', batch);

    return response.data;
}

const updateBatch = async (batch) => {
    const response = await api.put('/answers/batch', batch);

    return response.data;
}

const getMyAnswers = async (sectionId) => {
    const response = await api.get('/answers', {
        params: {
            section_id: sectionId
        }
    });

    return response.data;
}

const getAnswersByUser = async (userId, sectionId) => {
    const response = await api.get(`/answers`, {
        params: {
            user_id: userId,
            section_id: sectionId
        }
    });

    return response.data;
}

export {
    saveBatch,
    updateBatch,
    getMyAnswers,
    getAnswersByUser
}

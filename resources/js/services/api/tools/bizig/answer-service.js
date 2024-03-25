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

const getAnswersByCompany = async (companyId, sectionId) => {
    const response = await api.get(`/answers`, {
        params: {
            company_id: companyId,
            section_id: sectionId
        }
    });

    return response.data;
}

export {
    saveBatch,
    updateBatch,
    getMyAnswers,
    getAnswersByCompany
}

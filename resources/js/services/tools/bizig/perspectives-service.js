import api from "../../api"

const getPerspectives = async () => {
    const response = await api.get('/perspectives');

    return response.data;
}

const saveAnswers = async (answers) => {
    const response = await api.post('/perspectives', answers);

    return response.data;
}

export default {
    getPerspectives,
    saveAnswers
}

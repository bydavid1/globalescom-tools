import api from "../api"

const getCompanies = async () => {
    const response = await api.get('/companies');

    return response.data;
}

const getCompany = async (id) => {
    const response = await api.get(`/companies/${id}`);

    return response.data;
}

const saveCompany = async (company) => {
    const response = await api.post('/companies', company);

    return response.data;
}

const updateCompany = async (id, company) => {
    const response = await api.put(`/companies/${id}`, company);

    return response.data;
}

export {
    getCompanies,
    getCompany,
    saveCompany,
    updateCompany
}

import api from "../../../api"

const getCompanies = async () => {
    const response = await api.get('/bizig/admin/companies');

    return response.data;
}


export {
    getCompanies,
}

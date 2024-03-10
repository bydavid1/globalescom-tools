import api from "../../../api"

const loadDashboard = async (companyId) => {
    const response = await api.get('/dashboard', {
        params: companyId ? { company_id: companyId } : undefined
    });
    return response.data;
};

export {
    loadDashboard,
};
